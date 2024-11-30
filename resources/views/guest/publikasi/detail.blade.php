@extends('layout.guest.index')
@section('content')
<style>
    img{
        max-width: 850px;  
    }

</style>
    <section class="container-fluid list-publikasi w-full justify-content-center py-4">
        <h1>{{$data->title}}</h1>
        <p>{!! $data->content!!}</p>
    </section>
@endsection
