@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Paiement confirmé</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            @php $info = $success ?? []; @endphp
            <div class="app-card app-checkout-result">
                <div class="app-card__body py-4 px-3">
                    <div class="app-checkout-result__icon app-checkout-result__icon--ok" aria-hidden="true">
                        <i class="fa fa-check"></i>
                    </div>
                    <h2 class="app-section-heading" style="text-align:center;border:none;padding:0;margin-bottom:0.5rem;">Merci pour votre commande</h2>
                    <p class="app-section-lead" style="text-align:center;margin-left:auto;margin-right:auto;">
                        {{ $info['success'] ?? 'Votre paiement a bien été enregistré.' }}
                    </p>
                    @if(!empty($info['orderNumber']))
                        <p class="small text-muted mb-1">Numéro de commande</p>
                        <p class="app-order-badge">{{ $info['orderNumber'] }}</p>
                    @endif
                    <p class="small text-muted mb-4">Un récapitulatif est disponible dans vos commandes. Vous pouvez vider votre panier côté boutique si besoin.</p>
                    <div class="d-flex flex-wrap justify-content-center">
                        <a href="{{ route('client.orders') }}" class="app-btn app-btn--primary mr-2 mb-2">Voir mes commandes</a>
                        <a href="{{ route('front.shop') }}" class="app-btn app-btn--outline mb-2">Continuer les achats</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
