@extends('layout.front')

@section('contentPage')
<div class="hero_area">
    <header class="header_section">
        <x-menu_navigation />
    </header>

    <section class="slider_section">
        <div class="slider_container">
            <h1>Mes commandes</h1>
        </div>
    </section>

    <section class="why_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>Vos commandes</h2>
                @if ($orders->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Numéro de commande</th>
                                <th>Statut</th>
                                <th>Total</th>
                                <th>Produits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ number_format($order->total, 2) }} €</td>
                                    <td>
                                        <ul>
                                            @foreach (json_decode($order->items, true) as $item)
                                                <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Vous n'avez pas encore passé de commandes.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
