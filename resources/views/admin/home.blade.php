@extends('admin.layout')

@section('title', 'Dashboard')

@section('header', 'Dashboard Principal')

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card text-white bg-info shadow-sm h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Total Servicios</h5>
                        <p class="card-text fs-2 fw-bold">{{ $totalServicios }}</p>
                    </div>
                    <i class="fas fa-cogs fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25">
                <a href="{{ route('admin.servicios.index') }}" class="text-white text-decoration-none">Ver Detalles <i class="fas fa-arrow-circle-right ms-2"></i></a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card text-white bg-warning shadow-sm h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Pedidos Pendientes</h5>
                        <p class="card-text fs-2 fw-bold">{{ $pedidosPendientes }}</p>
                    </div>
                    <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25">
                <a href="{{ route('admin.pedidos.index') }}" class="text-white text-decoration-none">Ver Pedidos <i class="fas fa-arrow-circle-right ms-2"></i></a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
        <div class="card text-white bg-success shadow-sm h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Imágenes Cargadas</h5>
                        <p class="card-text fs-2 fw-bold">{{ $imagenesCargadas }}</p>
                    </div>
                    <i class="fas fa-images fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25">
                <a href="{{ route('admin.imagenes.index') }}" class="text-white text-decoration-none">Ver Imágenes <i class="fas fa-arrow-circle-right ms-2"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection