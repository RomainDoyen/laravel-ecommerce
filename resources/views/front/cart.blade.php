@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <x-menu_navigation />
    </header>
    <!-- end header section -->
    <!-- slider section -->

    <section class="slider_section">
      <div class="slider_container">
        <h1>Panier</h1>
      </div>
    </section>

    <!-- end slider section -->

    <section class="why_section layout_padding">
      <div class="container">
        <div class="heading_container">
          <p>
            Panier vide
          </p>
          <p>
            @guest
              <a href="{{ route('client.login') }}">Connexion ou inscription</a>
            @endguest
          </p>
        </div>
      </div>
    </section>

  </div>
  <!-- end hero area -->

  <hr />

@endsection