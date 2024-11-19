@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1>Panier</h1>
        </div>
    </section>

    <section class="why_section layout_padding">
        <div class="container">
            <div class="heading_container">
                @if ($carts->isNotEmpty())
                    <table class="table table-striped mb-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du produit</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Image</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->produit->id }}</td>
                                    <td>{{ $cart->produit->titre }}</td>
                                    <td>{{ $cart->produit->description }}</td>
                                    <td>{{ $cart->produit->prix }} €</td>
                                    <td>
                                      <a href="{{ route('decrement_quantity', $cart->produit->id) }}" class="btn-number mx-3">
                                        <i class="fa fa-minus"></i>
                                      </a>
                                      {{ $cart->quantity }}
                                      <a href="{{ route('increment_quantity', $cart->produit->id) }}" class="btn-number mx-3">
                                        <i class="fa fa-plus"></i>
                                      </a>
                                    </td>
                                    <td><img style="width: 50px; height: 50px" src="{{ strpos($cart->produit->image, 'products/') === 0 ? Storage::url($cart->produit->image) : asset($cart->produit->image) }}" alt="{{ $cart->produit->titre }}" /></td>
                                    <td>{{ number_format($cart->produit->prix * $cart->quantity, 2) }} €</td>
                                    <td>
                                        <a href="{{ route('remove_from_cart', $cart->produit->id) }}" class="text-danger" style="font-size: 25px;">
                                          <i class="fa fa-trash h-25"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Section Total et Commander -->
                    <div class="cart-summary">
                        <div class="summary-details">
                            <h4>Total du panier :</h4>
                            <p class="total-price">{{ number_format($total, 2) }} €</p>
                        </div>
                        <div class="btn-command mt-3">
                            <a href="#">Commander</a>
                        </div>
                    </div>
                @else
                    <p>Votre panier est vide.</p>
                    <p>Veuillez vous connecter à votre compte pour ajouter des produits.</p>
                    <a href="{{ route('client.login') }}">Se connecter</a>
                @endif

                @if (session('success'))
                    <div style="color: green;">
                      {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div style="color: red;">
                      {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection