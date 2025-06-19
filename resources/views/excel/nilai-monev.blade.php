{{-- Header Information Table --}}
<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
    <thead>
        <tr>
            <th style="background-color: #f0f0f0; padding: 8px;">Nama Ketua</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Judul</th>
            <th style="background-color: #f0f0f0; padding: 8px;">Bidang</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px;">{{ $data->nama_ketua }}</td>
            <td style="padding: 8px;">{{ $data->judul }}</td>
            <td style="padding: 8px;">{{ $data->bidang->nama }}</td>
        </tr>
    </tbody>
</table>
{{-- {{dd($nilai['rubrik'])}} --}}
{{-- Assessment Data per Reviewer --}}
@if (isset($nilai['rubrik']))
@foreach ($nilai["rubrik"] as $reviewer => $rubrikData)
    <div style="border: solid 1px black; ">


        {{-- Reviewer Header --}}
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <td colspan="3" style="background-color: yellow; padding: 8px; font-weight: bold;">
                    Penilai {{ $loop->iteration }}
                </td>
            </tr>
        </table>

        {{-- Assessment Table --}}
        <table style="border-collapse: collapse; border:solid 1px black; width: 100%; margin-bottom: 20px;">
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
                        <td style="padding: 8px; font-weight: bold; background-color: green">
                            {{ $aspek }}
                        </td>
                        <td style="padding: 8px; text-align: center; background-color: green">
                            {{ $nilai['bobot'][$aspek] ?? '' }}
                        </td>
                        <td style="padding: 8px; text-align: center; background-color: green">
                            {{-- This will be filled by criteria scores --}}
                        </td>
                    </tr>

                    {{-- Sub-criteria Rows --}}
                    @if (is_array($criteria))
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
        @if (isset($nilai['total'][$reviewer]))
            <table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
                <tr style="background-color: #f0f0f0;">
                    <td style="padding: 8px; font-weight: bold;">Total Skor</td>
                    <td colspan="2"
                        style="padding: 8px; text-align: center; font-weight: bold; color: black; width: 100px;">
                        {{ $nilai['total'][$reviewer] }}
                    </td>
                </tr>
            </table>
        @endif

        {{-- Feedback Section --}}
        @if (isset($data->reviewAssignments))
            <table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
                <tr style="background-color: #f0f0f0;">
                    <td style="padding: 8px; font-weight: bold;">Feedback</td>
                    <td colspan="2" style="padding: 8px; ">
                        {{ $data->reviewAssignments[$loop->index]->feedback ?? '-' }}
                    </td>
                </tr>
            </table>
        @endif

        {{-- Reviewer Info --}}
        <table style="border-collapse: collapse; width: 100%; margin-bottom: 30px;">
            <tr style="background-color: #f0f0f0;">
                <td style="padding: 8px; font-weight: bold;">Penilai</td>
                <td colspan="2" style="padding: 8px; color: blue;  text-align: center; font-weight: bold; ">
                    {{ $reviewer }}
                </td>
            </tr>
        </table>
    </div>
@endforeach
@endif
