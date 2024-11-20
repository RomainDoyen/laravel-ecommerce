@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <x-menu_navigation />
    </header>
    <!-- end header section -->
    <section class="slider_section">
        <div class="slider_container">
            <h1>Ajouter un produit</h1>
        </div>
    </section>
    <!--  -->
    <!-- shop section -->

    <div class="container">
        <h1 class="mb-4 mt-5">Tableau de bord Administrateur</h1>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire pour ajouter un produit -->
        <h2 class="mb-4 mt-5">Ajouter un produit</h2>
        <form action="{{ route('admin.addProduct') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="prix_promotionnel">Prix promotionnel</label>
                <input type="number" step="0.01" class="form-control" id="prix_promotionnel" name="prix_promotionnel">
                <small>Ne renseignez ce champ que si une promotion est active.</small>
            </div>        
            <div class="form-group">
                <label for="quantity">Quantité</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="promotion">Promotion</label>
                <select class="form-control" id="promotion" name="promotion">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Ajouter le produit</button>
        </form>
    </div>
@endsection
