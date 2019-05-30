@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="alert alert-warning col-md-12">
                <p>{{ __('To use service please create Default wishlist.') }}</p>
                <form action="{{ route('wishlists/storedefault') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary" name="create">
                        {{ __('Create Default wishlist') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
