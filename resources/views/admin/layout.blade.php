<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Sistema SAPSET</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --primary-color: #120587;
            --secondary-color: #3498db;
            --background-color: #f8f9fa;
            --sidebar-width: 250px;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            background-color: var(--primary-color);
            color: white;
            width: var(--sidebar-width);
            flex-shrink: 0;
            padding: 20px 0;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
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

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background-color: var(--background-color);
        }

        .navbar {
            background-color: var(--secondary-color);
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0;
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

        .page-content-wrapper {
            padding: 20px;
            flex-grow: 1;
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

        h3{
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
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
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')

</body>
</html>