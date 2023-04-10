@extends('layouts.app')

@section('title', 'Thank You for Shopping')

@section('content')

    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    @if (session('message'))
                        <h5 class="alert alert-success">{{ session('message') }}</h5>
                    @endif

                    <div class="p-4 shadow bg-white">
                        <h4 class="mb-3">Thank You for Shopping with Nutri Zone store</h4>
                        <a href="{{ url('collections') }}" class="btn btn-primary">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
