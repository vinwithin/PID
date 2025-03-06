@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header">
                <h3>Penilaian</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/reviewer/nilai/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Aspek Penilaian</th>
                                <th>Bobot</th>
                                <th>Skor yang Diberikan (DI ISI DENGAN RENTANG SKOR 1 - 7)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $item)
                                <tr>
                                    <td>
                                        <p class="fw-bold">{{ $item->nama }}</p>
                                        @foreach ($item->sub_kriteria_penilaian as $data)
                                            <label for="nilai_{{ $data->id }}"
                                                class="form-label">{{ $data->nama }}</label><br>
                                        @endforeach
                                    </td>
                                    <td>

                                        <p class="text-center fw-bold fs-4">{{ $item->bobot }}</p>

                                    </td>
                                    <td>
                                        @foreach ($item->sub_kriteria_penilaian as $data)
                                            <input type="number" class="form-control mb-2" id="nilai_{{ $data->id }}"
                                                min="1" max="7"
                                                name="nilai[{{ $data->id }}]" required>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>
                                    <label for="feedback" class="form-label">Feedback</label><br>
                                </th>
                                <th colspan="2">
                                    <textarea name="feedback" id="feedback" cols="55" rows="2"></textarea>
                                </th>
                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/pendaftaran" class="btn btn-primary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
