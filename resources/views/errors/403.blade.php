@extends('layouts.master')
@section('content')
    <div class="container" style="padding: 50px">
        <div class="content">
            <div class="title text-danger">{{$exception->getMessage()}}</div>
        </div>
    </div>
@endsection