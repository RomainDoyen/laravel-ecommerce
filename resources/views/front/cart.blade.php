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
        <h1>Panier</h1>
      </div>
    </section>

    <!-- end slider section -->

    <section class="why_section layout_padding">
      <div class="container">
        <div class="heading_container">
          @if(session('cart') && is_array(session('cart')))
            @php
              $total = 0;
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom du produit</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('cart') as $item)
                        @if(is_array($item) && isset($item['id'], $item['titre'], $item['description'], $item['prix'], $item['quantity'], $item['image']))
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['titre'] }}</td>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['prix'] }}</td>
                                <td>
                                    <a href="{{ route('decrement_quantity', $item['id']) }}">
                                      <i class="fa fa-minus"></i>
                                    </a>
                                    {{ $item['quantity'] }}
                                    <a href="{{ route('increment_quantity', $item['id']) }}">
                                      <i class="fa fa-plus"></i>
                                    </a>
                                </td>
                                <td>{{ $item['prix'] * $item['quantity'] }}</td>
                                <td><img style="width: 50px; height: 50px" src="{{ $item['image'] }}" alt="{{ $item['titre'] }}" /></td>
                                <td>
                                    <a href="{{ route('remove_from_cart', $item['id']) }}">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                        @php
                          $total += $item['prix'] * $item['quantity'];
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <table>
              <tfoot>
                  <tr>
                      <td colspan="5" style="text-align: right;">Total: </td>
                      <td>{{ $total }}</td>
                      <td></td>
                      <td></td>
                  </tr>
              </tfoot>
            </table>
            <div class="btn-command">
                <a href="#">Commander</a>
            </div>
          @else
              <p>Panier vide</p>
          @endif

          @if (session('success'))
							<div style="color: green;">
								{{ session('success') }}
							</div>
					@elseif (session('error'))
							<div style="color: red;">
								{{ session('error') }}
							</div>
					@endif
        </div>
      </div>
    </section>
  </div>
  <!-- end hero area -->

  <hr />

@endsection