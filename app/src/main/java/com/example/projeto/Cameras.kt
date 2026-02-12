package com.example.projeto

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Close
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import coil.ImageLoader
import coil.compose.AsyncImage
import coil.decode.GifDecoder
import coil.request.ImageRequest
import com.example.projeto.API.CameraDto
import com.example.projeto.viewmodel.UserViewModel
import kotlinx.coroutines.launch

@Composable
fun CameraContent(paddingValues: PaddingValues = PaddingValues()) {
    val userViewModel: UserViewModel = viewModel()
    val currentUser by userViewModel.currentUser.collectAsState()

    var selectedCamera by remember { mutableStateOf<CameraDto?>(null) }
    var userCameras by remember { mutableStateOf<List<CameraDto>>(emptyList()) }

    var isLoading by remember { mutableStateOf(false) }
    var errorMsg by remember { mutableStateOf<String?>(null) }

    suspend fun loadCameras() {
        isLoading = true
        errorMsg = null
        try {
            val list = userViewModel.fetchMyCameras()
            userCameras = list
            if (list.isEmpty()) {
                // Não é erro necessariamente, mas ajuda no debug
                // errorMsg = "Sem câmaras para este utilizador"
            }
        } catch (e: Exception) {
            userCameras = emptyList()
            errorMsg = "Erro a carregar câmaras: ${e.message}"
        } finally {
            isLoading = false
        }
    }

    // 🔥 IMPORTANTE: recarrega quando o utilizador muda (login/logout)
    LaunchedEffect(currentUser) {
        if (currentUser == null) {
            userCameras = emptyList()
            errorMsg = null
            isLoading = false
        } else {
            loadCameras()
        }
    }

    // Câmera expandida
    selectedCamera?.let { camera ->
        Box(
            modifier = Modifier
                .fillMaxSize()
                .background(Color.Black.copy(alpha = 0.95f)),
            contentAlignment = Alignment.Center
        ) {
            ExpandedCameraView(camera = camera, onClose = { selectedCamera = null })
        }
        return
    }

    Column(
        modifier = Modifier
            .padding(paddingValues)
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(horizontal = 16.dp)
    ) {
        Icon(
            painter = painterResource(R.drawable.videocam),
            contentDescription = "camera",
            modifier = Modifier
                .padding(top = 75.dp)
                .fillMaxWidth()
                .size(35.dp),
            tint = MaterialTheme.colorScheme.onBackground
        )

        Text(
            text = "Câmaras",
            color = MaterialTheme.colorScheme.onBackground,
            fontSize = 40.sp,
            fontWeight = FontWeight.Bold,
            textAlign = TextAlign.Center,
            modifier = Modifier
                .fillMaxWidth()
                .padding(top = 40.dp, bottom = 20.dp)
        )

        currentUser?.let { user ->
            Text(
                text = "Utilizador: ${user.username} | ${userCameras.size} câmaras",
                color = MaterialTheme.colorScheme.onBackground.copy(alpha = 0.7f),
                fontSize = 14.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(bottom = 20.dp)
            )
        } ?: run {
            Text(
                text = "Sem utilizador logado",
                color = MaterialTheme.colorScheme.onBackground.copy(alpha = 0.7f),
                fontSize = 14.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(bottom = 20.dp)
            )
        }

        // ===== Loading =====
        if (isLoading) {
            Spacer(modifier = Modifier.height(60.dp))
            CircularProgressIndicator(
                modifier = Modifier.align(Alignment.CenterHorizontally),
                color = MaterialTheme.colorScheme.primary
            )
            Spacer(modifier = Modifier.height(16.dp))
            Text(
                text = "A carregar câmaras...",
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                fontSize = 16.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier.fillMaxWidth()
            )
            return
        }

        // ===== Erro =====
        if (!errorMsg.isNullOrBlank()) {
            Spacer(modifier = Modifier.height(60.dp))
            Text(
                text = errorMsg!!,
                color = Color.Red,
                fontSize = 14.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier.fillMaxWidth()
            )
            Spacer(modifier = Modifier.height(16.dp))
            Button(
                onClick = { if (currentUser != null) {
                    // volta a tentar
                    // isto chama uma suspend, então usamos LaunchedEffect manual
                } },
                modifier = Modifier.align(Alignment.CenterHorizontally)
            ) {
                Text("Tentar outra vez")
            }

            // botão acima precisa de lançar coroutine
            LaunchedEffect(Unit) {
                // nada aqui
            }

            // solução simples: substitui o onClick com launch
            // mas em Compose puro precisamos de um scope
            // vamos fazer já aqui, sem complicar a tua vida
            val scope = rememberCoroutineScope()
            Spacer(modifier = Modifier.height(8.dp))
            Button(
                onClick = { scope.launch { loadCameras() } },
                modifier = Modifier.align(Alignment.CenterHorizontally)
            ) {
                Text("Tentar outra vez")
            }
            return
        }

        // ===== Sem câmaras =====
        if (currentUser != null && userCameras.isEmpty()) {
            Spacer(modifier = Modifier.height(80.dp))
            Text(
                text = "Nenhuma câmara atribuída a este utilizador",
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                fontSize = 16.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier.fillMaxWidth()
            )

            val scope = rememberCoroutineScope()
            Spacer(modifier = Modifier.height(16.dp))
            Button(
                onClick = { scope.launch { loadCameras() } },
                modifier = Modifier.align(Alignment.CenterHorizontally)
            ) {
                Text("Recarregar")
            }
            return
        }

        Spacer(modifier = Modifier.height(20.dp))

        LazyVerticalGrid(
            columns = GridCells.Fixed(2),
            modifier = Modifier
                .fillMaxWidth()
                .height((((userCameras.size + 1) / 2) * 240).dp),
            contentPadding = PaddingValues(8.dp)
        ) {
            items(userCameras) { camera ->
                CameraCard(camera = camera, onClick = { selectedCamera = it })
            }
        }

        Spacer(modifier = Modifier.height(40.dp))
    }
}

@Composable
fun CameraCard(camera: CameraDto, onClick: (CameraDto) -> Unit) {
    val context = LocalContext.current

    val gifRes = resolveGifRes(
        resourcesGetId = { name -> context.resources.getIdentifier(name, "drawable", context.packageName) },
        location = camera.location,
        gifKey = camera.gif_key
    )

    val imageLoader = ImageLoader.Builder(context)
        .components { add(GifDecoder.Factory()) }
        .build()

    Card(
        modifier = Modifier
            .padding(8.dp)
            .fillMaxWidth()
            .height(180.dp)
            .clickable { onClick(camera) },
        colors = CardDefaults.cardColors(containerColor = Color.Black),
        elevation = CardDefaults.cardElevation(defaultElevation = 6.dp)
    ) {
        Column(modifier = Modifier.fillMaxSize()) {
            AsyncImage(
                model = ImageRequest.Builder(context)
                    .data(gifRes)
                    .crossfade(true)
                    .build(),
                imageLoader = imageLoader,
                contentDescription = "Vídeo da ${camera.name}",
                modifier = Modifier
                    .fillMaxWidth()
                    .weight(1f)
                    .padding(8.dp)
            )

            Text(
                text = camera.name,
                color = MaterialTheme.colorScheme.onSurface,
                fontWeight = FontWeight.Bold,
                fontSize = 14.sp,
                modifier = Modifier
                    .align(Alignment.CenterHorizontally)
                    .padding(bottom = 8.dp)
            )
        }
    }
}

@Composable
fun ExpandedCameraView(camera: CameraDto, onClose: () -> Unit) {
    val context = LocalContext.current

    val gifRes = resolveGifRes(
        resourcesGetId = { name -> context.resources.getIdentifier(name, "drawable", context.packageName) },
        location = camera.location,
        gifKey = camera.gif_key
    )

    val imageLoader = ImageLoader.Builder(context)
        .components { add(GifDecoder.Factory()) }
        .build()

    Box(modifier = Modifier.fillMaxSize()) {
        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
            modifier = Modifier
                .align(Alignment.Center)
                .padding(16.dp)
        ) {
            Text(
                text = camera.name,
                color = MaterialTheme.colorScheme.onBackground,
                fontSize = 34.sp,
                fontWeight = FontWeight.SemiBold,
                lineHeight = 38.sp,
                textAlign = TextAlign.Center,
                maxLines = 2,
                overflow = TextOverflow.Ellipsis,
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(horizontal = 16.dp, vertical = 16.dp)
            )

            Surface(
                shape = MaterialTheme.shapes.medium,
                tonalElevation = 8.dp,
                shadowElevation = 8.dp,
                color = Color.Black.copy(alpha = 0.2f),
                modifier = Modifier
                    .fillMaxWidth()
                    .aspectRatio(1.6f)
            ) {
                AsyncImage(
                    model = ImageRequest.Builder(context).data(gifRes).build(),
                    imageLoader = imageLoader,
                    contentDescription = "Vídeo expandido de ${camera.name}",
                    modifier = Modifier
                        .fillMaxSize()
                        .padding(4.dp)
                )
            }

            Spacer(modifier = Modifier.height(16.dp))

            Surface(
                shape = MaterialTheme.shapes.medium,
                color = Color.Black.copy(alpha = 0.5f),
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(horizontal = 8.dp)
            ) {
                Text(
                    text = "ID: ${camera.id}\n\nLocalização: ${camera.location}\n\nGIF: ${camera.gif_key ?: "auto"}",
                    color = MaterialTheme.colorScheme.onBackground,
                    fontSize = 17.sp,
                    textAlign = TextAlign.Center,
                    modifier = Modifier.padding(12.dp)
                )
            }
        }

        IconButton(
            onClick = onClose,
            modifier = Modifier.align(Alignment.TopEnd).padding(16.dp)
        ) {
            Icon(
                imageVector = Icons.Default.Close,
                contentDescription = "Fechar",
                tint = MaterialTheme.colorScheme.onBackground
            )
        }
    }
}

private fun resolveGifRes(
    resourcesGetId: (String) -> Int,
    location: String,
    gifKey: String?
): Int {
    // 1) Se o backend mandar gif_key, usamos isso
    if (!gifKey.isNullOrBlank()) {
        val id = resourcesGetId(gifKey)
        if (id != 0) return id
    }

    // 2) Mapeamento por location
    return when (location) {
        "Sala" -> R.drawable.sala
        "Quarto" -> R.drawable.quarto
        "Estacionamento" -> R.drawable.estacionamento
        "Cozinha" -> R.drawable.cozinha
        "Quintal" -> R.drawable.quintal
        "Entrada" -> R.drawable.porta_principal
        "Receção" -> R.drawable.rececao
        "Armazém" -> R.drawable.armazem
        "Sala de Reuniões" -> R.drawable.sala_reunioes
        "Exterior" -> R.drawable.patio_exterior
        "Estacionamento_Carros" -> R.drawable.carros_estacionamento
        "Corredor" -> R.drawable.corredor
        else -> R.drawable.videocam
    }
}
