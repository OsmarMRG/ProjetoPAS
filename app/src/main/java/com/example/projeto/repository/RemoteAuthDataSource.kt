package com.example.projeto.repository

import com.example.projeto.API.ApiService
import com.example.projeto.API.LoginRequest

class RemoteAuthDataSource(private val api: ApiService) {
    suspend fun login(login: String, password: String) =
        api.login(LoginRequest(login, password))

    suspend fun logout() = api.logout()
}
