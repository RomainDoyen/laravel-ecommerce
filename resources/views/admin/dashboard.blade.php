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

    <!-- bouton ajouter un produit -->
    <a href="{{ route('admin.add') }}" class="btn btn-primary">Ajouter un produit</a>

    <!-- Tableau des produits -->
    <h2 class="mb-3 mt-5">Liste des produits</h2>
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped mb-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produits as $produit)
                <tr>
                    <td>{{ $produit->id }}</td>
                    <td>
                        <img src="{{ strpos($produit->image, 'products/') === 0 ? Storage::url($produit->image) : asset($produit->image) }}" alt="{{ $produit->titre }}" width="50" height="50">
                    </td>
                    <td>{{ $produit->titre }}</td>
                    <td>{{ Str::limit($produit->description, 50) }}</td>
                    <td>{{ number_format($produit->prix, 2) }} €</td>
                    <td>{{ $produit->quantity }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $produit->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('admin.deleteProduct', $produit->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucun produit disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
