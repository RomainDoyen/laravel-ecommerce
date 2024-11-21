@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <x-menu_navigation />
    </header>
    <!-- end header section -->
    <!--  -->
    <!-- shop section -->

    <div class="container my-5">
      <div class="row">
          <!-- Colonne gauche : Informations du produit -->
          <div class="col-md-6">
              <h1>{{ $produit->titre }}</h1>
              <p class="text-muted">{{ $produit->description }}</p>
              @if($produit->promotion && $produit->prix_promotionnel)
                  <h4 class="text-success">Prix promotionnel : {{ number_format($produit->prix_promotionnel, 2) }} €</h4>
                  <h4 class="text-muted badge-promo-third">Prix de base : {{ number_format($produit->prix, 2) }} €</h4>
              @else
                  <h4 class="text-muted text-decoration-line-through">Prix : {{ number_format($produit->prix, 2) }} €</h4>
              @endif
              <p>Quantité disponible : {{ $produit->quantity }}</p>
  
              <!-- Formulaire pour ajouter au panier -->
              <form action="{{ route('add_to_cart', $produit->id) }}" method="GET">
                  @csrf
                  <div class="form-group">
                      <label for="quantity">Quantité :</label>
                      <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success mt-2">Ajouter au panier</button>
              </form>
          </div>
  
          <!-- Colonne droite : Image -->
          <div class="col-md-6">
            <div class="img-box">
                <img src="{{ strpos($produit->image, 'products/') === 0 ? Storage::url($produit->image) : asset($produit->image) }}" 
             alt="{{ $produit->titre }}" 
             class="img-fluid rounded">
            </div>
          </div>

          {{-- grille de produit similaire --}}
          <div class="col-md-12">
            <h2 class="text-center mt-5 mb-5">Produits similaires</h2>
            @if($produits_similaires->isEmpty())
                <p class="text-center">Aucun produit similaire n'a été trouvé.</p>
            @else
                <div class="row">
                    @foreach($produits_similaires as $produit)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ strpos($produit->image, 'products/') === 0 ? Storage::url($produit->image) : asset($produit->image) }}" 
                                     class="card-img-top img-fluid img-thumbnail" 
                                     alt="{{ $produit->titre }}" style="max-height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produit->titre }}</h5>
                                    <p class="card-text">{{ Str::limit($produit->description, 50) }}</p>
                                    @if($produit->promotion && $produit->prix_promotionnel)
                                        <h4 class="text-success">Prix promo : {{ number_format($produit->prix_promotionnel, 2) }} €</h4>
                                        <h4 class="text-muted badge-promo-third">Prix de base : {{ number_format($produit->prix, 2) }} €</h4>
                                    @else
                                        <h4 class="text-muted">Prix : {{ number_format($produit->prix, 2) }} €</h4>
                                    @endif
                                    <a href="{{ route('front.details', $produit->id) }}" class="btn btn-primary btn-sm">Voir le produit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
          </div>        
          {{-- fin grille de produit similaire --}}

          {{-- Avis --}}
          <div class="col-md-12">
            <h2 class="text-center mt-5 mb-5">Avis des utilisateurs</h2>
            
          </div>
      </div>
    </div>
  </div>
  @endsection