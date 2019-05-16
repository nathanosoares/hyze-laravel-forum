@extends('layouts.admin')

@section('content')
    <admin-forums-view :categories='@json($categories)' />
@stop
