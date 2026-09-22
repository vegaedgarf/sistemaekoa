<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Seguimiento EKOA</title>
    @vite(['resources/js/app.js'])
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-custom { background-color: #2c3e50; }
        .hero-card {
            background-color: #ffffff;
            border-top: 4px solid #3498db;
            border-radius: 8px;
        }
        .module-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 6px;
        }
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .main-content { flex: 1; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <!-- Espacio reservado para el logo de EKOA -->
                <img src="{{ asset('images/ekoa-logo.png') }}" alt="Logo EKOA" height="40" class="me-2">
                EKOA Stock
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Cargar Recepción</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn btn-outline-light btn-sm px-3 mt-1 mt-lg-0" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container main-content">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 hero-card p-5 shadow-sm">
                <div class="text-center mb-5">
                    <h1 class="fw-bold text-dark mb-3">Gestión y Trazabilidad de RAEE</h1>
                    <p class="lead text-muted">
                        Plataforma centralizada para la administración del ciclo de vida de componentes electrónicos.
                    </p>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm module-card">
                            <div class="card-body p-4 text-center">
                                <h5 class="card-title text-primary fw-bold mb-3">Recepción y Control</h5>
                                <p class="card-text text-muted small mb-4">
                                    Generación de comprobantes, carga en lote y emisión de códigos QR.
                                </p>
                                <a href="#" class="btn btn-primary w-100 py-2">Ingresar Material</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm module-card">
                            <div class="card-body p-4 text-center">
                                <h5 class="card-title text-success fw-bold mb-3">Inventario de Stock</h5>
                                <p class="card-text text-muted small mb-4">
                                    Consulta de perfiles de hardware, trazabilidad y procesos de despiece.
                                </p>
                                <a href="#" class="btn btn-success w-100 py-2">Explorar Inventario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <!-- Datos de Contacto -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="text-uppercase fw-bold mb-3">Contacto EKOA</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> [Dirección exacta de EKOA]</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> [Teléfono de EKOA]</li>
                    </ul>
                </div>
                
                <!-- Redes Sociales -->
                <div class="col-md-6 text-md-end">
                    <h6 class="text-uppercase fw-bold mb-3">Nuestras Redes</h6>
                    <a href="[LINK_INSTAGRAM]" class="text-light me-3 fs-5" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="[LINK_FACEBOOK]" class="text-light me-3 fs-5" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="[LINK_TWITTER]" class="text-light fs-5" target="_blank"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
            <div class="row mt-3 border-top border-secondary pt-3">
                <div class="col-12 text-center text-muted small">
                    &copy; {{ date('Y') }} EKOA. Todos los derechos reservados.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>