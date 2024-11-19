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
              <h4 class="text-primary">Prix : {{ number_format($produit->prix, 2) }} €</h4>
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
      </div>
    </div>

  </div>
  @endsection