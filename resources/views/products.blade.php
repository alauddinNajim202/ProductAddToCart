@extends('layout')

   

@section('content')

    

<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ $product->image }}" alt="">
                <div class="caption">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                    <p><strong>Price: </strong> {{ $product->price }}$</p>
                    <p class="btn-holder">
                        <button class="btn btn-warning btn-block text-center add-to-cart" data-id="{{ $product->id }}">Add to cart</button>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.add-to-cart').on('click', function() {
        let productId = $(this).data('id');
        
        $.ajax({
            url: '{{ route("add.to.cart") }}', // define this route in web.php
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: productId
            },
            success: function(response) {
                alert(response.message); // Show success message
                // Optionally, update cart count or display success message on the page
            },
            error: function(error) {
                alert("Error adding item to cart. Please try again.");
            }
        });
    });
});
</script>

    

@endsection