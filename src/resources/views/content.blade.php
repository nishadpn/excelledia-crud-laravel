@extends('crud::app')
@section('pageTitle')
{{ucfirst($beanType)}}
@endsection
@section('content')
    @include('crud::layout')
@endsection