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
        <h1>Tableau de bord</h1>
      </div>
    </section>

    <!-- end slider section -->

    <section class="why_section layout_padding">
      <div class="container">
        <div class="heading_container">
          <h2>
            @if (Auth::check())
              Bienvenu(e) {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
            @else
              Veuillez vous connecter pour accéder à votre espace client.
            @endif
          </h2>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
            Accusantium, obcaecati aut magni minima velit, rerum saepe consectetur placeat 
            officiis reiciendis quas repellendus adipisci reprehenderit totam nobis odio laborum consequuntur non?
          </p>
          @auth
              <div class="btn-logout">
                <a href="{{ route('client.logout') }}">Déconnexion</a>
              </div>
          @endauth
          @guest
              <a href="{{ route('client.login') }}">Connexion ou inscription</a>
          @endguest
        </div>
      </div>
    </section>

  </div>
  <!-- end hero area -->

  <hr />

@endsection