@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Mon espace</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            @if(session('success'))
                <div class="app-alert app-alert--success mb-4">{{ session('success') }}</div>
            @endif
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="app-dashboard-hero">
                        <h2 class="app-section-heading">Bienvenue</h2>
                        @auth
                            <p class="app-section-lead mb-0">
                                Bonjour <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>.
                                Gérez vos informations de livraison et consultez vos commandes depuis cette page.
                            </p>
                            <div class="app-dashboard-actions">
                                <a href="{{ route('client.orders') }}" class="app-btn app-btn--primary">Mes commandes</a>
                                <a href="{{ route('front.shop') }}" class="app-btn app-btn--outline">Continuer les achats</a>
                                <a href="{{ route('client.logout') }}" class="app-btn app-btn--outline">Déconnexion</a>
                            </div>
                        @else
                            <p class="app-section-lead">Connectez-vous pour accéder à votre espace.</p>
                            <div class="app-dashboard-actions">
                                <a href="{{ route('client.login') }}" class="app-btn app-btn--primary">Connexion</a>
                                <a href="{{ route('client.register') }}" class="app-btn app-btn--outline">Créer un compte</a>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="app-card">
                        <div class="app-card__body">
                            <h3 class="app-card__title">Livraison</h3>
                            @if ($deliveryInfo)
                                <ul class="list-unstyled small mb-3" style="color:#555;line-height:1.8;">
                                    <li><strong>Adresse</strong><br>{{ $deliveryInfo->address }}</li>
                                    <li><strong>Code postal</strong> {{ $deliveryInfo->postal_code }}</li>
                                    <li><strong>Ville</strong> {{ $deliveryInfo->city }}</li>
                                    <li><strong>Pays</strong> {{ $deliveryInfo->country }}</li>
                                    <li><strong>Téléphone</strong> {{ $deliveryInfo->phone }}</li>
                                </ul>
                                <a href="{{ route('delivery.edit') }}" class="app-btn app-btn--primary" style="width:100%;">Modifier</a>
                            @else
                                <p class="app-section-lead mb-3">Aucune adresse enregistrée.</p>
                                <a href="{{ route('delivery.create') }}" class="app-btn app-btn--primary" style="width:100%;">Ajouter une adresse</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
