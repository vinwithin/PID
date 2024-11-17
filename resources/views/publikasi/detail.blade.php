@extends('layout.app')
@section('content')
    <style>
        img {
            width: 100%;
        }
        ql-align-center{
            text-align: center;
        }
    </style>
    <div class="w-100">
        <div class="card ">
            <h1 class="text-center my-2 mb-4">{{ $data->title }}</h1>

            <div class="d-flex justify-content-center align-items-center">
                <div class="w-75 ">
                    {!! $data->content !!}
                </div>
            </div>
            <div>
                <a href="/publikasi" class="btn btn-primary m-4">Kembali</a>
            </div>
        </div>
    </div>
@endsection
