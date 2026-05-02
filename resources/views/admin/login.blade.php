@extends('layout.auth')

@section('title', 'Administration — Connexion')

@section('content')
<div class="app-auth-card">
  <h1>Administration</h1>
  <p class="app-auth-sub">Connexion réservée aux comptes administrateur</p>

  @error('email')
    <div class="app-auth-flash app-auth-flash--err">{{ $message }}</div>
  @enderror

  <form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <div class="app-auth-field">
      <label for="email">Adresse e-mail</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
    </div>
    <div class="app-auth-field">
      <label for="password">Mot de passe</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
    </div>
    <button type="submit" class="app-auth-submit">Se connecter</button>
  </form>

  <div class="app-auth-links">
    <p><a href="{{ route('front.index') }}">← Retour à la boutique</a></p>
  </div>
</div>
@endsection
