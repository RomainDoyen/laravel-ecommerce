@extends('layout.auth')

@section('title', 'Connexion — Ecommerce')

@section('content')
<div class="app-auth-card">
  <h1>Connexion</h1>
  <p class="app-auth-sub">Accédez à votre espace client</p>

  @if (session('error_cart'))
    <div class="app-auth-flash app-auth-flash--err">{{ session('error_cart') }}</div>
  @endif
  @if (session('error'))
    <div class="app-auth-flash app-auth-flash--err">{{ session('error') }}</div>
  @endif

  <form action="{{ route('client.login.post') }}" method="POST">
    @csrf
    <div class="app-auth-field">
      <label for="email">Adresse e-mail</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="vous@exemple.fr">
      @error('email')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <div class="app-auth-field">
      <label for="passwordField">Mot de passe</label>
      <div style="position:relative">
        <input id="passwordField" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" style="padding-right:2.5rem">
        <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);color:#6b6b6b;">
          <i class="fa fa-eye" id="eyeIcon" style="cursor:pointer" aria-hidden="true"></i>
          <i class="fa fa-eye-slash" id="eyeSlashIcon" style="display:none;cursor:pointer" aria-hidden="true"></i>
        </span>
      </div>
      @error('password')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="app-auth-submit">Se connecter</button>
  </form>

  <div class="app-auth-links">
    <p><a href="{{ route('client.forgot-password') }}">Mot de passe oublié ?</a></p>
    <p><a href="{{ route('client.register') }}">Pas encore de compte ? S’inscrire</a></p>
  </div>
</div>
@endsection
