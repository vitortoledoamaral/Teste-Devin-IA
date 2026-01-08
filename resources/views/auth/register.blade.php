@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Criar Conta</h1>
        <p>Preencha os dados para se cadastrar</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nome</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                placeholder="Seu nome completo"
                required 
                autofocus
            >
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

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
                placeholder="Minimo 8 caracteres"
                required
            >
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Senha</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                placeholder="Repita a senha"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Cadastrar
        </button>
    </form>

    <div class="card-footer">
        <p>Ja tem uma conta? <a href="{{ route('login') }}">Entrar</a></p>
    </div>
</div>
@endsection
