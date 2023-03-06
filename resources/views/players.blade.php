@extends('base')
@section('page-title', 'Players')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/datatables.min.css') }}">
@endsection
@if (auth()->user()->insession())
    @include('components.online')
@else
    @include('components.session')
@endif
