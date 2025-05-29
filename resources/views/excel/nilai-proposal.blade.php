{{-- Header Information Table --}}
<table  style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
    <thead>
        <tr>
            <th style="background-color: #f0f0f0; padding: 8px;">Judul</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Nama Ketua</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px;">{{ $data->judul }}</td>
            <td style="padding: 8px;">{{ $data->nama_ketua }}</td>
        </tr>
    </tbody>
</table>

{{-- Assessment Data per Reviewer --}}
@foreach ($dataNilai['rubrik'] as $reviewer => $rubrikData)
    {{-- Reviewer Header --}}
    <table  style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="background-color: #e0e0e0; padding: 8px; font-weight: bold;">
                {{ $reviewer }}
            </td>
        </tr>
    </table>

    {{-- Assessment Table --}}
    <table  style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #333; color: white;">
                <th style="padding: 8px; text-align: left;">Aspek Penilaian</th>
                <th style="padding: 8px; text-align: center; width: 80px;">Bobot</th>
                <th style="padding: 8px; text-align: center; width: 80px;">Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rubrikData as $aspek => $criteria)
                {{-- Main Aspect Row --}}
                <tr>
                    <td style="padding: 8px; font-weight: bold; background-color: #f8f8f8;">
                        {{ $aspek }}
                    </td>
                    <td style="padding: 8px; text-align: center; background-color: #f8f8f8;">
                        {{ $dataNilai['bobot'][$aspek] ?? '' }}
                    </td>
                    <td style="padding: 8px; text-align: center; background-color: #f8f8f8;">
                        {{-- This will be filled by criteria scores --}}
                    </td>
                </tr>
                
                {{-- Sub-criteria Rows --}}
                @if(is_array($criteria))
                    @foreach ($criteria as $subCriteria => $score)
                        <tr>
                            <td style="padding: 8px 16px;">
                                {{ $subCriteria }}
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                {{-- Empty for sub-criteria --}}
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                {{ $score }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    {{-- Total Score Row --}}
    @if(isset($dataNilai['total'][$reviewer]))
        <table  style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
            <tr style="background-color: #f0f0f0;">
                <td style="padding: 8px; font-weight: bold;">Total Skor</td>
                <td style="padding: 8px; text-align: center; font-weight: bold; color: green; width: 100px;">
                    {{ $dataNilai['total'][$reviewer] }}
                </td>
            </tr>
        </table>
    @endif

    {{-- Feedback Section --}}
    @if(isset($dataNilai['feedback'][$reviewer]))
        <table  style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
            <tr style="background-color: #f0f0f0;">
                <td style="padding: 8px; font-weight: bold;">Feedback</td>
                <td style="padding: 8px;">
                    {{ $dataNilai['feedback'][$reviewer] ?? '-' }}
                </td>
            </tr>
        </table>
    @endif

    {{-- Reviewer Info --}}
    <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 30px;">
        <tr style="background-color: #f0f0f0;">
            <td style="padding: 8px; font-weight: bold;">Penilai</td>
            <td style="padding: 8px; color: blue;">
                {{ $reviewer }}
            </td>
        </tr>
    </table>
@endforeach