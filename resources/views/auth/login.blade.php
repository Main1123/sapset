@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-box">
        <h2 class="login-title">Iniciar Sesión</h2>
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email" class="sr-only">Correo Electrónico</label>
                <input id="email" type="email" class="login-input @error('email') login-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="login-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password" class="sr-only">Contraseña</label>
                <input id="password" type="password" class="login-input @error('password') login-error @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="login-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" class="login-checkbox" name="remember">
                    <span class="login-checkbox-label">Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="login-link" href="{{ route('password.request') }}">
                        Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <button type="submit" class="login-button">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f7fafc;
    padding: 20px;
}

.login-box {
    max-width: 400px;
    width: 100%;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.login-title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #1a202c;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.login-input {
    width: 100%;
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.2s;
}

.login-input:focus {
    outline: none;
    border-color: #120587;
}

.login-button {
    width: 100%;
    padding: 12px;
    background-color: #120587;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.2s;
}

.login-button:hover {
    background-color: #120587;
}

.login-link {
    color: #120587;
    text-decoration: none;
    font-size: 14px;
}

.login-link:hover {
    color: #120587;
}

.login-checkbox {
    margin-right: 8px;
}

.login-checkbox-label {
    font-size: 14px;
    color: #4a5568;
}

.login-error {
    color: #e53e3e;
    font-size: 14px;
    margin-top: 5px;
}
</style>
@endsection
