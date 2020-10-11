@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">


        <div class="container m-5">
            dddddddddddddddddddddddd
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th colspan="2">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @if($products)
                    @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td> {{ $product->price * $product->pivot->quantity}}
                        </td>
                        {{$sum += ($product->price * $product->pivot->quantity)}}xxx
                        <td>
                            <form method="POST" action="{{route('cart.destroy',['product' => $product->id])}}">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure that you want to delete this product ?')">
                                    Delete </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <h1>Your cart is empty</h1>
                    @endif
                </tbody>
            </table>
            <h3>Total : ${{$sum}}</h3>
            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                action="{{ route('payment.paypal') }}">
                @csrf
                <p>
                    <input type="text" class="w3-text-blue" name="amount" value="{{$sum}}" hidden />
                </p>
                <button class="btn btn-primary" type="submit">Pay with PayPal</button>
                </p>
            </form>

        </div>




    </div>
</div>
@endsection