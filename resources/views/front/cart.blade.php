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
          @session('cart')
              <table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nom du produit</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ session('cart')->id }}</td>
                    <td>{{ session('cart')->titre }}</td>
                    <td>{{ session('cart')->description }}</td>
                    <td>{{ session('cart')->prix }}</td>
                    <td><img style="width: 50px; height: 50px" src="{{ session('cart')->image }}" alt="{{ session('cart')->titre }}" /></td>
                  </tr>
                </tbody>
              </table>
              <div class="btn-cart">
                <div class="btn-trash">
                  <a href="{{ route('remove_from_cart', session('cart')->id) }}">
                    Vider le panier
                  </a>
                </div>
                <div class="btn-command">
                  <a href="#">
                    Commander
                  </a>
                </div>
              </div>
          @else
              <p>
                Panier vide
              </p>
          @endsession
          <div class="btn-command">
            @guest
              <a href="{{ route('client.login') }}">Connexion ou inscription</a>
            @endguest
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end hero area -->

  <hr />

@endsection