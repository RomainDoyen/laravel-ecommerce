<div class="search-results-container">
  @if(isset($produits) && count($produits) > 0)
      <ul class="search-results-list">
          @foreach($produits as $produit)
              <li class="search-result-item">
                  <a href="{{ route('front.details', ['id' => $produit->id]) }}" class="search-result-link">
                      <div class="result-info">
                          <span class="result-title">{{ $produit->titre }}</span>
                          <span class="result-price">{{ $produit->prix }} €</span>
                      </div>
                      <div class="result-description">
                          {{ Str::limit($produit->description, 50) }}
                      </div>
                  </a>
              </li>
          @endforeach
      </ul>
  @else
      <div class="no-results">
          Aucun produit trouvé pour "{{ $query }}".
      </div>
  @endif
</div>
