@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1 style="font-size:1.75rem;padding:0.5rem 1rem;">Mes commandes</h1>
        </div>
    </section>

    <section class="app-page-section">
        <div class="container">
            <h2 class="app-section-heading">Historique</h2>
            @if ($orders->isNotEmpty())
                <div class="app-table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>N° commande</th>
                                    <th>Statut</th>
                                    <th>Total</th>
                                    <th>Articles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            {{ $order->created_at->format('d/m/Y') }}<br>
                                            <span class="text-muted small">{{ $order->created_at->format('H:i') }}</span>
                                        </td>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>{{ number_format($order->total, 2) }} €</td>
                                        <td>
                                            <ul class="mb-0 pl-3 small">
                                                @foreach (json_decode($order->items, true) ?? [] as $item)
                                                    <li>{{ $item['name'] ?? '—' }} ×{{ $item['quantity'] ?? 0 }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p class="app-section-lead">Vous n’avez pas encore passé de commande.</p>
                <a href="{{ route('front.shop') }}" class="app-btn app-btn--primary">Découvrir la boutique</a>
            @endif
        </div>
    </section>
</div>
@endsection
