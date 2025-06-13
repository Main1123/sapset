<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Sistema SAPSET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #120587;
            --secondary-color: #3498db;
            --background-color: #f8f9fa;
            --sidebar-width: 250px; /* Ancho del sidebar */
        }

        /* Asegura que el HTML y el Body ocupen toda la altura */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
        }

        /* Contenedor principal: usa Flexbox para organizar sidebar y contenido */
        #wrapper {
            display: flex; /* Habilita el modo flex */
            min-height: 100vh; /* Ocupa toda la altura de la ventana */
            overflow: hidden; /* Evita scrolls inesperados en el cuerpo principal */
        }

        /* Sidebar: Fijo a la izquierda */
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            width: var(--sidebar-width); /* Ancho fijo */
            flex-shrink: 0; /* No permite que el sidebar se encoja */
            padding: 20px 0;
            overflow-y: auto; /* Permite scroll solo si el contenido del sidebar es muy largo */
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Sombra sutil */
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
            padding-bottom: 15px; /* Ajuste para el padding vertical */
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: flex; /* Para alinear ícono y texto */
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: var(--secondary-color);
        }

        .sidebar a.active {
            background-color: var(--secondary-color);
            font-weight: bold;
        }

        /* Contenido principal: Ocupa el espacio restante a la derecha */
        .main-content {
            flex-grow: 1; /* Hace que ocupe todo el espacio sobrante */
            display: flex; /* Usa flex para la navbar y el contenido */
            flex-direction: column; /* Apila la navbar y el contenido */
            overflow-y: auto; /* Permite scroll solo si el contenido principal es muy largo */
            background-color: var(--background-color);
        }

        /* Navbar dentro del contenido principal */
        .navbar {
            background-color: var(--secondary-color);
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0; /* No permite que la navbar se encoja */
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #f0f0f0 !important;
        }

        /* Wrapper para el padding del contenido de la página */
        .page-content-wrapper {
            padding: 20px;
            flex-grow: 1; /* Permite que esta área crezca para llenar el espacio */
        }

        .content-header {
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .content-header h1 {
            color: var(--primary-color);
            font-size: 1.8em;
        }

        /* Opcional: Si quieres un comportamiento responsivo para el sidebar en móviles,
            tendrías que añadir media queries aquí para, por ejemplo, ocultarlo y
            mostrarlo con un botón en la navbar (requiere JS adicional).
            Por ahora, solo se encogerá/apilará como un elemento flex normal. */
    </style>
</head>
<body>
    <div id="wrapper">
        <div class="sidebar">
            <div class="sidebar-header text-center py-4">
                <h3 class="text-white mb-0">SAPSET</h3>
                <p class="text-white-50 mb-0">Panel de Administración</p>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('admin.home') }}" class="{{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="{{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                    <i class="fas fa-cogs me-2"></i> Servicios
                </a>
                <a href="{{ route('admin.imagenes.index') }}" class="{{ request()->routeIs('admin.imagenes.*') ? 'active' : '' }}">
                    <i class="fas fa-images me-2"></i> Imágenes
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="{{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i> Pedidos
                </a>
            </div>
        </div>

        <div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarCollapse" aria-controls="mainNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="navbar-brand" href="{{ route('admin.home') }}">
                        Panel de Administración SAPSET
                    </a>

                    <div class="collapse navbar-collapse" id="mainNavbarCollapse">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="page-content-wrapper">
                <div class="content-header">
                    <h1>@yield('header')</h1>
                </div>

                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    h3{
        font-family: 'Roboto', sans-serif;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
</style>
</body>
</html>