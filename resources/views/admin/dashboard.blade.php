@extends('layout.front')

@section('contentPage')
<div class="container">
    <h1>Tableau de bord Administrateur</h1>

    <div class="logout">
        <a href="{{ route('admin.logout') }}" class="btn btn-danger">Déconnexion</a>
    </div>

    <!-- bouton ajouter un produit -->
    <a href="{{ route('admin.add') }}" class="btn btn-primary">Ajouter un produit</a>

    <!-- Tableau des produits -->
    <h2>Liste des produits</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
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
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->titre }}" width="50" height="50">
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
