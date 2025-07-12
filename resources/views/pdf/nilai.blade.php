<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hasil Try Out</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 30%;
            left: 20%;
            width: 60%;
            opacity: 0.1;
            z-index: -1;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #e9e9e9;
        }
    </style>
</head>

<body>
    <img src="{{asset('images/login/kedinasan.png')}}" class="watermark">

    <div class="header">
        <h2>{{ $data->first()->tryout->title ?? 'Try Out' }}</h2>
        <p>Waktu: {{ $data->first()->tryout->waktu ?? '-' }} menit</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Subject</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Inisialisasi variabel total --}}
            @php
                $totalNilai = 0;
                $currentUserName = '';
            @endphp

            @foreach ($data as $d)
                {{-- Cek apakah nama pengguna berubah --}}
                @if ($currentUserName !== $d->user->name && $currentUserName !== '')
                    {{-- Tampilkan baris total untuk pengguna sebelumnya jika jenisnya "akbar" --}}
                    @if ($data->first()->tryout->jenis == 'akbar')
                        <tr class="total-row">
                            <td colspan="3">Total Nilai ({{ $currentUserName }})</td>
                            <td>{{ $totalNilai }}</td>
                            <td>-</td>
                        </tr>
                    @endif
                    {{-- Reset total untuk pengguna baru --}}
                    @php
                        $totalNilai = 0;
                    @endphp
                @endif
                
                {{-- Tambahkan nilai ke total jika jenisnya "akbar" --}}
                @if ($data->first()->tryout->jenis == 'akbar')
                    @php
                        $totalNilai += $d->total_poin;
                        $currentUserName = $d->user->name;
                    @endphp
                @endif
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->user->name ?? '-' }}</td>
                <td>{{ $d->subject->title ?? '-' }}</td>
                <td>{{ $d->total_poin }}</td>
                <td>{{ $d->status }}</td>
            </tr>
            @endforeach

            {{-- Tampilkan baris total terakhir setelah loop selesai --}}
            @if ($data->first()->tryout->jenis == 'akbar' && count($data) > 0)
                <tr class="total-row">
                    <td colspan="3">Total Nilai ({{ $currentUserName }})</td>
                    <td>{{ $totalNilai }}</td>
                    <td>-</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>