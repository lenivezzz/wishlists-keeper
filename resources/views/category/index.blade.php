@extends('layouts.app')

@section('content')
    <section class="container">

        <div class="row">
            <div class="col-md-12">
                @if(!$categories->isEmpty())
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>
                                {{__('Title')}}
                            </th>
                            <th>
                                {{__('Options')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        {{$category->title}}
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="alert alert-warning">{{ __('No items here.') }}</p>
                @endif
            </div>
        </div>
    </section>
@endsection
