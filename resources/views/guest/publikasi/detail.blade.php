@extends('layout.guest.index')
@section('content')
    <style>
        p img {
            display: block;
            margin: auto;
            max-width: 100%;
            /* Optional: Agar gambar tidak melebihi lebar kontainer */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Optional: Memastikan proporsi gambar tetap terjaga */
        }
    </style>

    <section class="container d-flex justify-content-center align-items-center py-4">
        <div class="card w-full p-4 shadow">
            <div class="card-header text-center mb-4 bg-transparent border-0">
                <h1>{{ $data->title }}</h1>
            </div>
            <div class="card-body ">
                <p style="text-align: justify;">{!! $data->content !!}</p>
            </div>
            @if ($data->updated_at)
            <div class="card-footer bg-light text-muted text-center py-3">
                <small>
                    <i class="fas fa-clock me-2"></i>
                    Terakhir diperbarui: {{ $data->updated_at->format('d M Y H:i') }}
                </small>
            </div>
        @endif
        </div>
    </section>
@endsection
