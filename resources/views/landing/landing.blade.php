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
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Sobre Nosotros</a></li>
            <li><a href="#">Catálogo</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Contáctanos</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    </nav>
    <div class="header-right">
        <img src="{{ asset('img/logosapset.png') }}" alt="Logo SAPSET" class="sapset-logo">
    </div>
</header>

<main class="hero-section">
    {{-- Imágenes de fondo --}}
    <img src="{{ asset('img/img1.png') }}" class="hero-background-image hero-background-image-left" alt="Imagen de fondo 1">
    <img src="{{ asset('img/img2.png') }}" class="hero-background-image hero-background-image-right" alt="Imagen de fondo 2">
    
    <div class="hero-content">
        <h1 class="sapset-title">SAPSET</h1>
        <p class="sapset-subtitle">Servicio Administrativo de Publicidad <br> Socialista del Estado Trujillo</p>
    </div>    
</main>

<section class="about-us">
    <div class="row container about-us-container"> {{-- Clase modificada para evitar conflicto --}}
        <div class="img col-md-6 about-us-img">
            <img src="{{ asset('img/sapset.jpeg') }}" alt="Imagen descriptiva 1" class="img-fluid">
            {{-- <img src="{{ asset('img/sapset.jpeg') }}" alt="Imagen descriptiva 2" class="img-fluid"> --}}
        </div>
        <div class="col-md-6 about-us-text">
            <div class="text-content">
                <h2>¿Quiénes Somos?</h2>
                <p>SAPSET es el Servicio Administrativo de Publicidad Socialista del Estado Trujillo, una institución gubernamental clave en el desarrollo y la comunicación del estado. Nos encargamos de gestionar y administrar eficientemente los recursos y servicios relacionados con la publicidad y la difusión de información de interés público, asegurando que los mensajes lleguen de manera efectiva a todos los ciudadanos de Trujillo, Venezuela. Nuestra misión es promover la participación ciudadana y el bienestar social a través de estrategias comunicacionales claras y accesibles.</p>
            </div>
        </div>
    </div>
</section>

{{-- Nueva Sección: Nuestros Servicios --}}
<section class="services-section">
    <div class="container services-container">
        <h2>Los servicios que ofrecemos</h2>
        <div class="service-cards-wrapper">
            <div class="service-card">
                {{-- Contenido de la tarjeta de servicio 1 --}}
                <div class="service-placeholder"></div>
            </div>
            <div class="service-card">
                {{-- Contenido de la tarjeta de servicio 2 --}}
                <div class="service-placeholder"></div>
            </div>
            <div class="service-card">
                {{-- Contenido de la tarjeta de servicio 3 --}}
                <div class="service-placeholder"></div>
            </div>
        </div>
        <button class="btn-more-services">Ver más Servicios</button>
    </div>
</section>

{{-- Nueva Sección: Carrusel de Trabajo --}}
<section class="work-carousel-section">
    <div class="container work-carousel-container">
        <h2>Échale un vistazo a nuestro trabajo</h2>
        <div class="carousel-placeholder">
            {{-- Aquí iría la implementación del carrusel de imágenes (ej. con Swiper.js, Owl Carousel, etc.) --}}
            {{-- Por ahora, es un placeholder visual --}}
            <p>Contenido del carrusel de imágenes</p>
        </div>
        <button class="btn-view-catalog">Ver Catálogo</button>
    </div>
</section>

{{-- Nueva Sección: Contacto --}}
<section class="contact-section">
    <div class="container contact-container">
        <h2>Contáctate con nosotros</h2>
        <div class="contact-buttons-wrapper">
            <button class="btn-contact">Mensaje vía WhatsApp</button>
            <button class="btn-contact">Ubicación de Nuestras oficinas</button>
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
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Sobre Nosotros</a></li>
                <li><a href="#">Catálogo</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contáctanos</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </nav>
        <div class="social-icons">
            {{-- Usar Font Awesome para los iconos sociales. Asegúrate de que Font Awesome esté enlazado en 'layouts.app' o aquí --}}
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

    /* Estilos del Encabezado */
    .header {
        background-color: #120587;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        position: relative;
        z-index: 100;
    }

    .header-left {
        display: flex;
        align-items: center;
    }

    .government-logo {
        height: 50px;
        margin-right: 10px;
    }

    /* .government-text { Este estilo no se usa en el HTML proporcionado, se puede eliminar si no es necesario.
        font-size: 0.9em;
        color: #ffffff;
        font-weight: 700;
    } */

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

    .service-cards-wrapper {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px; /* Espacio entre las tarjetas */
        margin-bottom: 40px;
    }

    .service-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        padding: 30px;
        width: 300px; /* Ancho fijo para las tarjetas */
        height: 200px; /* Altura fija para las tarjetas */
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s ease-in-out;
    }

    .service-card:hover {
        transform: translateY(-10px); /* Efecto de elevación al pasar el mouse */
    }

    .service-placeholder {
        width: 100%;
        height: 100%;
        background-color: #ccc; /* Color gris para el placeholder */
        border-radius: 10px;
    }

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
        /* background-color: #120587; Fondo azul oscuro */
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
        /* height: 10rem; */
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

        .service-cards-wrapper {
            flex-direction: column; /* Apilar tarjetas en móviles */
            align-items: center;
        }

        .service-card {
            width: 90%; /* Ocupar casi todo el ancho en móviles */
            max-width: 300px; /* Limitar ancho máximo */
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
@endsection
