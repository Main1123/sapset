@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
<link href="{{ asset('css/landing.css') }}" rel="stylesheet">
@endsection

@section('content')
<header class="header">
    <div class="header-left">
        <img src="{{ asset('img/logo_gobernacion.png') }}" alt="Logo Gobierno Bolivariano de Trujillo" class="government-logo">
    </div>
    <nav class="main-nav">
        <ul>
            {{-- Modificamos los href para apuntar a los IDs de las secciones --}}
            <li><a href="#inicio" style="text-decoration: none;">Inicio</a></li> 
            <li><a href="#sobre-nosotros" style="text-decoration: none;">Sobre Nosotros</a></li>
            <li><a href="#servicios" style="text-decoration: none;">Servicios</a></li>
            <li><a href="#catalogo" style="text-decoration: none;">Catálogo</a></li>
            <li><a href="#contactanos" style="text-decoration: none;">Contáctanos</a></li>
            <li><a href="{{ route('login') }}" style="text-decoration: none;">Login</a></li>
        </ul>
    </nav>
    <div class="header-right">
        <img src="{{ asset('img/logosapset.png') }}" alt="Logo SAPSET" class="sapset-logo">
    </div>
</header>

<main class="hero-section" id="inicio"> {{-- Añadido el ID para "Inicio" --}}
    {{-- Imágenes de fondo --}}
    <img src="{{ asset('img/img1.png') }}" class="hero-background-image hero-background-image-left" alt="Imagen de fondo 1">
    <img src="{{ asset('img/img2.png') }}" class="hero-background-image hero-background-image-right" alt="Imagen de fondo 2">
    
    <div class="hero-content">
        <h1 class="sapset-title">SAPSET</h1>
        <p class="sapset-subtitle">Servicio Administrativo de Publicidad <br> Socialista del Estado Trujillo</p>
    </div>    
</main>

<section class="about-us" id="sobre-nosotros"> {{-- Añadido el ID para "Sobre Nosotros" --}}
    <div class="row container about-us-container">
        <div class="img col-md-6 about-us-img">
            <img src="{{ asset('img/sapset.jpeg') }}" alt="Imagen descriptiva 1" class="img-fluid">
        </div>
        <div class="col-md-6 about-us-text">
            <div class="text-content">
                <h2 style="font-weight: bold; text-shadow: 5px 2px 10px rgba(0, 0, 0, 0.5);">¿Quiénes Somos?</h2>
                <p style="font-size: 1rem;">SAPSET es el Servicio Administrativo de Publicidad Socialista del Estado Trujillo, una institución gubernamental clave en el desarrollo y la comunicación del estado. Nos encargamos de gestionar y administrar eficientemente los recursos y servicios relacionados con la publicidad y la difusión de información de interés público, asegurando que los mensajes lleguen de manera efectiva a todos los ciudadanos de Trujillo, Venezuela. Nuestra misión es promover la participación ciudadana y el bienestar social a través de estrategias comunicacionales claras y accesibles.</p>
            </div>
        </div>
    </div>
</section>

{{-- Sección: Nuestros Servicios (Renderizado con PHP Blade y con imágenes) --}}
<section class="services-section" id="servicios"> {{-- Añadido el ID para "Servicios" --}}
    <div class="container services-container">
        <h2>Los servicios que ofrecemos</h2>
        <div class="service-cards-grid">
            @forelse($servicios as $service)
                <div class="service-card">
                    {{-- Imagen del servicio --}}
                    @if($service->imagene && $service->imagene->path)
                        <img src="{{ asset('storage/' . $service->imagene->path) }}" alt="{{ $service->titulo ?? 'Servicio' }}" class="service-card-image">
                    @else
                        <img src="{{ asset('img/default-service.png') }}" alt="Sin imagen" class="service-card-image">
                    @endif
                    {{-- Título y descripción --}}
                    <div class="service-content">
                        <h3 style="font-weight: bold;">{{ $service->titulo ?? 'Servicio sin título' }}</h3>
                        <p style="font-size: 1rem;">{{ Str::limit($service->descripcion ?? '', 100) }}</p>
                        <span class="service-price">${{ number_format($service->precio ?? 0, 2) }}</span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #fff; grid-column: 1 / -1;">No hay servicios disponibles en este momento.</p>
            @endforelse
        </div>
        <button class="btn-more-services">Ver más Servicios</button>
    </div>
</section>

{{-- Nueva Sección: Carrusel de Trabajo --}}
<section class="work-carousel-section" id="catalogo">
    <div class="container work-carousel-container">
        <h2>Échale un vistazo a nuestro trabajo</h2>

        {{-- CARRUSEL DE BOOTSTRAP --}}
        <div id="workCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                {{-- Genera los indicadores dinámicamente --}}
                @foreach($imagenes as $index => $imagen)
                    <button type="button" data-bs-target="#workCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @forelse($imagenes as $index => $imagen)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $imagen->path) }}" class="d-block w-100 carousel-custom-img" alt="{{ $imagen->filename }}">
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="{{ asset('img/default-carousel.png') }}" class="d-block w-100 carousel-custom-img" alt="No hay imágenes disponibles">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>No hay imágenes disponibles en este momento.</h5>
                            <p>Por favor, sube algunas imágenes para mostrar en el carrusel.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#workCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#workCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        {{-- FIN CARRUSEL DE BOOTSTRAP --}}

        <a href="{{ asset('catalogo_de_porductos.pdf') }}" download="catalogo_de_porductos.pdf" class="btn-view-catalog" style="text-decoration: none;">Ver Catálogo</a>
    </div>
</section>

{{-- Nueva Sección: Contacto --}}
<section class="contact-section" id="contactanos"> {{-- Añadido el ID para "Contáctanos" --}}
    <div class="container contact-container">
        <h2>Contáctate con nosotros</h2>
        <div class="contact-buttons-wrapper">
            <a href="https://wa.me/584247628985" target="_blank" class="btn-contact" style="text-decoration: none;">
                <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
            </a>
            <button class="btn-contact" id="btnUbicacionOficinas" style="text-decoration: none;">Ubicación de Nuestras oficinas</button>
        </div>
        <div id="direccionOficinas" class="address-display" style="display: none; margin-top: 20px;">
            <p class="address-text text-wrap"><strong>Av. Principal Edificio SAPSET, Piso 1, Local 1, sector Timirisis, San Jacinto, Trujillo Estado Trujillo</strong></p>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="footer">
    <div class="footer-left">
        <img src="{{ asset('img/logo_gobernacion.png') }}" alt="Logo Gobierno Bolivariano de Trujillo" class="government-logo">
    </div>
    <div class="footer-center">
        <nav class="footer-nav">
            <ul>
                {{-- También puedes enlazar los del footer si quieres --}}
                <li><a href="#inicio" style="text-decoration: none;">Inicio</a></li>
                <li><a href="#sobre-nosotros" style="text-decoration: none;">Sobre Nosotros</a></li>
                <li><a href="#servicios" style="text-decoration: none;">Servicios</a></li>
                <li><a href="#catalogo" style="text-decoration: none;">Catálogo</a></li>
                <li><a href="#contactanos" style="text-decoration: none;">Contáctanos</a></li>
                <li><a href="{{ route('login') }}" style="text-decoration: none;">Login</a></li>
            </ul>
        </nav>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="copyright">All Right Copyrights Reserved</p>
    </div>
    <div class="footer-right">
        <img src="{{ asset('img/logosapset.png') }}" alt="SAPSET Logo" class="sapset-logo">
    </div>
</footer>

<style>
    /* Reinicio Básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .address-text {
        padding: 1rem;
    }
    a{
        text-decoration: none;
        link-decoration: none;
    }
    /* Estilos del Encabezado */
    .header {
        background-color: #120587;
        display: flex;
        position: sticky;
        top: 0;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        z-index: 100;
    }

    .header-left {
        display: flex;
        align-items: center;
    }

    .work-carousel-section {
        background-color: #fff; /* Fondo blanco para esta sección */
        padding: 60px 20px;
        text-align: center;
        color: #333; /* Color de texto oscuro para fondo blanco */
    }

    .work-carousel-section h2 {
        font-size: 2.8em;
        margin-bottom: 40px;
        color: #120587; /* Título en azul oscuro */
    }

    .work-carousel-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ESTILOS ESPECÍFICOS PARA EL CARRUSEL DE BOOTSTRAP */
    #workCarousel {
        margin-bottom: 40px; /* Espacio debajo del carrusel */
        border-radius: 15px; /* Bordes redondeados para todo el carrusel */
        overflow: hidden; /* Asegura que las imágenes se recorten si sus bordes exceden el radio */
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        max-height: 500px; /* Limita la altura del carrusel para que no sea excesivamente grande */
        display: flex; /* Para que el contenido interno se ajuste bien */
        align-items: center; /* Centrar verticalmente las imágenes si es necesario */
        justify-content: center; /* Centrar horizontalmente las imágenes */
    }

    .carousel-item {
        height: 500px; /* Altura de cada slide del carrusel */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0; /* Fondo si la imagen no cubre completamente */
    }

    .carousel-custom-img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* O 'cover' si prefieres que las imágenes siempre llenen el espacio, recortándose si es necesario */
                            /* 'contain' mostrará la imagen completa, añadiendo barras si la proporción no coincide */
        border-radius: 15px; /* Aplica el mismo border-radius a las imágenes */
    }

    /* Estilo para el caption cuando no hay imágenes */
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 10px;
    }

    /* Elimina el antiguo placeholder */
    .carousel-placeholder {
        display: none; /* Oculta el div de placeholder original */
    }

    .btn-view-catalog {
        background-color: #120587; /* Botón azul oscuro */
        color: #fff;
        border: none;
        padding: 15px 30px;
        border-radius: 30px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-view-catalog:hover {
        background-color: #0c035e; /* Azul más oscuro al pasar el mouse */
        transform: translateY(-2px);
    }

    /* ... tus estilos responsivos existentes ... */

    @media (max-width: 768px) {
        .carousel-item {
            height: 300px; /* Altura ajustada para móviles */
        }

        .carousel-custom-img {
             object-fit: contain; /* Mantener la imagen contenida en móviles */
        }

        /* ... otros ajustes responsivos ... */
    }

    @media (max-width: 480px) {
         .carousel-item {
            height: 200px; /* Altura aún más pequeña para pantallas muy pequeñas */
        }
        /* ... otros ajustes responsivos ... */
    }

    .government-logo {
        height: 60px;
        margin-right: 10px;
    }

    a {
        color: #ffffff;
        text-decoration: none; /* Asegura que los enlaces no tengan subrayado por defecto */
    }

    .main-nav ul {
        list-style: none;
        display: flex;
    }

    .main-nav ul li {
        margin-left: 30px;
    }

    .main-nav ul li a {
        text-decoration: none;
        color: #ffffff;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .main-nav ul li a:hover {
        color: #eee; /* Color para el hover */
    }

    .sapset-logo {
        height: 60px;
    }

    /* Sección Principal (Hero) */
    .hero-section {
        position: relative;
        width: 100%;
        height: 600px; /* Altura inicial */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        overflow: hidden;
    }

    /* Estilos para las imágenes de fondo individuales */
    .hero-background-image {
        position: absolute;
        top: 0;
        height: 100%;
        object-fit: cover; /* Asegura que la imagen cubra su espacio sin distorsión */
        z-index: 1; /* Coloca las imágenes por debajo de la capa azul y el contenido */
    }

    .hero-background-image-left {
        left: 0;
        width: 50%; /* Imagen de la izquierda ocupa la mitad del ancho */
    }

    .hero-background-image-right {
        left: 50%; /* Imagen de la derecha comienza a la mitad del ancho */
        width: 50%; /* Imagen de la derecha ocupa la otra mitad */
    }

    /* Capa azul de superposición */
    .hero-section::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 70%; /* Altura de la sección azul */
        background-color: #120587;
        z-index: 2; /* Coloca la capa azul por encima de las imágenes (z-index: 1) */
        border-radius: 50% 50% 0 0;
    }

    .hero-content {
        position: relative;
        z-index: 3; /* Asegura que el contenido (texto) esté siempre arriba de todo */
        color: #fff;
        padding-bottom: 0; /* Eliminado el padding-bottom para que se posicione bien */
        padding-top: 150px; /* Ajuste para bajar el contenido dentro de la sección azul */
        max-width: 800px; /* Limita el ancho del texto para mejor legibilidad */
        margin: 0 auto; /* Centra el contenido */
    }

    .sapset-title {
        font-size: 5.5rem; /* Ajuste de tamaño para más impacto */
        font-weight: 900; /* Mayor peso de fuente */
        letter-spacing: 3px; /* Aumento del espaciado entre letras */
        margin-bottom: 10px; /* Espacio debajo del título */
    }

    .sapset-subtitle {
        font-size: 1.6em; /* Mayor tamaño para el subtítulo */
        line-height: 1.4; /* Mejora la legibilidad */
    }

    /* Sección 'Sobre Nosotros' */
    .about-us-container { /* Clase renombrada para evitar conflictos con 'about-us' de la sección */
        padding: 50px 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .about-us-img {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px; /* Espacio para dispositivos móviles */
    }

    .about-us-img img {
        width: 100%; /* Las imágenes ocupan todo el ancho de su contenedor */
        max-width: 400px; /* Tamaño máximo para las imágenes */
        height: auto; /* Mantener la proporción */
        object-fit: cover;
        margin-bottom: 15px;
        border-radius: 8px; /* Bordes ligeramente redondeados */
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Sombra sutil */
    }

    .about-us-text {
        padding: 20px;
    }

    .about-us-text h2 {
        font-size: 2.5em;
        color: #120587;
        margin-bottom: 20px;
        text-align: start;
        font-weight: bold;
    }

    .about-us-text p {
        font-size: 1.1em;
        line-height: 1.6;
        color: #333;
        text-align: justify;
    }

    /* Nueva Sección: Servicios */
    .services-section {
        background-color: #120587; /* Fondo azul oscuro */
        padding: 60px 20px;
        text-align: center;
        color: #fff;
    }

    .services-section h2 {
        font-size: 2.8em;
        margin-bottom: 40px;
        color: #fff;
    }

    .services-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ******************************************************************* */
    /* ESTILOS PARA LAS CARDS DE SERVICIO (Renderizado por PHP Blade) */
    /* Usamos CSS Grid para un mejor control del diseño responsive */
    /* ******************************************************************* */
    .service-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* 280px es el ancho deseado min de la tarjeta */
        gap: 30px; /* Espacio entre las tarjetas */
        justify-items: center; /* Centra las tarjetas horizontalmente dentro de sus celdas */
        align-items: start; /* Alinea las tarjetas en la parte superior de sus celdas */
        margin-bottom: 40px;
        padding: 0 15px; /* Pequeño padding para los bordes en móviles */
    }

    .service-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        padding: 30px;
        min-height: 10rem; /* Aumentado la altura mínima para acomodar la imagen */
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* Alinea contenido al inicio */
        align-items: center; /* Centra el contenido horizontalmente */
        text-align: center;
        transition: transform 0.3s ease-in-out;
        width: 100%; /* Asegura que la tarjeta ocupe el ancho de su celda en la cuadrícula */
        max-width: 350px; /* Limita el ancho máximo para tarjetas individuales */
    }

    .service-card:hover {
        transform: translateY(-10px); /* Efecto de elevación al pasar el mouse */
    }

    /* ESTILO PARA LA IMAGEN DENTRO DE LA TARJETA */
    .service-card-image {
        width: 15rem; /* Ancho fijo para la imagen */
        height: 15rem; /* Altura fija para la imagen */
        object-fit: cover; /* Para asegurar que la imagen cubra el área sin distorsión */
        border-radius: 50%; 
        margin-bottom: 15px; /* Espacio debajo de la imagen */
        border: 3px solid #120587; /* Borde alrededor de la imagen */
        box-shadow: 0 2px 8px rgba(0,0,0,0.15); /* Sombra sutil para la imagen */
    }

    .service-card h3 {
        color: #120587; /* Color para el título del servicio */
        margin-bottom: 10px;
        font-size: 1.5em;
    }

    .service-card p {
        color: #666; /* Color para la descripción del servicio */
        font-size: 0.95em;
        line-height: 1.4;
        flex-grow: 1; /* Permite que la descripción ocupe el espacio disponible */
        margin-bottom: 10px; /* Añadido espacio debajo de la descripción */
    }

    .service-card .service-price {
        color: #007bff; /* Color para el precio del servicio */
        font-weight: bold;
        font-size: 1.1em;
        margin-top: auto; /* Empuja el precio hacia abajo si el contenido varía en altura */
    }

    /* Mensaje si no hay servicios */
    .service-cards-grid > p { /* Target the paragraph directly inside the grid */
        font-size: 1.2em;
        font-style: italic;
        margin: 20px 0;
    }
    /* Fin de los estilos de las cards de servicio */

    .btn-more-services {
        background-color: #f0f0f0;
        color: #120587;
        border: none;
        padding: 15px 30px;
        border-radius: 30px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-top: 30px; /* Espacio superior para el botón */
    }

    .btn-more-services:hover {
        background-color: #e0e0e0;
        color: #0c035e;
    }

    /* Nueva Sección: Carrusel de Trabajo */
    .work-carousel-section {
        background-color: #fff; /* Fondo blanco para esta sección */
        padding: 60px 20px;
        text-align: center;
        color: #333; /* Color de texto oscuro para fondo blanco */
    }

    .work-carousel-section h2 {
        font-size: 2.8em;
        margin-bottom: 40px;
        color: #120587; /* Título en azul oscuro */
    }

    .work-carousel-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .carousel-placeholder {
        background-color: #ccc; /* Color gris para el placeholder del carrusel */
        width: 100%;
        height: 400px; /* Altura del área del carrusel */
        border-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5em;
        color: #666;
        margin-bottom: 40px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .btn-view-catalog {
        background-color: #120587; /* Botón azul oscuro */
        color: #fff;
        border: none;
        padding: 15px 30px;
        border-radius: 30px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-view-catalog:hover {
        background-color: #0c035e; /* Azul más oscuro al pasar el mouse */
        transform: translateY(-2px);
    }

    /* Nueva Sección: Contacto */
    .contact-section {
        padding: 5rem;
        text-align: center;
        color: #120587;
    }

    .contact-section h2 {
        font-size: 2.8em;
        margin-bottom: 40px;
        font-weight: bold;
        color: #120587;
    }

    .contact-container {
        max-width: 100%;
        margin: 0 auto;
    }

    .contact-buttons-wrapper {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px; /* Espacio entre los botones */
    }

    .btn-contact {
        background-color: #f0f0f0;
        color: #120587;
        border: 1px solid #120587;
        padding: 15px 30px;
        border-radius: 30px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        min-width: 250px; /* Ancho mínimo para los botones */
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .btn-contact:hover {
        background-color: #e0e0e0;
        color: #0c035e;
    }

    /* Footer Styles */
    .footer {
        background-color: #120587; /* Mismo azul que el header y la sección de servicios */
        color: #fff;
        padding: 30px 5%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        border-top: 1px solid rgba(255,255,255,0.1); /* Línea sutil de separación */
    }

    .footer-left .government-logo {
        height: 60px; /* Ajuste de tamaño para el footer */
    }

    .footer-center {
        flex-grow: 1; /* Permite que ocupe el espacio disponible */
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px 0; /* Espacio para el footer central en móvil */
    }

    .footer-nav ul {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 15px;
    }

    .footer-nav ul li a {
        color: #fff;
        font-weight: 400;
        transition: color 0.3s ease;
    }

    .footer-nav ul li a:hover {
        color: #eee;
    }

    .social-icons {
        margin-bottom: 15px;
    }

    .social-icons a {
        color: #fff;
        font-size: 1.5em;
        margin: 0 10px;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #eee;
    }

    .copyright {
        font-size: 0.9em;
        opacity: 0.8;
    }

    .footer-right .sapset-logo {
        height: 70px; /* Ajuste de tamaño para el footer */
    }

    /* Ajustes Responsivos */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: center;
            padding: 10px 2%;
        }

        .main-nav ul {
            margin-top: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .main-nav ul li {
            margin: 5px 15px;
        }

        .hero-section {
            height: 500px; /* Altura ajustada para móviles */
        }

        .hero-background-image {
            width: 100%; /* En móviles, las imágenes ocupan todo el ancho */
            height: 50%; /* Y cada una ocupa la mitad de la altura */
            position: absolute; /* Asegura que la posición absoluta funcione correctamente */
        }
        .hero-background-image-left {
            left: 0;
            top: 0; /* La primera imagen arriba */
        }
        .hero-background-image-right {
            left: 0; /* La segunda imagen también empieza a la izquierda */
            top: 50%; /* Pero se posiciona debajo de la primera */
        }

        .hero-section::before {
            height: 80%; /* Ajuste de altura de la capa azul para móviles */
        }

        .hero-content {
            padding-top: 80px; /* Menos padding-top para móviles */
            font-size: 0.8em; /* Ajuste general del tamaño de fuente en hero-content */
        }

        .sapset-title {
            font-size: 3.5rem; /* Tamaño más pequeño para móviles */
        }

        .sapset-subtitle {
            font-size: 1.2em; /* Tamaño ajustado para móviles */
        }

        .about-us-img, .about-us-text {
            width: 100%; /* En móviles, los elementos ocupan todo el ancho */
        }

        .services-section h2,
        .work-carousel-section h2,
        .contact-section h2 {
            font-size: 2em;
        }
        
        /* Para móviles, asegúrate de que el grid se comporte bien */
        .service-cards-grid {
            grid-template-columns: 1fr; /* Una columna por defecto en móviles */
        }
        
        .service-card {
            width: 90%; 
            max-width: 350px; /* Limitar el ancho máximo para evitar que sea demasiado grande en tablets */
        }

        /* Ajuste de imagen para móvil */
        .service-card-image {
            width: 15rem;
            height: 15rem;
        }

        .carousel-placeholder {
            height: 250px; /* Altura ajustada para móviles */
        }

        .footer {
            flex-direction: column;
            padding: 20px 2%;
        }

        .footer-left, .footer-right {
            margin-bottom: 20px; /* Espacio entre elementos en el footer móvil */
        }

        .footer-center {
            order: -1; /* Mueve el contenido central arriba en el orden flex */
        }

        .footer-nav ul {
            flex-direction: column;
            gap: 10px;
        }

        .social-icons a {
            font-size: 1.2em;
        }
    }

    @media (max-width: 480px) {
        .sapset-title {
            font-size: 2.8rem; /* Aún más pequeño para pantallas muy pequeñas */
        }

        .sapset-subtitle {
            font-size: 1em; /* Ajuste final para subtítulo en pantallas pequeñas */
        }

        .btn-contact {
            min-width: unset; /* Quitar ancho mínimo en pantallas muy pequeñas */
            width: 100%; /* Ocupar todo el ancho disponible */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnUbicacion = document.getElementById('btnUbicacionOficinas');
        const direccionDiv = document.getElementById('direccionOficinas');

        if (btnUbicacion && direccionDiv) {
            btnUbicacion.addEventListener('click', function() {
                // Alterna la visibilidad del div de dirección
                if (direccionDiv.style.display === 'none') {
                    direccionDiv.style.display = 'block'; // O 'flex' si usas flexbox para ese div
                } else {
                    direccionDiv.style.display = 'none';
                }
            });
        }
    });
</script>