@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <x-menu_navigation />
    </header>
    <!-- end header section -->
    <!--  -->
    <!-- shop section -->

<section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Liste des 4 derniers produits
        </h2>
      </div>
      <div class="row">
        @foreach ($produits as $produit)
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="box">
              <a href="">
                <div class="img-box">
                  <img src="{{ $produit->image }}" alt="{{ $produit->titre }}">
                </div>
                <div class="detail-box">
                  <h6>
                    {{ $produit->titre }}
                  </h6>
                  <h6>
                    Prix
                    <span>
                      {{ $produit->prix }} €
                    </span>
                  </h6>
                </div>
                <div class="new">
                  <span>
                    New
                  </span>
                </div>
              </a>
          </div>
        </div>
        @endforeach
      </div>
      <div class="btn-box">
        <a href="">
          View All Products
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->

</div>
@endsection