package com.example.projeto.repository

import com.example.projeto.API.ApiService

class RemoteCamerasDataSource(private val api: ApiService) {
    suspend fun getMyCameras() = api.getMyCameras()
}
