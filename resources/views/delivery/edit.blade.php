@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
      <x-menu_navigation />
    </header>

    <section class="slider_section">
      <div class="slider_container">
        <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Livraison</h1>
      </div>
    </section>

    <section class="app-page-section">
      <div class="container" style="max-width:640px;">
        <h2 class="app-section-heading">Modifier l’adresse</h2>

        @if(session('success'))
            <div class="app-alert app-alert--success">{{ session('success') }}</div>
        @endif

        @if(!$deliveryInfo)
          <p class="app-section-lead"><a href="{{ route('delivery.create') }}">Ajouter une adresse</a></p>
        @else
        <div class="app-card">
          <div class="app-card__body">
            <form method="POST" action="{{ route('delivery.update') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $deliveryInfo->address) }}" required>
                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="postal_code">Code postal</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code', $deliveryInfo->postal_code) }}" required>
                    @error('postal_code') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="city">Ville</label>
                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $deliveryInfo->city) }}" required>
                    @error('city') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Téléphone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $deliveryInfo->phone) }}" required>
                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="country">Pays</label>
                    <select id="country" name="country" class="form-control" required>
                        <option value="">Choisir un pays</option>
                        <option value="France" {{ old('country', $deliveryInfo->country) == 'France' ? 'selected' : '' }}>France</option>
                        <option value="Belgium" {{ old('country', $deliveryInfo->country) == 'Belgium' ? 'selected' : '' }}>Belgique</option>
                        <option value="Germany" {{ old('country', $deliveryInfo->country) == 'Germany' ? 'selected' : '' }}>Allemagne</option>
                        <option value="Réunion" {{ old('country', $deliveryInfo->country) == 'Réunion' ? 'selected' : '' }}>Réunion</option>
                    </select>
                    @error('country') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="app-btn app-btn--primary" style="width:100%;">Enregistrer</button>
            </form>
          </div>
        </div>
        @endif
      </div>
    </section>
</div>
@endsection
