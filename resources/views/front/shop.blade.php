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

    <section class="slider_section">
      <div class="slider_container">
          <h1>Boutique</h1>
      </div>
    </section>

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Liste des produits
        </h2>
      </div>
      <div class="row">
        @foreach ($produits as $produit)
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="box rounded">
              <a href="{{ route('front.details', $produit->id) }}">
                <div class="img-box">
                  <img src="{{ strpos($produit->image, 'products/') === 0 ? Storage::url($produit->image) : asset($produit->image) }}" alt="{{ $produit->titre }}" />
                </div>
                <div class="detail-box">
                  <h6>
                    {{ $produit->titre }}
                  </h6>
                  <h6>
                    @if($produit->promotion && $produit->prix_promotionnel)
                      <div class="d-flex flex-column">
                          <span class="badge badge-secondary badge-promo-secondary">
                              {{ number_format($produit->prix, 2) }} €
                          </span>
                          <span class="badge badge-success badge-promo-primary mt-2">
                              {{ number_format($produit->prix_promotionnel, 2) }} €
                          </span>
                      </div>
                    @else
                        <span class="badge badge-secondary badge-promo-primary">
                            {{ number_format($produit->prix, 2) }} €
                        </span>
                    @endif
                </h6>                
                </div>
                <div class="new">
                  <span>
                    New
                  </span>
                </div>
              </a>
              <div class="bookmark-checkbox">
                <input
                  type="checkbox"
                  id="bookmark-toggle"
                  class="bookmark-checkbox__input"
                />
                <label for="bookmark-toggle" class="bookmark-checkbox__label">
                  <svg class="bookmark-checkbox__icon" viewBox="0 0 24 24">
                    <path
                      class="bookmark-checkbox__icon-back"
                      d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"
                    ></path>
                    <path class="bookmark-checkbox__icon-check" d="M8 11l3 3 5-5"></path>
                  </svg>
                </label>
              </div>

              <div class="rating-star">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star {{ $produit->averageRating() >= $i ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
                <span>({{ number_format($produit->averageRating(), 1) }})</span>
              </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="btn-box">
        <a href="">
          Voire tous les produits
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->
</div>
@endsection