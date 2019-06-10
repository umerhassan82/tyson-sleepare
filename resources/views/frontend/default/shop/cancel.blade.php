@extends('frontend.default.layouts.app')

@section('title', 'Cart')
@section('meta_desc', '')
@section('meta_key', '')

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Breadcrumbs::render('order') !!}
    </div>
    <div class="col-md-12">
        <div class="alert alert-danger text-center">
            Order cancelled
        </div>
    </div>
</div>
@endsection