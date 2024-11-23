@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1>Paiement réussi !</h1>
        </div>
    </section>

    <div class="container mt-5">
        <h1>Paiement réussi !</h1>
        <p>Merci pour votre achat. Votre commande a été enregistrée.</p>
    </div>
</div>
@endsection
