@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Paiement interrompu</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            <div class="app-card app-checkout-result">
                <div class="app-card__body py-4 px-3">
                    <div class="app-checkout-result__icon app-checkout-result__icon--cancel" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </div>
                    <h2 class="app-section-heading" style="text-align:center;border:none;padding:0;margin-bottom:0.5rem;">Paiement non finalisé</h2>
                    <p class="app-section-lead" style="text-align:center;margin-left:auto;margin-right:auto;">
                        Vous avez quitté la page de paiement Stripe ou le paiement n’a pas abouti. Aucun débit n’a été effectué.
                    </p>
                    <p class="small text-muted mb-4">Vos articles restent dans le panier tant que vous ne les modifiez pas.</p>
                    <div class="d-flex flex-wrap justify-content-center">
                        <a href="{{ route('front.cart') }}" class="app-btn app-btn--primary mr-2 mb-2">Retour au panier</a>
                        <a href="{{ route('front.shop') }}" class="app-btn app-btn--outline mb-2">Retour à la boutique</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
