@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Panier</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            @if (session('success'))
                <div class="app-alert app-alert--success mb-3">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="app-auth-flash app-auth-flash--err mb-3">{{ session('error') }}</div>
            @endif

            @if ($carts->isNotEmpty())
                <h2 class="app-section-heading">Vos articles</h2>
                <p class="app-section-lead">Ajustez les quantités ou retirez des lignes avant de payer.</p>

                <div class="app-table-wrap mb-4">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Produit</th>
                                    <th class="d-none d-md-table-cell">Description</th>
                                    <th>Prix unit.</th>
                                    <th>Qté</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    @php
                                        $p = $cart->produit;
                                        $unit = ($p->promotion && $p->prix_promotionnel) ? $p->prix_promotionnel : $p->prix;
                                        $lineTotal = $unit * $cart->quantity;
                                        $img = strpos($p->image, 'products/') === 0 ? Storage::url($p->image) : asset($p->image);
                                    @endphp
                                    <tr>
                                        <td style="width:72px;vertical-align:middle;">
                                            <img src="{{ $img }}" alt="{{ $p->titre }}" class="app-cart-thumb" />
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <strong>{{ $p->titre }}</strong>
                                            <div class="d-md-none small text-muted mt-1">{{ Str::limit($p->description, 60) }}</div>
                                        </td>
                                        <td class="d-none d-md-table-cell small text-muted" style="max-width:220px;vertical-align:middle;">
                                            {{ Str::limit($p->description, 90) }}
                                        </td>
                                        <td style="vertical-align:middle;white-space:nowrap;">
                                            @if ($p->promotion && $p->prix_promotionnel)
                                                <span class="text-success font-weight-bold">{{ number_format($p->prix_promotionnel, 2) }} €</span>
                                                <div class="small text-muted" style="text-decoration:line-through;">{{ number_format($p->prix, 2) }} €</div>
                                            @else
                                                {{ number_format($p->prix, 2) }} €
                                            @endif
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <div class="app-cart-qty">
                                                <a href="{{ route('decrement_quantity', $p->id) }}" title="Diminuer" aria-label="Diminuer"><i class="fa fa-minus"></i></a>
                                                <span>{{ $cart->quantity }}</span>
                                                <a href="{{ route('increment_quantity', $p->id) }}" title="Augmenter" aria-label="Augmenter"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </td>
                                        <td style="vertical-align:middle;white-space:nowrap;font-weight:600;">
                                            {{ number_format($lineTotal, 2) }} €
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <a href="{{ route('remove_from_cart', $p->id) }}" class="app-btn app-btn--danger app-btn--sm" title="Retirer du panier" onclick="return confirm('Retirer ce produit du panier ?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="app-cart-summary">
                    <div class="app-card">
                        <div class="app-card__body">
                            <div class="app-cart-total-row">
                                <span>Total</span>
                                <span style="color:var(--app-accent-deep);">{{ number_format($total, 2) }} €</span>
                            </div>
                            @php $stripePk = config('services.stripe.key'); @endphp
                            <button type="button" id="checkout-button" class="app-btn app-btn--primary" style="width:100%;" @if(!$stripePk) disabled @endif>
                                Payer avec Stripe
                            </button>
                            @if(!$stripePk)
                                <p class="small text-danger mb-0 text-center">Clé Stripe publique absente : ajoutez <code>STRIPE_KEY</code> dans <code>.env</code> puis <code>php artisan config:clear</code>.</p>
                            @else
                                <p class="small text-muted mb-0 text-center">Paiement sécurisé — redirection vers Stripe Checkout.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="app-card" style="max-width:480px;">
                    <div class="app-card__body text-center py-4">
                        <h2 class="app-section-heading">Panier vide</h2>
                        <p class="app-section-lead">Ajoutez des produits depuis la boutique pour les voir ici.</p>
                        <div class="d-flex flex-wrap justify-content-center">
                            <a href="{{ route('front.shop') }}" class="app-btn app-btn--primary mr-2 mb-2">Voir la boutique</a>
                            @guest
                                <a href="{{ route('client.login') }}" class="app-btn app-btn--outline mb-2">Se connecter</a>
                            @endguest
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

@if ($carts->isNotEmpty())
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
(function () {
    try {
        var cartItems = @json($cartItems);
        var stripeKey = @json(config('services.stripe.key'));
        var btn = document.getElementById('checkout-button');
        if (!btn || btn.disabled) return;

        if (!stripeKey || typeof Stripe !== 'function') {
            btn.addEventListener('click', function () {
                alert('Paiement indisponible : clé Stripe (STRIPE_KEY) ou script Stripe non chargé.');
            });
            return;
        }

        var stripe = Stripe(stripeKey);
        var csrf = document.querySelector('meta[name="csrf-token"]');
        var csrfToken = csrf ? csrf.getAttribute('content') : '{{ csrf_token() }}';

        btn.addEventListener('click', async function () {
            btn.disabled = true;
            var label = btn.textContent;
            btn.textContent = 'Connexion à Stripe…';
            try {
                var response = await fetch("{{ route('checkout.session') }}", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ cartItems: cartItems })
                });

                var data = null;
                try {
                    data = await response.json();
                } catch (e) {
                    data = null;
                }

                if (response.status === 419) {
                    throw new Error('Session expirée : rechargez la page puis réessayez.');
                }
                if (!response.ok) {
                    throw new Error((data && data.error) ? data.error : "Erreur serveur (" + response.status + ").");
                }
                if (!data || !data.id) {
                    throw new Error((data && data.error) ? data.error : "Réponse Stripe invalide.");
                }

                var result = await stripe.redirectToCheckout({ sessionId: data.id });
                if (result.error) {
                    throw new Error(result.error.message);
                }
            } catch (error) {
                console.error(error);
                alert(error.message || "Une erreur est survenue. Vérifiez STRIPE_SECRET côté serveur et la console réseau.");
            } finally {
                btn.disabled = false;
                btn.textContent = label;
            }
        });
    } catch (e) {
        console.error(e);
    }
})();
</script>
@endpush
@endif
@endsection
