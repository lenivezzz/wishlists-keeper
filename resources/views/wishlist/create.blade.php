@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create new wishlist') }}</div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('wishlists/store') }}" class="form-inline">
                        @csrf

                        <div class="form-group mb-2 mr-4">
                            <label for="title" class="sr-only">{{ __('Title') }}</label>
                            <input id="title" type="text" placeholder="{{ __('Title') }}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autofocus />
                        </div>
                        <button type="submit" class="btn btn-primary mb-2" name="create">
                            {{ __('Create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
