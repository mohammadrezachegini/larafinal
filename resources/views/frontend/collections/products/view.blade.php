@extends('layouts.app')



@section('content')

    <div>
        <livewire:frontend.product.view :category="$category" :product="$product" />
    </div>

@endsection
