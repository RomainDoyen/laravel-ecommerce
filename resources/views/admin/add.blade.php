@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
      <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Nouveau produit</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container" style="max-width:720px;">
            <div class="app-admin-toolbar">
                <div>
                    <h2 class="app-section-heading mb-0">Ajouter un produit</h2>
                    <p class="app-section-lead mb-0 mt-1">Renseignez les informations et téléversez une image (JPEG, PNG, max. 2 Mo).</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="app-btn app-btn--outline">← Tableau de bord</a>
            </div>

            @if(session('success'))
                <div class="app-alert app-alert--success">{{ session('success') }}</div>
            @endif

            <div class="app-card">
                <div class="app-card__body">
                    <form action="{{ route('admin.addProduct') }}" method="POST" enctype="multipart/form-data" class="app-form-stack">
                        @csrf
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                            @error('titre')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix (€)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix') }}" required>
                            @error('prix')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="prix_promotionnel">Prix promotionnel (€)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('prix_promotionnel') is-invalid @enderror" id="prix_promotionnel" name="prix_promotionnel" value="{{ old('prix_promotionnel') }}">
                            <span class="app-form-hint">Uniquement si une promotion est active ; doit être inférieur au prix.</span>
                            @error('prix_promotionnel')<span class="text-danger small d-block">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantité en stock</label>
                            <input type="number" min="0" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                            @error('quantity')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Catégorie</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">— Choisir —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="promotion">Promotion active</label>
                            <select class="form-control @error('promotion') is-invalid @enderror" id="promotion" name="promotion">
                                <option value="0" {{ old('promotion', '0') == '0' ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ old('promotion') == '1' ? 'selected' : '' }}>Oui</option>
                            </select>
                            @error('promotion')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image du produit</label>
                            <input type="file" class="app-form-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg" required>
                            <span class="app-form-hint">JPEG ou PNG, 2 Mo maximum.</span>
                            @error('image')<span class="text-danger small d-block">{{ $message }}</span>@enderror
                        </div>
                        <div class="d-flex flex-wrap align-items-center mt-4">
                            <button type="submit" class="app-btn app-btn--primary mr-2 mb-2">Enregistrer le produit</button>
                            <a href="{{ route('admin.dashboard') }}" class="app-btn app-btn--outline mb-2">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
