@extends('layout.front')

@section('contentPage')
<div class="container">
    <h1>Tableau de bord Administrateur</h1>
    <h2>Modifier un produit</h2>
    <div class="logout">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-success">Revenir au Dashboard</a>
  </div>
    <form action="{{ route('admin.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ $product->titre }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" value="{{ $product->description }}" required></textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="{{ $product->prix }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantité</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" value="{{ $product->image }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour le produit</button>
    </form>
</div>
@endsection
