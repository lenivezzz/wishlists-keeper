@extends('layouts.app')

@section('content')
    <section class="container">
        @if(!$products->isEmpty())
            @foreach (array_chunk($products->items(), 3) as $productChunk)
                <div class="row">
                    @foreach($productChunk as $product)
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="https://picsum.photos/id/{{ $product->id }}/250/150" alt="{{ $product->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->title}}</h5>
                                    <p class="card-text">{{$product->category->title}}</p>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        @component('products.addtowishlistbutton', ['wishlist' => $defaultWishlist, 'product' => $product, 'cssClass' => 'btn btn-primary'])
                                            {{ __('Add to wishlist') }}
                                        @endcomponent
                                        @if (!$wishlists->isEmpty())
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ __('Add to ...') }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    @foreach($wishlists as $wishlist)
                                                        @component('products.addtowishlistbutton', ['wishlist' => $wishlist, 'product' => $product, 'cssClass' => 'dropdown-item'])
                                                            {{ $wishlist->title }}
                                                        @endcomponent
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p></p>
            @endforeach
            @if($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="row" id="products-pagination">
                    <div class="col-md-12">
                        <div class="pull-left">{{ $products->links() }}</div>
                    </div>
                </div>
            @endif
            @component('layouts.components.modal', ['id' => 'addproduct-failure', 'title' => __('Error...')])
                {{ __('Something was wrong') }}
            @endcomponent
            <script>
                $(document).ready(function () {
                    $('.addproducttowishlist').addProductToWishlist(
                        '{{ route('wishlists/addproduct') }}',
                        function(data) {
                            $(this).find('.check-icon').removeClass('d-none').blur();
                        },
                        function (error) {
                            if (error.status > 500) {
                                return;
                            }

                            let $modal = $('#addproduct-failure');
                            $modal.find('.modal-title').text(error.responseJSON.message);

                            $modal.find('.modal-body').text('');
                            $.each(error.responseJSON.errors, function (i, e) {
                                $modal.find('.modal-body').append($('<p/>').text(e[0]));
                            });
                            $modal.modal('show');

                        }
                    );
                });
            </script>
        @else
            <p class="alert alert-warning">{{ __('No items here.') }}</p>
        @endif
    </section>
@endsection
