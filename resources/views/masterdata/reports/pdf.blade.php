<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Dosen Wali</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            text-align: left;
        }

        .table-container {
            margin: 20px 0;
            width: 100%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .th,
        .td {
            padding: 8px;
            border: 1px solid black;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .content-text {
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="content-text">
        <p class="subtitle bold">LAPORAN DOSEN WALI</p>
        <table border="0">
            <tbody>
                <tr class="">
                    <td>Nama Dosen Wali</td>
                    <td class="">:</td>
                    <td class="">{{ $class->academic_advisor->lecturer_name }}</td>
                </tr>
                <tr class="">
                    <td class="">Program Studi</td>
                    <td class="">:</td>
                    <td class="">
                        {{ $class->program->degree }}-{{ $class->program->program_name }}</td>
                </tr>
                <tr class="">
                    <td class="">Nomor SK Dosen Wali</td>
                    <td class="">:</td>
                    <td class="">221/PL.43/HK.03.01/2023</td>
                </tr>
                <tr class="">
                    <td class="">Semester</td>
                    <td class="">:</td>
                    <td class="">{{ convertToRoman($semester) }}</td>
                </tr>
                <tr class="">
                    <td class="">Kelas/Angkatan</td>
                    <td class="">:</td>
                    <td class="">{{ $class->class_name }}/{{ $class->entry_year }}</td>
                </tr>
                <tr class="">
                    <td class="">Semester/Tahun Akademik</td>
                    <td class="">:</td>
                    <td class="">{{ convertToRoman($semester) }}/{{ $academicYear }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Perkembangan Akademis Mahasiswa Perwalian:</p>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2" scope="col" class="th">NIM</th>
                    <th rowspan="2" scope="col" class="th">Nama</th>
                    <th colspan="{{ $jumlahSemester }}" scope="col" class="th text-center">
                        Semester</th>
                    <th rowspan="2" scope="col" class="th text-center">IPK</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= $jumlahSemester; $i++)
                        <th scope="col" class="th">{{ convertToRoman($i) }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @if ($students)
                    @foreach ($students as $student)
                        @php
                            $totalGpa = 0;
                            $semesterCount = 0;
                        @endphp
                        <tr>
                            <td scope="row" class="td">
                                {{ $student->nim }}</td>
                            <td scope="row" class="td">
                                {{ $student->student_name }}</td>
                            @for ($i = 1; $i <= $jumlahSemester; $i++)
                                <td scope="row" class="td">
                                    {{-- Cek apakah ada nilai semester GPA untuk semester ini --}}
                                    @php
                                        if ($student->gpa_cumulative) {
                                            $semesterGpa = $student->gpa_cumulative->gpa_semester
                                                ->where('semester', $i)
                                                ->first();

                                            if ($semesterGpa && $semesterGpa->semester_gpa !== null) {
                                                // Pastikan semesterGpa bukan null
                                                $semesterGpaValue = $semesterGpa->semester_gpa; // Ambil nilai semester_gpa
                                                $totalGpa += $semesterGpaValue; // Tambahkan ke totalGpa
                                                $semesterCount++; // Tambahkan ke semesterCount
                                            } else {
                                                $semesterGpaValue = null; // Atur menjadi null jika tidak ada
                                            }
                                        }
                                    @endphp
                                    {{ $semesterGpaValue ?? '-' }}
                                </td>
                            @endfor
                            @php
                                // Hitung rata-rata GPA hanya untuk semester yang ditampilkan
                                $averageGpa = $semesterCount > 0 ? $totalGpa / $semesterCount : null;
                            @endphp
                            <td scope="row" class="td">
                                {{ $averageGpa ? number_format($averageGpa, 2) : '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="{{ 3 + $jumlahSemester }}" scope="row" class="td">
                        Tidak ada data ipk</td>
                @endif
            </tbody>
        </table>
    </div>

    <div>
        <img src="{{ $chartImage }}" style="width: 100%; max-width: 500px; height: auto; align-item: center"
            alt="chart">
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2" scope="col" class="th">
                        Keterangan
                    </th>
                    <th colspan="{{ $jumlahSemester }}" scope="col" class="text-center th">
                        Semester
                    </th>
                </tr>
                <tr>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <th scope="col" class="th">
                            {{ convertToRoman($i+1) }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" class="th">
                        IPS Rata-rata
                    </th>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <td class="td">{{ $table_data[$i]['avg_gpa'] ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <th scope="row" class="th">
                        IPS Tertinggi
                    </th>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <td class="td">{{ $table_data[$i]['max_gpa'] ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <th scope="row" class="th">
                        IPS Terendah
                    </th>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <td class="td">{{ $table_data[$i]['min_gpa'] ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <th scope="row" class="th">
                        IPS < 3.00 </th>
                            @for ($i = 0; $i < $jumlahSemester; $i++)
                    <td class="td">{{ $table_data[$i]['count_below_3'] ?? '-' }}</td>
                    @endfor
                </tr>

                <tr>
                    <th scope="row" class="th">
                        % IPS < 3.00 </th>
                            @for ($i = 0; $i < $jumlahSemester; $i++)
                    <td class="td">
                        @if (isset($table_data[$i]['percentage_below_3']))
                            {{ $table_data[$i]['percentage_below_3'] }}%
                        @else
                            -
                        @endif
                    </td>
                    @endfor
                </tr>
                <tr>
                    <th scope="row" class="th">
                        IPS >= 3.00
                    </th>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <td class="td">{{ $table_data[$i]['count_above_3'] ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <th scope="row" class="th">
                        % IPS >= 3.00
                    </th>
                    @for ($i = 0; $i < $jumlahSemester; $i++)
                        <td class="td">
                            @if (isset($table_data[$i]['percentage_above_3']))
                                {{ $table_data[$i]['percentage_above_3'] }}%
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Data mahasiswa mengundurkan diri/Drop Out :
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">Nama Mahasiswa</th>
                    <th scope="col" class="td">UD/DO</th>
                    <th scope="col" class="td">SK Penetapan</th>
                    <th scope="col" class="td">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @if ($student_resignationDetail)
                    @if ($student_resignationDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="5" class="td">
                                Tidak ada data pengunduran diri mahasiswa</td>
                        </tr>
                    @else
                        @foreach ($student_resignationDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->resignation_type }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->decree_number }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->reason }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="5" class="td">
                            Tidak ada data pengunduran diri mahasiswa</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="table-container">
        <p class="section-title">Mahasiswa penerima beasiswa/peninjauan ulangan UKT</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">NIM</th>
                    <th scope="col" class="td">Nama</th>
                    <th scope="col" class="td">Jenis Beasiswa</th>
                </tr>
            </thead>
            <tbody>
                @if ($scholarshipDetail)
                    @if ($scholarshipDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="4" class="td">
                                Tidak ada data beasiswa</td>
                        </tr>
                    @else
                        @foreach ($scholarshipDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->scholarship_type }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="4" class="td">
                            Tidak ada data beasiswa</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Mahasiswa Berprestasi dan Keaktifan Organisasi</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">NPM</th>
                    <th scope="col" class="td">Nama</th>
                    <th scope="col" class="td">Jenis Prestasi/Organisasi</th>
                    <th scope="col" class="td">Tingkat</th>
                </tr>
            </thead>
            <tbody>
                @if ($achievementDetail)
                    @if ($achievementDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="4" class="td">
                                Tidak ada data prestasi</td>
                        </tr>
                    @else
                        @foreach ($achievementDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->achievement_type }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->level }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="4" class="td">
                            Tidak ada data prestasi</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Surat Peringatan</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">NIM</th>
                    <th scope="col" class="td">Nama</th>
                    <th scope="col" class="td">Jenis Peringatan</th>
                    <th scope="col" class="td">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @if ($warningDetail)
                    @if ($warningDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="4" class="td">
                                Tidak ada data peringatan</td>
                        </tr>
                    @else
                        @foreach ($warningDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->warning_type }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->reason }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="4" class="td">
                            Tidak ada data peringatan</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Tunggakan UKT</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">NPM</th>
                    <th scope="col" class="td">Nama</th>
                    <th scope="col" class="td">Jumlah Tunggakan</th>
                </tr>
            </thead>
            <tbody>
                @if ($tuition_arrearDetail)
                    @if ($tuition_arrearDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="4" class="td">
                                Tidak ada data Tunggakan</td>
                        </tr>
                    @else
                        @foreach ($tuition_arrearDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    Rp. {{ number_format($detail->amount, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="4" class="td">
                            Tidak ada data peringatan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <p class="section-title">Bimbingan Perwalian</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="td">NPM</th>
                    <th scope="col" class="td">Nama</th>
                    <th scope="col" class="td">Permasalahan</th>
                    <th scope="col" class="td">Solusi</th>
                </tr>
            </thead>
            <tbody>
                @if ($guidanceDetail)
                    @if ($guidanceDetail->isEmpty())
                        <tr>
                            <td scope="row" colspan="4" class="td">
                                Tidak ada data bimbingan</td>
                        </tr>
                    @else
                        @foreach ($guidanceDetail as $detail)
                            <tr>
                                <td scope="row" class="td">
                                    {{ $detail->student->nim }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->student->student_name }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->problem }}</td>
                                <td scope="row" class="td">
                                    {{ $detail->solution }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td scope="row" colspan="4" class="td">
                            Tidak ada data bimbingan</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
</body>


</html>
