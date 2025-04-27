@extends('layout.app')
@section('title', 'Publikasi Artikel')
@section('description', 'Publikasi Artikel')
@section('content')
    <style>
        p img {
            display: block;
            margin: auto;
            max-width: 85%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        p img:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-center">
                        <h1 class="h2 mb-0 text-light">{{ $data->title }}</h1>
                    </div>
                    <div class="card-body">
                        <p>
                            {!! $data->content !!}
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/publikasi" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
