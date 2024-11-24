@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
        <x-menu_navigation />
    </header>
    <!-- end header section -->

    <section class="slider_section">
        <div class="slider_container">
            <h1>Tableau de bord</h1>
        </div>
    </section>

    <!-- Main Section -->
    <section class="why_section layout_padding">
        <div class="container">
            <div class="row">
                <!-- Section de bienvenue -->
                <div class="col-md-8">
                    <div class="heading_container">
                        <h2>
                            @if (Auth::check())
                                Bienvenu(e) {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                            @else
                                Veuillez vous connecter pour accéder à votre espace client.
                            @endif
                        </h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Accusantium, obcaecati aut magni minima velit, rerum saepe consectetur placeat
                            officiis reiciendis quas repellendus adipisci reprehenderit totam nobis odio laborum consequuntur non?
                        </p>
                        @auth
                            <div class="btn-logout">
                                <a href="{{ route('client.logout') }}">Déconnexion</a>
                            </div>
                            <a href="{{ route('client.orders') }}">Voir mes commandes</a>
                        @endauth
                        @guest
                            <a href="{{ route('client.login') }}">Connexion ou inscription</a>
                        @endguest
                    </div>
                </div>

                <!-- Card d'informations de livraison -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informations de livraison</h4>
                        </div>
                        <div class="card-body">
                            @if ($deliveryInfo)
                                <p><strong>Adresse :</strong> {{ $deliveryInfo->address }}</p>
                                <p><strong>Code postal :</strong> {{ $deliveryInfo->postal_code }}</p>
                                <p><strong>Ville :</strong> {{ $deliveryInfo->city }}</p>
                                <p><strong>Téléphone :</strong> {{ $deliveryInfo->phone }}</p>
                                <p><strong>Pays :</strong> {{ $deliveryInfo->country }}</p>
                                <a href="{{ route('delivery.create') }}" class="btn btn-primary">Modifier les informations de livraison</a>
                            @else
                                <p>Vous n'avez pas encore ajouté d'informations de livraison.</p>
                                <a href="{{ route('delivery.create') }}" class="btn btn-primary">Ajouter</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
