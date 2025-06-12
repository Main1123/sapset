@extends('admin.layout')

@section('title', 'Perfil de Usuario')
@section('header', 'Perfil de Usuario')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Perfil de Usuario</h5>
                <a href="{{ route('admin.home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('img/default-avatar.png') }}" 
                                 alt="Avatar" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-3">
                                <h5>{{ Auth::user()->name }}</h5>
                                <p class="text-muted">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña (dejar vacío para no cambiar)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Actualizar Perfil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
