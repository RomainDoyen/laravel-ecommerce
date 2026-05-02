@extends('layout.auth')

@section('title', 'Mot de passe oublié — Ecommerce')

@section('content')
<div class="app-auth-card">
  <h1>Mot de passe oublié</h1>
  <p class="app-auth-sub">Indiquez votre e-mail pour recevoir un lien de réinitialisation</p>

  <form action="{{ route('client.handleResetPassword') }}" method="POST">
    @csrf
    <div class="app-auth-field">
      <label for="email">Adresse e-mail</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="vous@exemple.fr">
      @error('email')
        <div class="app-auth-error">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="app-auth-submit">Envoyer le lien</button>
  </form>

  <div class="app-auth-links">
    <p><a href="{{ route('client.login') }}">← Retour à la connexion</a></p>
  </div>
</div>
@endsection
