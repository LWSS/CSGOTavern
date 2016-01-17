@extends('layouts/item-board')

{{-- Page title --}}
@section('title')
    Browse @parent
@stop

@section('page')
    <div class="page-head">
        <div class="container-fluid">
            <div class="page-title">
                <h1> Browse </h1>
            </div>
        </div>
    </div>
    @parent
@stop