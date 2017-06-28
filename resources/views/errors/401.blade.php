@extends('layouts.admin')
@section('content')
    <div class="container" style="padding: 50px; background: #FFFFFF;">
        <div class="content">
            <div class="title text-danger">{{$exception->getMessage()}}</div>
        </div>
    </div>
@endsection