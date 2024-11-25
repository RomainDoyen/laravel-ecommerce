@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <x-menu_navigation />
    </header>
    <!-- end header section -->
    <!-- slider section -->

    <section class="slider_section">
      <div class="slider_container">
        <h1>Informations de livraison</h1>
      </div>
    </section>

    <div class="container">
      <h1>Informations de livraison</h1>

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
      @else 
          <div class="alert alert-info">Veuillez renseigner les informations de livraison</div>
      @endif

      <form method="POST" action="{{ route('delivery.update') }}">
          @csrf
          <div class="mb-3">
              <label for="address" class="form-label">Adresse</label>
              <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
              @error('address') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
              <label for="postal_code" class="form-label">Code Postal</label>
              <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
              @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
              <label for="city" class="form-label">Ville</label>
              <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required>
              @error('city') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
              <label for="phone" class="form-label">Téléphone</label>
              <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
              @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
              <label for="country" class="form-label">Pays</label>
              <select id="country" name="country" class="form-select" required>
                  <option value="">Sélectionnez un pays</option>
                  <option value="France">France</option>
                  <option value="Belgium">Belgique</option>
                  <option value="Germany">Allemagne</option>
                  <option value="Réunion">Réunion</option>
                  <!-- Ajoute d'autres pays ici -->
              </select>
              @error('country') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <button type="submit" class="btn btn-primary">Enregistrer</button>
      </form>
    </div>
    
</div>
@endsection
