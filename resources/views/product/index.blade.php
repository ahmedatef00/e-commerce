@extends('layouts.app')


@section('content')
    <div class="container">
        

        <section>
        @if( session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
            <div class="row">
               
            @foreach( $products as $product)
                
                <div class="col-md-4">
                
                    <div class="card mb-2">
                            <img src="{{ asset( "images/".$product->image) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{$product->SKE}}</p>
                                <p><strong> $ {{ $product->price }}</strong></p>
                                <form action="{{ route('cart.add', $product->id) }}" method="post" class="cart">
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <input type="submit" value="Buy" class="btn btn-primary">
                                  </form>
                                 <br>
                                  @if(auth()->user())
                                  @if(auth()->user()->is_admin)
                                  <a href="{{ route('product.edit',$product)}}" class="btn btn-primary"> edit</a>

                                  @endif
                                  @endif
                            </div>
                    </div>
                    
                </div>
                @endforeach
            </div>
            
        </section>
    </div>
@endsection