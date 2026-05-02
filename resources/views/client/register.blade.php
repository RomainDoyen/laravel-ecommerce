@extends('layout.auth')

@section('title', 'Inscription — Ecommerce')

@section('content')
<div class="app-auth-card app-auth-card--wide">
  <h1>Créer un compte</h1>
  <p class="app-auth-sub">Quelques informations pour commander sereinement</p>

  @if (session('status'))
    <div class="app-auth-flash app-auth-flash--ok">{{ session('status') }}</div>
  @endif
  @if (session('error'))
    <div class="app-auth-flash app-auth-flash--err">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('client.register.post') }}">
    @csrf
    <div class="app-auth-field app-auth-field--inline">
      <div>
        <label for="prenom">Prénom</label>
        <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required placeholder="Prénom">
        @error('prenom')
          <div class="app-auth-error">{{ $message }}</div>
        @enderror
      </div>
      <div>
        <label for="nom">Nom</label>
        <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required placeholder="Nom">
        @error('nom')
          <div class="app-auth-error">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="app-auth-field">
      <label for="email">E-mail</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="vous@exemple.fr">
      @error('email')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <div class="app-auth-field">
      <label for="passwordField">Mot de passe</label>
      <div style="position:relative">
        <input id="passwordField" type="password" name="password" required autocomplete="new-password" placeholder="Au moins 4 caractères" style="padding-right:2.5rem">
        <span style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);color:#6b6b6b;">
          <i class="fa fa-eye" id="eyeIcon" style="cursor:pointer"></i>
          <i class="fa fa-eye-slash" id="eyeSlashIcon" style="display:none;cursor:pointer"></i>
        </span>
      </div>
      @error('password')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="app-auth-submit">S’inscrire</button>
  </form>

  <div class="app-auth-links">
    <p><a href="{{ route('client.login') }}">Déjà un compte ? Se connecter</a></p>
  </div>
</div>
@endsection
