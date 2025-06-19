<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
    <thead>
        <tr>
            {{-- <th style="background-color: #f0f0f0; padding: 8px;">No</th> --}}
            <th style="background-color: #f0f0f0; padding: 8px;">Nama Ketua</th>
            <th style="background-color: #f0f0f0; padding: 8px;">NIM Ketua</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Program Studi</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Fakultas</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Judul</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Bidang</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Nama Dosen Pembimbing</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Total Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                {{-- <td style="padding: 8px;">{{ $loop->iteration }}</td> --}}
                <td style="padding: 8px;">{{ $item->nama_ketua }}</td>
                <td style="padding: 8px;">{{ $item->nim_ketua }}</td>
                <td style="padding: 8px;">{{ $item->program_studi->nama }}</td>
                <td style="padding: 8px;">{{ $data->fakultas->nama }}</td>
                <td style="padding: 8px;">{{ $item->judul }}</td>
                <td style="padding: 8px;">{{ $item->bidang->nama }}</td>
                <td style="padding: 8px;">{{ $item->dospem->name }}</td>
                @isset($dataNilai[$item->id])
                    <td style="padding: 8px;">{{ array_sum($dataNilai[$item->id]) }}</td>
                @else
                    <td colspan="3" style="padding: 8px;">Belum ada nilai</td>
                @endisset

            </tr>
        @endforeach

    </tbody>
</table>
