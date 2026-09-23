<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') | Sistema Ekoa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos Personalizados -->
    <style>
        :root {
            /* Color extraído de ekoa-logo.png */
            --ekoa-green: #B4C936; 
            --ekoa-dark: #333333;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: var(--ekoa-dark);
        }

        /* Clases utilitarias con los colores de la marca */
        .bg-ekoa { background-color: var(--ekoa-green) !important; color: white; }
        .text-ekoa { color: var(--ekoa-green) !important; }
        .btn-ekoa { background-color: var(--ekoa-green); color: white; border: none; font-weight: 600;}
        .btn-ekoa:hover { background-color: #9cb02b; color: white; }
        
        /* Ajuste del Navbar */
        .navbar-brand img { height: 60px; object-fit: contain; }
        .nav-link { font-weight: 500; color: var(--ekoa-dark); }
        .nav-link:hover { color: var(--ekoa-green); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <!-- Referencia al logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/ekoa-logo.png') }}" alt="Logo EKOA">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Cargar Comprobante</a></li>
                    <li class="nav-item"><a class="nav-link" href="#impacto">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Dinámico -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <img src="{{ asset('images/ekoa-logo.png') }}" alt="Logo Footer" style="height: 50px;" class="mb-3">
                    <p>Promoviendo la economía circular y la inclusión digital a través de la refuncionalización de equipamiento informático.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Contacto</h5>
                    <p class="mb-1">Email: contacto@ejemplo.edu.ar</p>
                    <p>La Plata, Buenos Aires, Argentina</p>
                </div>
            </div>
            <hr class="mt-4 mb-3">
            <div class="text-center small text-muted">
                &copy; {{ date('Y') }} Maqueta EKOA. Desarrollado en Laravel.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>