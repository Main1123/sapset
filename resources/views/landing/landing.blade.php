@extends('layouts.app')

@section('content')
<header class="header">
    <div class="header-left">
        <img src="{{ asset('img/logo_gobernacion.png') }}" alt="Gobierno Bolivariano de Trujillo Logo" class="government-logo">
    </div>
    <nav class="main-nav">
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Sobre Nosotros</a></li>
            <li><a href="#">Catálogo</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Contáctanos</a></li>
        </ul>
    </nav>
    <div class="header-right">
        <img src="{{ asset('images/sapset-logo.png') }}" alt="SAPSET Logo" class="sapset-logo">
    </div>
</header>

<main class="hero-section">
    {{-- AÑADIDO: Imágenes de fondo como etiquetas <img> --}}
    <img src="{{ asset('img/img1.png') }}" class="hero-background-image hero-background-image-left" alt="Imagen de fondo 1">
    <img src="{{ asset('img/img2.png') }}" class="hero-background-image hero-background-image-right" alt="Imagen de fondo 2">
    
    <div class="hero-content">
        <h1 class="sapset-title">SAPSET</h1>
        <p class="sapset-subtitle">Servicio Administrativo de Publicidad <br> Socialista del Estado Trujillo</p>
    </div>    
</main>

<section class="about-us">
    <div class="row container about-us">
        <div class="col-md-6 about-us-img">
            <img src="{{ asset('img/img1.png') }}" alt="">
            <img src="{{ asset('img/img2.png') }}" alt="">
        </div>
        <div class="col-md-6 about-us-text">
            <div class="text-content">
                <h2>¿Quiénes Somos?</h2>
                <p>SAPSET es el Servicio Administrativo de Publicidad Socialista del Estado Trujillo, una institución gubernamental que se encarga de gestionar y administrar los servicios públicos en el estado de Trujillo, Venezuela.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Basic Reset & Body Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
        background-color: #f4f4f4;
    }

    h1{
        font-weight: bold;
        font-size: 5rem;
    }

    /* Header Styles */
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

    .government-text {
        font-size: 0.9em;
        color: #ffffff;
        font-weight: 700;
    }

    a{
        color: #ffffff;
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
        color: #ffffff; /* Corregido: antes tenías #fffff */
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .main-nav ul li a:hover {
        color: #fffff; /* Puedes cambiar esto a un color ligeramente diferente para el hover, por ejemplo, #eee */
    }

    .sapset-logo {
        height: 60px;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        width: 100%;
        height: 600px;
        /* ELIMINADO: background-image, background-size, background-position, background-repeat de aquí */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        overflow: hidden;
        /* z-index: 1; No es estrictamente necesario aquí si los hijos tienen z-index */
        padding-bottom: 150px;
    }

    /* AÑADIDO: Estilos para las imágenes de fondo individuales */
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

    /* EXISTENTE: Capa azul de superposición */
    .hero-section::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 70%;
        
        background-color: #120587;
        z-index: 2; /* Coloca la capa azul por encima de las imágenes (z-index: 1) */
        border-radius: 50% 50% 0 0;
    }

    .hero-content {
        position: relative;
        z-index: 3; /* Asegura que el contenido (texto) esté siempre arriba de todo */
        color: #fff;
        padding-bottom: 100px;
    }

    /* Responsive adjustments (basic example) */
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
            height: 400px;
        }

        /* AÑADIDO: Ajustes responsivos para las imágenes de fondo */
        .hero-background-image {
            width: 100%; /* En móviles, las imágenes ocupan todo el ancho */
            height: 50%; /* Y cada una ocupa la mitad de la altura */
        }
        .hero-background-image-left {
            left: 0;
            top: 0; /* La primera imagen arriba */
        }
        .hero-background-image-right {
            left: 0; /* La segunda imagen también empieza a la izquierda */
            top: 50%; /* Pero se posiciona debajo de la primera */
        }

        .sapset-title {
            font-size: 2.5em;
        }

        .sapset-subtitle {
            font-size: 1.1em;
        }

        


    }
</style>
@endsection