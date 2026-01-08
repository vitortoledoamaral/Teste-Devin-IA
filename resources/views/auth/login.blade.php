@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Entrar</h1>
        <p>Acesse sua conta para continuar</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">E-mail</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="seu@email.com"
                required 
                autofocus
            >
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="Sua senha"
                required
            >
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label for="remember">Lembrar de mim</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Entrar
        </button>
    </form>

    <div class="card-footer">
        <p>Nao tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
    </div>
</div>
@endsection
