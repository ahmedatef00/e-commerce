@extends('layouts.app')
@section('content')
<div class="container">
    <form class="my-3" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
        <label >Name</label>
        <input name="name" type="text" class="form-control" aria-describedby="emailHelp">

        <label >SKE</label>
        <input name="SKE" type="text" class="form-control" aria-describedby="emailHelp">

        <label >Price</label>
        <input name="price" type="number" class="form-control" aria-describedby="emailHelp">

        <div class="form-group">
        <label for="exampleInputPassword1">Brand</label>
        <select name="brand_id" class="form-control">
            @foreach($brands as $brand)  
            <option value="{{$brand->id}}">{{$brand->name}}</option>
            @endforeach
            </select>
        </div>

        <div class="form-group">
        <label for="exampleInputPassword1">Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $category)  
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Uplad Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection