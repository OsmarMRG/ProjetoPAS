package com.example.projeto.API

data class LoginRequest(
    val login: String,
    val password: String
)

data class LoginResponse(
    val token: String,
    val user: ApiUser
)

data class ApiUser(
    val user_id: Long,
    val username: String,
    val email: String
)

data class CameraDto(
    val id: Long,
    val name: String,
    val location: String,
    val gif_key: String? = null
)
