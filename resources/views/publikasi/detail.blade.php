@extends('layout.app')
@section('content')
<style>
    img{
        width: 50px;
    }
</style>
    <div class="w-100">
        <div class="card">
            {{$data->title}}
            {!! $data->content !!}
        </div>
    </div>
@endsection