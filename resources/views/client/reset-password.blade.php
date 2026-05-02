@extends('layout.auth')

@section('title', 'Nouveau mot de passe — Ecommerce')

@section('content')
<div class="app-auth-card">
  <h1>Nouveau mot de passe</h1>
  <p class="app-auth-sub">Choisissez un mot de passe sécurisé</p>

  <form action="{{ route('client.reset-password.post') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="app-auth-field">
      <label for="email">E-mail</label>
      <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autocomplete="email">
      @error('email')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <div class="app-auth-field">
      <label for="password">Nouveau mot de passe</label>
      <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
      @error('password')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <div class="app-auth-field">
      <label for="password_confirmation">Confirmation</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
    </div>
    <button type="submit" class="app-auth-submit">Enregistrer</button>
  </form>

  <div class="app-auth-links">
    <p><a href="{{ route('client.login') }}">← Retour à la connexion</a></p>
  </div>
</div>
@endsection
