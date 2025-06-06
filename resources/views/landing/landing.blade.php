@extends('layouts.app')

@section('content')
<header class="header">
    <div class="header-left">
        <img src="{{ asset('images/government-logo.png') }}" alt="Gobierno Bolivariano de Trujillo Logo" class="government-logo">
        <span class="government-text">Gobierno Bolivariano <br> de Trujillo</span>
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
    <div class="hero-content">
        <h1 class="sapset-title">SAPSET</h1>
        <p class="sapset-subtitle">Servicio Administrativo de Publicidad <br> Socialista del Estado Trujillo</p>
    </div>
</main>

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
            /* color: #333; */
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
            color: #fffff;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .main-nav ul li a:hover {
            color: #fffff;
        }

        .sapset-logo {
            height: 60px;
        }

        /* Hero Section (the large blue and image area) */
        .hero-section {
            position: relative;
            width: 100%;
            height: 600px;
            background-image: url('{{ asset("images/your-background-image.jpg") }}');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            z-index: 1;
            padding-bottom: 150px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 70%;
            background-color: #120587;
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            color: #fff;
            padding-bottom: 100px;
        }

        .sapset-title {
            font-size: 4em;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .sapset-subtitle {
            font-size: 1.5em;
            font-weight: 400;
            line-height: 1.4;
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

            .sapset-title {
                font-size: 2.5em;
            }

            .sapset-subtitle {
                font-size: 1.1em;
            }
        }
</style>
@endsection