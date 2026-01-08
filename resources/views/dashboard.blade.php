@extends('layouts.app')

@section('title', 'Dashboard')

@section('container-class', 'dashboard-container')

@section('content')
<div class="card">
    <div class="dashboard-header">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger logout-btn">
                Sair
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="welcome-message">
        <h2>Bem-vindo ao Dashboard!</h2>
        <p>
            Voce esta autenticado com sucesso no sistema.<br>
            Esta e uma pagina protegida que so pode ser acessada por usuarios logados.
        </p>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: #f7fafc; border-radius: 8px;">
        <h3 style="color: #2d3748; font-size: 16px; margin-bottom: 12px;">Informacoes da Conta</h3>
        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td style="padding: 8px 0; color: #718096; width: 40%;">Nome:</td>
                <td style="padding: 8px 0; color: #2d3748; font-weight: 500;">{{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #718096;">E-mail:</td>
                <td style="padding: 8px 0; color: #2d3748; font-weight: 500;">{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #718096;">Membro desde:</td>
                <td style="padding: 8px 0; color: #2d3748; font-weight: 500;">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
