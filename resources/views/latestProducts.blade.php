@extends('layouts.app')


@section('content')
    <div class="container">
        <section>
        <div class="jumbotron">
            <a class="btn btn-primary btn-lg" href="{{ route('product.index') }}" role="button">View  All Products</a>
            </div>
        </section>

        <section>
            <p>Latest Products.</p>

            
            <div class="row">
            @foreach( $latestProducts as $product)
                <div class="col-md-4">
                
                    <div class="card mb-2">
                            <img src="{{ $product->image }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">{{$product->SKE}}</p>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart">
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <input type="submit" class="btn btn-primary" value="Buy">
                                  </form>
                                                  </div>
                    </div>
                    
                </div>
                @endforeach
            </div>
            
        </section>
    </div>
@endsection