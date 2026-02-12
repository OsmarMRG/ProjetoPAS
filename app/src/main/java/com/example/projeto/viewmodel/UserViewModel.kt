package com.example.projeto.viewmodel

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.viewModelScope
import com.example.projeto.API.ApiClient
import com.example.projeto.API.ApiService
import com.example.projeto.API.TokenStore
import com.example.projeto.API.LoginRequest
import com.example.projeto.API.CameraDto
import com.example.projeto.database.AppDatabase
import com.example.projeto.database.entities.User
import com.example.projeto.repository.UserRepository
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import java.util.Date

class UserViewModel(application: Application) : AndroidViewModel(application) {

    // Mantém Room só para não partir screens antigas (registo local, etc)
    private val repository: UserRepository

    private val _currentUser = MutableStateFlow<User?>(null)
    val currentUser: StateFlow<User?> = _currentUser.asStateFlow()

    private val _loginState = MutableStateFlow<LoginState>(LoginState.Idle)
    val loginState: StateFlow<LoginState> = _loginState.asStateFlow()

    private val _registerState = MutableStateFlow<RegisterState>(RegisterState.Idle)
    val registerState: StateFlow<RegisterState> = _registerState.asStateFlow()

    // ===== API (Retrofit + Token) =====
    private val tokenStore = TokenStore(application.applicationContext)
    private val api: ApiService

    init {
        val database = AppDatabase.getDatabase(application)
        repository = UserRepository(database.userDao())

        // ⚠️ EMULADOR:
        val baseUrl = "http://10.0.2.2:8000/"


        api = ApiClient.create(baseUrl, tokenStore)
    }

    fun login(username: String, password: String) {
        viewModelScope.launch {
            _loginState.value = LoginState.Loading

            if (username.isBlank() || password.isBlank()) {
                _loginState.value = LoginState.Error("Por favor preenche tudo")
                return@launch
            }

            try {
                val res = api.login(LoginRequest(login = username, password = password))

                if (res.isSuccessful && res.body() != null) {
                    val body = res.body()!!

                    // guarda token do Sanctum
                    tokenStore.save(body.token)

                    // cria User para UI com o formato do teu Entity (Room)
                    val now = Date()
                    val userLocal = User(
                        userId = body.user.user_id.toInt(),
                        username = body.user.username,
                        passwordHash = "", // não guardes password
                        email = body.user.email,
                        role = "user",
                        createdAt = now,
                        updatedAt = now,
                        lastLogin = now,
                        status = "active"
                    )

                    _currentUser.value = userLocal
                    _loginState.value = LoginState.Success
                } else {
                    _loginState.value = LoginState.Error("Username ou palavra passe incorretos")
                }
            } catch (e: Exception) {
                _loginState.value = LoginState.Error("Erro de rede: ${e.message}")
            }
        }
    }

    fun logout() {
        viewModelScope.launch {
            try { api.logout() } catch (_: Exception) {}

            tokenStore.clear()
            _currentUser.value = null
            _loginState.value = LoginState.Idle
        }
    }

    // === buscar câmaras reais do utilizador (Laravel) ===
    suspend fun fetchMyCameras(): List<CameraDto> {
        return try {
            val res = api.getMyCameras()
            if (res.isSuccessful && res.body() != null) res.body()!! else emptyList()
        } catch (_: Exception) {
            emptyList()
        }
    }

    // ====== O resto mantém (mas isto ainda mexe na BD local, não no Laravel) ======

    fun setLoggedIn() {
        _loginState.value = LoginState.Success
    }

    fun updateEmail(newEmail: String) {
        viewModelScope.launch {
            try {
                _currentUser.value?.let { user ->
                    repository.updateEmail(user.userId, newEmail)
                    _currentUser.value = user.copy(email = newEmail, updatedAt = Date())
                }
            } catch (_: Exception) {}
        }
    }

    fun updatePassword(newPassword: String) {
        viewModelScope.launch {
            try {
                _currentUser.value?.let { user ->
                    repository.updatePassword(user.userId, newPassword)
                }
            } catch (_: Exception) {}
        }
    }

    fun registerUser(username: String, password: String, email: String) {
        viewModelScope.launch {
            _registerState.value = RegisterState.Loading
            try {
                if (username.isEmpty() || password.isEmpty() || email.isEmpty()) {
                    _registerState.value = RegisterState.Error("Por favor, preencha todos os campos")
                    return@launch
                }

                if (password.length < 6) {
                    _registerState.value = RegisterState.Error("Palavra-passe deve ter pelo menos 6 caracteres")
                    return@launch
                }

                val existingUser = repository.getUserByUsername(username)
                if (existingUser != null) {
                    _registerState.value = RegisterState.Error("Utilizador já existe")
                    return@launch
                }

                val user = repository.registerUser(username, password, email)
                if (user != null) {
                    _currentUser.value = user
                    _registerState.value = RegisterState.Success
                } else {
                    _registerState.value = RegisterState.Error("Erro ao registar utilizador")
                }
            } catch (e: Exception) {
                _registerState.value = RegisterState.Error("Erro: ${e.message}")
            }
        }
    }

    fun resetRegisterState() {
        _registerState.value = RegisterState.Idle
    }
}

sealed class LoginState {
    object Idle : LoginState()
    object Loading : LoginState()
    object Success : LoginState()
    data class Error(val message: String) : LoginState()
}

sealed class RegisterState {
    object Idle : RegisterState()
    object Loading : RegisterState()
    object Success : RegisterState()
    data class Error(val message: String) : RegisterState()
}
