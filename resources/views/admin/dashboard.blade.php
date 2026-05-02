@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
      <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Administration</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            <div class="app-admin-toolbar">
                <div>
                    <h2 class="app-section-heading mb-0">Produits</h2>
                    <p class="app-section-lead mb-0 mt-1">Catalogue et stocks</p>
                </div>
                <a href="{{ route('admin.add') }}" class="app-btn app-btn--primary">Ajouter un produit</a>
            </div>

            @if(session('success'))
                <div class="app-alert app-alert--success">{{ session('success') }}</div>
            @endif

            <div class="app-table-wrap mb-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Promo</th>
                                <th>Qté</th>
                                <th>Promo active</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produits as $produit)
                                <tr>
                                    <td>{{ $produit->id }}</td>
                                    <td>
                                        <img src="{{ strpos($produit->image, 'products/') === 0 ? Storage::url($produit->image) : asset($produit->image) }}" alt="" width="48" height="48" style="object-fit:cover;border-radius:8px;">
                                    </td>
                                    <td>{{ $produit->titre }}</td>
                                    <td>{{ Str::limit($produit->description, 50) }}</td>
                                    <td>{{ number_format($produit->prix, 2) }} €</td>
                                    <td>{{ $produit->promotion ? number_format($produit->prix_promotionnel, 2) . ' €' : '—' }}</td>
                                    <td>{{ $produit->quantity }}</td>
                                    <td>{{ $produit->promotion ? 'Oui' : 'Non' }}</td>
                                    <td>{{ $produit->category?->name ?? '—' }}</td>
                                    <td style="white-space:nowrap;">
                                        <a href="{{ route('admin.edit', $produit->id) }}" class="app-btn app-btn--warn app-btn--sm">Modifier</a>
                                        <form action="{{ route('admin.deleteProduct', $produit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="app-btn app-btn--danger app-btn--sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">Aucun produit</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="app-section-heading">Commandes</h2>
            <p class="app-section-lead">Historique des commandes clients</p>

            <div class="app-table-wrap">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Livraison</th>
                                <th>N° commande</th>
                                <th>Statut</th>
                                <th>Total</th>
                                <th>Articles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        {{ $order->created_at->format('d/m/Y') }}<br>
                                        <span class="text-muted small">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    <td>{{ $order->user->nom }} {{ $order->user->prenom }}</td>
                                    <td style="min-width:200px;">
                                        @if($order->deliveryInfo)
                                            <small>
                                                {{ $order->deliveryInfo->address }},<br>
                                                {{ $order->deliveryInfo->postal_code }} {{ $order->deliveryInfo->city }}, {{ $order->deliveryInfo->country }}<br>
                                                Tél. {{ $order->deliveryInfo->phone }}<br>
                                                {{ $order->user->email }}
                                            </small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ number_format($order->total, 2) }} €</td>
                                    <td>
                                        <ul class="mb-0 pl-3 small">
                                            @foreach (json_decode($order->items, true) ?? [] as $item)
                                                <li>{{ $item['name'] ?? '—' }} ×{{ $item['quantity'] ?? 0 }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Aucune commande</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
