@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<!-- Hero Section -->
<section class="bg-ekoa text-center py-5 shadow-sm">
    <div class="container py-5">
        <h1 class="display-4 fw-bold text-white mb-4">Tecnología Sostenible y Economía Circular</h1>
        <p class="lead text-white mb-5 mx-auto" style="max-width: 700px;">
            Recuperamos residuos de aparatos eléctricos y electrónicos (RAEE) para darles una nueva vida útil, cuidando el medio ambiente y reduciendo la brecha digital.
        </p>
        <a href="#contacto" class="btn btn-light btn-lg text-ekoa fw-bold px-4 rounded-pill shadow-sm">Conocé más</a>
    </div>
</section>

<!-- Sección Nosotros -->
<section id="nosotros" class="container py-5 mt-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="fw-bold mb-4">Transformamos <span class="text-ekoa">Residuos</span> en <span class="text-ekoa">Oportunidades</span></h2>
            <p class="text-muted fs-5">
                Somos una iniciativa comprometida con el medio ambiente. Nuestro objetivo es gestionar de manera responsable el equipamiento informático en desuso.
            </p>
            <ul class="list-unstyled text-muted mt-4">
                <li class="mb-2">✓ Reparación y refuncionalización de PCs.</li>
                <li class="mb-2">✓ Donación a instituciones sociales y educativas.</li>
                <li class="mb-2">✓ Disposición final segura de componentes irreparables.</li>
            </ul>
        </div>
        <div class="col-lg-6 text-center">
            <!-- Usamos el logo como elemento ilustrativo -->
            <img src="{{ asset('images/ekoa-logo.png') }}" alt="EKOA UNLP Logo" class="img-fluid rounded-circle shadow-lg" style="max-width: 350px;">
        </div>
    </div>
</section>

<!-- Sección Pilares / Impacto -->
<section id="impacto" class="bg-light py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nuestros Pilares</h2>
            <p class="text-muted">El impacto de nuestras acciones en la sociedad y el ecosistema</p>
        </div>
        
        <div class="row g-4">
            <!-- Tarjeta 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="display-4 text-ekoa mb-3">🌱</div>
                        <h4 class="fw-bold">Medio Ambiente</h4>
                        <p class="text-muted">Evitamos la contaminación mitigando el impacto de los residuos electrónicos a través del reciclaje.</p>
                    </div>
                </div>
            </div>
            
            <!-- Tarjeta 2 (Destacada) -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow text-center p-4 bg-ekoa text-white transform-scale">
                    <div class="card-body">
                        <div class="display-4 mb-3">💻</div>
                        <h4 class="fw-bold text-white">Inclusión Digital</h4>
                        <p>Brindamos acceso a la tecnología a sectores vulnerables, entregando equipos listos para ser utilizados.</p>
                    </div>
                </div>
            </div>
            
            <!-- Tarjeta 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="display-4 text-ekoa mb-3">🎓</div>
                        <h4 class="fw-bold">Educación</h4>
                        <p class="text-muted">Generamos campañas de concientización y capacitamos sobre la importancia de la economía circular.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection