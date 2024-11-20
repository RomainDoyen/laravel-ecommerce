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

<div class="container">
    <h1 class="mb-4 mt-5">Tableau de bord Administrateur</h1>
    <h2 class="mb-3 mt-5">Modifier un produit</h2>

    <form action="{{ route('admin.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ $product->titre }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="{{ $product->prix }}" required>
        </div>
        <div class="form-group">
            <label for="prix_promotionnel">Prix promotionnel</label>
            <input type="number" step="0.01" class="form-control" id="prix_promotionnel" name="prix_promotionnel" value="{{ $product->prix_promotionnel }}">
            <small>Ne renseignez ce champ que si une promotion est active.</small>
        </div>
        <div class="form-group">
            <label for="quantity">Quantité</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="promotion">Promotion</label>
            <select class="form-control" id="promotion" name="promotion">
                <option value="0" {{ $product->promotion == 0 ? 'selected' : '' }}>Non</option>
                <option value="1" {{ $product->promotion == 1 ? 'selected' : '' }}>Oui</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image actuelle</label>
            <div>
                <img src="{{ strpos($product->image, 'products/') === 0 ? Storage::url($product->image) : asset($product->image) }}" 
                     alt="{{ $product->titre }}" 
                     class="img-fluid" 
                     style="max-height: 200px;">
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="image">Remplacer l'image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary mb-5">Mettre à jour le produit</button>
    </form>
</div>
@endsection
