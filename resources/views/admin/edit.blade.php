@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
      <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Modifier le produit</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container" style="max-width:720px;">
            <div class="app-admin-toolbar">
                <div>
                    <h2 class="app-section-heading mb-0">{{ $product->titre }}</h2>
                    <p class="app-section-lead mb-0 mt-1">Mettez à jour les champs nécessaires. L’image est facultative si vous ne souhaitez pas la changer.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="app-btn app-btn--outline">← Tableau de bord</a>
            </div>

            @if(session('success'))
                <div class="app-alert app-alert--success">{{ session('success') }}</div>
            @endif

            <div class="app-card">
                <div class="app-card__body">
                    <form action="{{ route('admin.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data" class="app-form-stack">
                        @csrf
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $product->titre) }}" required>
                            @error('titre')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix (€)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $product->prix) }}" required>
                            @error('prix')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="prix_promotionnel">Prix promotionnel (€)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('prix_promotionnel') is-invalid @enderror" id="prix_promotionnel" name="prix_promotionnel" value="{{ old('prix_promotionnel', $product->prix_promotionnel) }}">
                            <span class="app-form-hint">Doit être inférieur au prix si renseigné.</span>
                            @error('prix_promotionnel')<span class="text-danger small d-block">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantité en stock</label>
                            <input type="number" min="0" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                            @error('quantity')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Catégorie</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">— Choisir —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="promotion">Promotion active</label>
                            <select class="form-control @error('promotion') is-invalid @enderror" id="promotion" name="promotion">
                                <option value="0" {{ old('promotion', $product->promotion) == 0 ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ old('promotion', $product->promotion) == 1 ? 'selected' : '' }}>Oui</option>
                            </select>
                            @error('promotion')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Image actuelle</label>
                            <div class="mb-2">
                                <img src="{{ strpos($product->image, 'products/') === 0 ? Storage::url($product->image) : asset($product->image) }}"
                                    alt="{{ $product->titre }}"
                                    class="app-product-thumb img-fluid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Remplacer l’image</label>
                            <input type="file" class="app-form-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg">
                            <span class="app-form-hint">Laisser vide pour conserver l’image actuelle.</span>
                            @error('image')<span class="text-danger small d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="d-flex flex-wrap align-items-center mt-4">
                            <button type="submit" class="app-btn app-btn--primary mr-2 mb-2">Enregistrer les modifications</button>
                            <a href="{{ route('admin.dashboard') }}" class="app-btn app-btn--outline mb-2">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="app-card mt-4">
                <div class="app-card__body">
                    <h3 class="app-card__title" style="color:#842029;">Zone de danger</h3>
                    <p class="app-section-lead mb-3">La suppression retire le produit du catalogue et efface le fichier image associé.</p>
                    <form action="{{ route('admin.deleteProduct', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce produit ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="app-btn app-btn--danger">Supprimer ce produit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
