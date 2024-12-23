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
            <h1>Dashboard</h1>
        </div>
    </section>
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
                    <th>Prix promotionnel</th>
                    <th>Quantité</th>
                    <th>Promotions</th>
                    <th>Catégorie</th>
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
                        <td>{{ $produit->promotion ? number_format($produit->prix_promotionnel, 2) . ' €' : 'Aucune' }}</td>
                        <td>{{ $produit->quantity }}</td>
                        <td>{{ $produit->promotion ? 'Oui' : 'Non' }}</td>
                        @if($produit->category)
                            <td>{{ $produit->category->name }}</td>
                        @else
                            <td>Aucune catégorie</td>
                        @endif
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

    <div class="container">

        <!-- Tableau des produits -->
        <h2 class="mb-3 mt-5">Liste des commandes</h2>
        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped mb-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Nom et Prénom</th>
                    <th>Infos de livraison</th>
                    <th>Numéro de commande</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Produits</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            Le {{ $order->created_at->format('d/m/Y') }}<br> 
                            à {{ $order->created_at->format('H:i') }}
                        </td>
                        <td>{{ $order->user->nom }} {{ $order->user->prenom }}</td>
                        <td>
                            @if($order->deliveryInfo)
                                <address>
                                    {{ $order->deliveryInfo->address }}, <br>
                                    {{ $order->deliveryInfo->postal_code }}, {{ $order->deliveryInfo->city }},<br>
                                    {{ $order->deliveryInfo->country }}
                                </address>
                                <p>Numéro de téléphone : {{ $order->deliveryInfo->phone }}</p>
                                <p>Email : {{ $order->user->email }}</p>
                            @else
                                <span>Pas d'informations de livraison</span>
                            @endif
                        </td>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ number_format($order->total, 2) }} €</td>
                        <td>
                            <ul>
                                @foreach (json_decode($order->items, true) as $item)
                                    <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune commande disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
