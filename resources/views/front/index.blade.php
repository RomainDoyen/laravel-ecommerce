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
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Bienvenue dans notre <br>
                        boutique ...
                      </h1>
                      <p>
                        Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perferendis.
                      </p>
                      <a href="{{ route('front.contact') }}">
                        Contactez-nous
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img src="{{ asset('assets/images/slider-img.png') }}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Bienvenue dans notre <br>
                        boutique ...
                      </h1>
                      <p>
                        Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perferendis.
                      </p>
                      <a href="{{ route('front.contact') }}">
                        Contactez-nous
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img src="{{ asset('assets/images/slider-img.png') }}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Bienvenue dans notre <br>
                        boutique ...
                      </h1>
                      <p>
                        Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perferendis.
                      </p>
                      <a href="{{ route('front.contact') }}">
                        Contactez-nous
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img src="{{ asset('assets/images/slider-img.png')  }}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel_btn-box">
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
              <span class="sr-only">Précédent</span>
            </a>
            <img src="images/line.png" alt="" />
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
              <span class="sr-only">Suivant</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- end slider section -->
  </div>
  <!-- end hero area -->

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
                <input value="5" name="rate" id="star5" type="radio">
                <label title="text" for="star5"></label>
                <input value="4" name="rate" id="star4" type="radio">
                <label title="text" for="star4"></label>
                <input value="3" name="rate" id="star3" type="radio" checked="">
                <label title="text" for="star3"></label>
                <input value="2" name="rate" id="star2" type="radio">
                <label title="text" for="star2"></label>
                <input value="1" name="rate" id="star1" type="radio">
                <label title="text" for="star1"></label>
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

  <!-- saving section -->

  <section class="saving_section ">
    <div class="box">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="img-box">
              <img src="images/saving-img.png" alt="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="detail-box">
              <div class="heading_container">
                <h2>
                  Meilleures économies sur <br>
                  les nouveaux arrivages
                </h2>
              </div>
              <p>
                Qui ex dolore at repellat, quia neque doloribus omnis adipisci, ipsum eos odio fugit ut eveniet blanditiis praesentium totam non nostrum dignissimos nihil eius facere et eaque. Qui, animi obcaecati.
              </p>
              <div class="btn-box">
                <a href="#" class="btn1">
                  Acheter maintenant
                </a>
                <a href="#" class="btn2">
                  En savoir plus
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end saving section -->

  <hr />

@endsection