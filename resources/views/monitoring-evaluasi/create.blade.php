@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header">
                <h3>Penilaian</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/monitoring-evaluasi/nilai/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Aspek Penilaian</th>
                                <th>Bobot</th>
                                <th>Skor yang Diberikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $item)
                                <tr>
                                    <td>
                                        <p class="fw-bold">{{ $item->nama }}</p>
                                        <p>{{$item->deskripsi}}</p>
                            
                                            <label for="nilai_{{ $item->id }}"
                                                class="form-label">{{ $item->nama }}</label><br>
                                      
                                    </td>
                                    <td>

                                        <p class="text-center fw-bold fs-4">{{ $item->bobot }}</p>

                                    </td>
                                    <td>
                                        
                                            <input type="number" class="form-control mb-2" id="nilai_{{ $item->id }}"
                                                min="1" max="7"
                                                name="nilai[{{ $item->id }}]" required>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>
                                    <label for="catatan" class="form-label">Catatan</label><br>
                                </th>
                                <th colspan="2">
                                    <textarea name="catatan" id="catatan" cols="55" rows="2"></textarea>
                                </th>
                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/monitoring-evaluasi" class="btn btn-primary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
