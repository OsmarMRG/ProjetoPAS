package com.example.projeto.API

import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST

interface ApiService {

    @POST("api/login")
    suspend fun login(@Body body: LoginRequest): Response<LoginResponse>

    @GET("api/me/camaras")
    suspend fun getMyCameras(): Response<List<CameraDto>>

    @POST("api/logout")
    suspend fun logout(): Response<Map<String, String>>
}
