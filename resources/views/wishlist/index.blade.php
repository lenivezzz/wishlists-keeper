@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="{{ route('wishlists/create') }}" class="btn btn-success">
                    {{__('Create new')}}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(!$wishlists->isEmpty())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                {{ __('Title') }}
                            </th>
                            <th scope="col">
                                {{ __('Created') }}
                            </th>
                            <th scope="col">
                                {{ __('Options') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlists as $wishlist)
                                <tr>
                                    <td>
                                        {{ $wishlist->title }}
                                    </td>
                                    <td>
                                        {{ $wishlist->created_at->toDayDateTimeString() }}
                                    </td>
                                    <td>
                                        @if (!$wishlist->is_default)
                                            <form action="{{ route('wishlists/delete') }}" method="post" class="form-horizontal" id="form-options{{ $wishlist->id }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $wishlist->id }}">
                                                <div class="btn-group">
                                                    <a href="{{ route('wishlists/edit', ['id' => $wishlist->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
                                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> {{__('Delete')}}</button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($wishlists instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $wishlists->hasPages())
                        <div class="row" id="wishlist-pagination">
                            <div class="col-md-12">
                                <div class="pull-left">{{ $wishlists->links() }}</div>
                            </div>
                        </div>
                    @endif
                @else
                    <p class="alert alert-warning">{{ __('No items here.') }}</p>
                @endif
            </div>
        </div>
    </section>
@endsection
