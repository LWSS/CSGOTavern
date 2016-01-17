@extends('layouts/item-board')

{{-- Page title --}}
@section('title')
    Search @parent
@stop

@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
        <a> You Searched For: </a>
        <li class="active">
            <b>{{ $searchQuery or Input::get('query') }}</b>
        </li>
    </ul>
@stop

@if( isset( $results ))
@section('pagination')
    {!! $results->appends(['query' => Input::get('query')])->render() !!}
@stop
@endif

@section('page')
    <div class="page-head">
        <div class="container-fluid">
            <div class="page-title">
                <h1> Search Results </h1>
            </div>
        </div>
    </div>
    @parent
@stop