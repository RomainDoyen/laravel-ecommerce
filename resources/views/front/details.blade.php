@extends('layout.front')

@section('contentPage')
@php
  $imgUrl = fn($p) => strpos($p->image, 'products/') === 0 ? \Storage::url($p->image) : asset($p->image);
  $isAdmin = auth()->check() && optional(auth()->user()->role)->libelle === 'Administrateur';
  $stock = (int) $produit->quantity;
  $qtyMax = $stock < 1 ? 0 : min(10, $stock);
@endphp
<div class="hero_area">
  <header class="header_section">
    <x-menu_navigation />
  </header>

  <section class="slider_section">
    <div class="slider_container">
      <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">{{ $produit->titre }}</h1>
    </div>
  </section>

  <section class="app-page-section">
    <div class="container app-product-detail">
      @if(session('success'))
        <div class="app-alert app-alert--success mb-4">{{ session('success') }}</div>
      @endif
      <div class="row align-items-start">
        <div class="col-lg-7 mb-4 mb-lg-0">
          <div class="app-product-media">
            <img src="{{ $imgUrl($produit) }}" alt="{{ $produit->titre }}">
          </div>
        </div>
        <div class="col-lg-5">
          <h2 class="app-product-title">{{ $produit->titre }}</h2>
          @if($produit->category)
            <p class="text-muted small mb-2">{{ $produit->category->name }}</p>
          @endif
          <p class="app-product-desc">{{ $produit->description }}</p>

          <div class="app-price-row">
            @if($produit->promotion && $produit->prix_promotionnel)
              <span class="app-price-current">{{ number_format($produit->prix_promotionnel, 2) }} €</span>
              <span class="app-price-old">{{ number_format($produit->prix, 2) }} €</span>
            @else
              <span class="app-price-current">{{ number_format($produit->prix, 2) }} €</span>
            @endif
          </div>
          <p class="mb-4"><span class="app-badge-stock">Stock : {{ $produit->quantity }}</span></p>

          <form action="{{ route('add_to_cart', $produit->id) }}" method="GET" class="app-card" style="padding:1.25rem 1.5rem;">
            <div class="app-form-row">
              <label for="quantity">Quantité</label>
              @if($qtyMax < 1)
                <p class="small text-muted mb-2">Rupture de stock.</p>
                <button type="button" class="app-btn app-btn--outline" style="width:100%;" disabled>Indisponible</button>
              @else
                <div class="app-qty-stepper mb-3">
                  <button type="button" id="detail-qty-minus" aria-label="Diminuer la quantité">−</button>
                  <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $qtyMax }}" step="1" required>
                  <button type="button" id="detail-qty-plus" aria-label="Augmenter la quantité">+</button>
                </div>
                <button type="submit" class="app-btn app-btn--primary" style="width:100%;">Ajouter au panier</button>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  @if(count($produits_similaires) > 0)
  <section class="app-page-section app-page-section--white">
    <div class="container">
      <h2 class="app-section-heading">Produits similaires</h2>
      <div class="row">
        @foreach($produits_similaires as $p)
          <div class="col-sm-6 col-md-4 mb-4">
            <article class="app-product-mini">
              <a href="{{ route('front.details', $p->id) }}" class="app-product-mini__img d-block">
                <img src="{{ $imgUrl($p) }}" alt="{{ $p->titre }}">
              </a>
              <div class="app-product-mini__body">
                <h3 class="app-product-mini__title">
                  <a href="{{ route('front.details', $p->id) }}" style="color:inherit;text-decoration:none;">{{ $p->titre }}</a>
                </h3>
                <p class="small text-muted mb-2" style="flex:1;">{{ Str::limit($p->description, 70) }}</p>
                <div class="app-product-mini__meta">
                  @if($p->promotion && $p->prix_promotionnel)
                    {{ number_format($p->prix_promotionnel, 2) }} €
                    <span class="text-muted small text-decoration-line-through ms-1">{{ number_format($p->prix, 2) }} €</span>
                  @else
                    {{ number_format($p->prix, 2) }} €
                  @endif
                </div>
                <a href="{{ route('front.details', $p->id) }}" class="app-btn app-btn--outline app-btn--sm mt-2 align-self-start">Voir le détail</a>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <section class="app-page-section">
    <div class="container">
      <h2 class="app-section-heading">Avis clients</h2>

      <div class="app-card mb-4">
        <div class="app-card__body">
          <div class="app-reviews-header">
            <div>
              <p class="small text-muted mb-1">Note moyenne</p>
              <div class="app-stars" style="font-size:1.25rem;">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fa fa-star {{ $produit->averageRating() >= $i ? '' : 'text-muted' }}"></i>
                @endfor
                <span class="text-muted ms-2" style="font-size:0.95rem;">({{ number_format($produit->averageRating() ?? 0, 1) }} / 5)</span>
              </div>
            </div>
          </div>

          @auth
            @php $defaultRating = (int) old('rating', 1); $defaultRating = max(1, min(5, $defaultRating)); @endphp
            <form action="{{ route('add_review', $produit->id) }}" method="POST" class="mt-3">
              @csrf
              <div class="app-form-row">
                <label id="review-rating-label">Votre note</label>
                <div class="app-rating-picker" id="review-rating-picker" role="group" aria-labelledby="review-rating-label">
                  <input type="hidden" name="rating" id="review-rating" value="{{ $defaultRating }}" required>
                  <div class="app-rating-picker__stars">
                    @for ($i = 1; $i <= 5; $i++)
                      <button type="button" class="app-rating-picker__btn {{ $i <= $defaultRating ? 'is-selected' : '' }}" data-value="{{ $i }}" aria-label="{{ $i }} sur 5" title="{{ $i }} sur 5">
                        <i class="fa fa-star" aria-hidden="true"></i>
                      </button>
                    @endfor
                  </div>
                </div>
              </div>
              <div class="app-form-row">
                <label for="review">Votre commentaire</label>
                <textarea name="review" id="review" class="form-control" rows="3" placeholder="Partagez votre expérience…"></textarea>
              </div>
              <button type="submit" class="app-btn app-btn--primary app-btn--sm">Publier</button>
            </form>
          @else
            <p class="app-section-lead mb-0"><a href="{{ route('client.login') }}">Connectez-vous</a> pour laisser un avis.</p>
          @endauth
        </div>
      </div>

      <div class="app-card">
        <div class="app-card__body" style="padding-top:0;padding-bottom:0;">
          @forelse($produit->reviews as $review)
            <div class="app-review-item" id="review-row-{{ $review->id }}">
              <div class="app-stars small mb-1">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fa fa-star {{ $review->rating >= $i ? '' : 'text-muted' }}"></i>
                @endfor
                <span class="text-muted">({{ $review->rating }}/5)</span>
              </div>
              <p class="mb-2" style="color:#333;">{{ $review->review }}</p>
              <p class="small text-muted mb-2">— {{ $review->user->prenom ?? '' }} {{ $review->user->nom ?? 'Client' }}</p>

              @auth
                @if(auth()->id() === $review->user_id || $isAdmin)
                  <div class="d-flex flex-wrap align-items-center">
                    <form action="{{ route('delete_review', $review->id) }}" method="POST" onsubmit="return confirm('Supprimer cet avis ?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="app-btn app-btn--danger app-btn--sm mr-2 mb-2">Supprimer</button>
                    </form>
                    <button type="button" class="app-btn app-btn--warn app-btn--sm mr-2 mb-2" onclick="toggleForm({{ $review->id }})">Modifier</button>
                    <button type="button" id="close-form-{{ $review->id }}" class="app-btn app-btn--outline app-btn--sm mb-2" style="display:none;" onclick="toggleForm({{ $review->id }})">Fermer</button>
                  </div>
                  <form id="edit-form-{{ $review->id }}" action="{{ route('edit_review', $review->id) }}" method="POST" style="display:none;margin-top:1rem;" class="pt-3 border-top">
                    @csrf
                    @method('PUT')
                    <div class="app-form-row">
                      <label>Note (1–5)</label>
                      <input type="number" name="rating" value="{{ $review->rating }}" min="1" max="5" class="app-input" required>
                    </div>
                    <div class="app-form-row">
                      <label>Commentaire</label>
                      <textarea name="review" class="form-control" rows="3" required>{{ $review->review }}</textarea>
                    </div>
                    <button type="submit" class="app-btn app-btn--primary app-btn--sm">Mettre à jour</button>
                  </form>
                @endif
              @endauth
            </div>
          @empty
            <p class="text-muted mb-0 py-4 px-3">Aucun avis pour le moment.</p>
          @endforelse
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script>
function toggleForm(id) {
  var f = document.getElementById('edit-form-' + id);
  var c = document.getElementById('close-form-' + id);
  if (!f) return;
  var show = f.style.display === 'none';
  f.style.display = show ? 'block' : 'none';
  if (c) c.style.display = show ? 'inline-flex' : 'none';
}
(function () {
  var qtyInput = document.getElementById('quantity');
  var minus = document.getElementById('detail-qty-minus');
  var plus = document.getElementById('detail-qty-plus');
  if (!qtyInput || !minus || !plus) return;

  function clamp() {
    var min = parseInt(qtyInput.getAttribute('min'), 10) || 1;
    var max = parseInt(qtyInput.getAttribute('max'), 10) || 1;
    var v = parseInt(qtyInput.value, 10);
    if (isNaN(v)) v = min;
    v = Math.max(min, Math.min(max, v));
    qtyInput.value = String(v);
    minus.disabled = v <= min;
    plus.disabled = v >= max;
  }

  minus.addEventListener('click', function () {
    var v = parseInt(qtyInput.value, 10) || 1;
    qtyInput.value = String(Math.max(parseInt(qtyInput.getAttribute('min'), 10) || 1, v - 1));
    clamp();
  });
  plus.addEventListener('click', function () {
    var v = parseInt(qtyInput.value, 10) || 1;
    var max = parseInt(qtyInput.getAttribute('max'), 10) || 1;
    qtyInput.value = String(Math.min(max, v + 1));
    clamp();
  });
  qtyInput.addEventListener('change', clamp);
  qtyInput.addEventListener('input', clamp);
  clamp();
})();

(function () {
  var picker = document.getElementById('review-rating-picker');
  var hidden = document.getElementById('review-rating');
  if (!picker || !hidden) return;

  function setRating(v) {
    v = Math.max(1, Math.min(5, parseInt(v, 10) || 5));
    hidden.value = String(v);
    picker.querySelectorAll('.app-rating-picker__btn').forEach(function (btn) {
      var val = parseInt(btn.getAttribute('data-value'), 10);
      btn.classList.toggle('is-selected', val <= v);
    });
  }

  picker.querySelectorAll('.app-rating-picker__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      setRating(btn.getAttribute('data-value'));
    });
  });
})();
</script>
@endpush
@endsection
