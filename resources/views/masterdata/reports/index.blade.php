<x-app-layout>

    @section('descendant_folder')
        > &nbsp;&nbsp;Laporan
    @endsection

    @section('content')
        <style>
            #success-message {
                transition: opacity 0.2s ease-out;
            }

            #errors-message {
                transition: opacity 0.2s ease-out;
            }

            .close-btn {
                cursor: pointer;
                float: right;
                font-size: 1.2rem;
                font-weight: bold;
                color: black;
            }

            .close-btn:hover {
                color: black;
            }
        </style>



        @if ($errors->any())
            <div id="error-message"
                class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <span class="font-medium">Whoops!</span> There were some problems with your input.
                <span class="close-btn" onclick="closeAlert('error-message')">&times;</span>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div id="success-message"
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
                <span class="close-btn" onclick="closeAlert('success-message')">&times;</span>
            </div>
        @endif

        <script>
            function closeAlert(id) {
                var alert = document.getElementById(id);
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 200); // Menunggu transisi opacity selesai
            }
        </script>

        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            @role('dosenWali')
                <div>
                    {{-- <a href="{{ route('masterdata.reports.create') }}" class="inline-block"> --}}
                    <button type="button" data-modal-target="semester-modal" data-modal-toggle="semester-modal"
                        class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Tambah
                        Laporan</button>
                    {{-- </a> --}}
                </div>
            @endrole
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for items">
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        @role('admin')
                            <th scope="col" class="px-6 py-3">
                                Kelas
                            </th>
                        @endrole
                        @role('kaprodi')
                            <th scope="col" class="px-6 py-3">
                                Kelas
                            </th>
                        @endrole
                        <th scope="col" class="px-6 py-3">
                            Semester
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status Laporan Dosen Wali
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status Persetujuan Ketua Program Studi
                        </th>
                        {{-- <th scope="col" class="px-6 py-3">
                            Status Umum Laporan
                        </th> --}}
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($reports->isEmpty())
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="8" scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                Tidak ada data laporan
                            </td>
                        </tr>
                    @else
                        @foreach ($reports as $report)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800"
                                {{-- onclick="window.location.href='{{ route('masterdata.reports.show', $report->report_id) }}'"> --}}
                                >
                                @role('admin')
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $report->student_class->class_name }}
                                    </td>
                                @endrole
                                @role('kaprodi')
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $report->student_class->class_name }}
                                    </td>
                                @endrole
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $report->semester }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($report->has_acc_academic_advisor)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Selesai</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum
                                            Selesai</span>
                                    @endif
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($report->has_acc_head_of_program)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Disetujui</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum
                                            Disetujui</span>
                                    @endif
                                </td>
                                {{-- <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @switch($report->status)
                                        @case('pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Menunggu Persetujuan</span>
                                            @break
                                        @case('approved')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Laporan disetujui</span>
                                            @break
                                        @case('rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Laporan ditolak</span>
                                            @break
                                    @endswitch
                                </td> --}}
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('masterdata.reports.show', $report->report_id) }}"
                                        class="text-blue-500 hover:underline">Detail</a>
                                    @role('dosenWali')
                                        <button
                                            onclick="confirmDelete('{{ route('masterdata.reports.destroy', $report->report_id) }}')"
                                            type="button" @disabled($report->has_acc_academic_advisor) @disabled($report->has_acc_head_of_program)
                                            class="font-medium @if ($report->has_acc_academic_advisor || $report->has_acc_head_of_program)
                                                cursor-not-allowed
                                            @endif text-red-600 dark:text-blue-500 hover:underline">Hapus</button>
                                        @if (!$report->has_acc_academic_advisor)
                                            <form action="{{ route('masterdata.reports.update', $report->report_id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="update_type" value="acc_academic_advisor" hidden>
                                                <button type="submit"
                                                    class="bg-blue-100 text-blue-800 text-xs hover:text-white hover:bg-blue-800 font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Selesai
                                                    Input?</button>
                                            </form>
                                        @else
                                            <form action="{{ route('masterdata.reports.update', $report->report_id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="update_type" value="reject_academic_advisor" hidden>
                                                <button type="submit" @disabled($report->has_acc_head_of_program)
                                                    class="bg-red-100 text-red-800 text-xs hover:text-white hover:bg-red-800 @if ($report->has_acc_head_of_program)
                                                        cursor-not-allowed
                                                    @endif font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum Selesai?</button>
                                            </form>
                                        @endif
                                    @endrole
                                    @role('kaprodi')
                                        @if ($report->has_acc_head_of_program == false)
                                            <form action="{{ route('masterdata.reports.update', $report->report_id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="update_type" value="acc_head_of_program" hidden>
                                                <button type="submit" @disabled($report->has_acc_academic_advisor == false)
                                                    class="bg-blue-100 @if ($report->has_acc_academic_advisor == false)
                                                        cursor-not-allowed
                                                    @endif text-blue-800 text-xs hover:text-white hover:bg-blue-800 font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Setujui
                                                    Laporan?</button>
                                            </form>
                                        @else
                                            <form action="{{ route('masterdata.reports.update', $report->report_id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="update_type" value="reject_head_of_program" hidden>
                                                <button type="submit" @disabled($report->has_acc_academic_advisor == false)
                                                    class="bg-red-100 @if ($report->has_acc_academic_advisor == false)
                                                        cursor-not-allowed
                                                    @endif text-red-800 text-xs hover:text-white hover:bg-red-800 font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tolak
                                                    Laporan?</button>
                                            </form>
                                        @endif
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Modal Konfirmasi Delete -->
        <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div id="alert-additional-content-2"
                class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Konfirmasi</span>
                    <h3 class="text-lg font-medium">Hapus laporan?</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat diurungkan.
                </div>
                <div class="flex">
                    <form id="deleteForm" method="post"
                        action="{{ route('masterdata.reports.destroy', $report->report_id ?? '') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 14">
                                <path
                                    d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                            </svg>
                            Delete
                        </button>
                    </form>
                    <button onclick="hideModal()"
                        class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800"
                        data-dismiss-target="#alert-additional-content-2" aria-label="Close">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>

        <script>
            function confirmDelete(actionUrl) {
                // Tampilkan modal
                document.getElementById('deleteModal').classList.remove('hidden');
                // Set form action dengan URL delete
                document.getElementById('deleteForm').setAttribute('action', actionUrl);
            }

            function hideModal() {
                // Sembunyikan modal
                document.getElementById('deleteModal').classList.add('hidden');
            }
        </script>


        @role('dosenWali')
            <!-- Main modal -->
            <div id="semester-modal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Create New Product
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="semester-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form method="POST" action="{{ route('masterdata.reports.store') }}" class="p-4 md:p-5">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                @role('admin')
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                                        <select id="student_class" name="student_class"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option selected="" value="">Pilih Kelas</option>
                                            @foreach ($studentClass as $class)
                                                <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole
                                <div class="col-span-4 sm:col-span-2 text-center">
                                    <label for="price"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Rentang
                                        Semester</label>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <select id="dari-semester" name="dari-semester"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="" value="">Dari Semester</option>
                                        @for ($i = 1; $i <= $jumlahSemester; $i++)
                                            <option value="{{ $i }}" @disabled($i > $currentSemester)
                                                @disabled(in_array($i, $usedSemesters))>Semester
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <select id="sampai-semester" name="sampai-semester"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="" value="">Sampai Semester</option>
                                        @for ($i = 1; $i <= $jumlahSemester; $i++)
                                            <option value="{{ $i }}" @disabled($i > $currentSemester)
                                                @disabled(in_array($i, $usedSemesters))>Semester
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-span-4 sm:col-span-2 text-center">
                                    <label for="price"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Atau</label>
                                </div>
                                <div class="col-span-2">
                                    <select id="pilih-semester" name="pilih-semester"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="" value="">Pilih Semester</option>
                                        @for ($i = 1; $i <= $jumlahSemester; $i++)
                                            <option value="{{ $i }}" @disabled($i > $currentSemester)
                                                @disabled(in_array($i, $usedSemesters))>Semester
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Buat Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endrole

        {{-- script untuk dropdown rentang semester --}}
        <script>
            document.getElementById('dari-semester').addEventListener('change', function() {
                var dariSemesterValue = parseInt(this.value);
                var sampaiSemester = document.getElementById('sampai-semester');
                var pilihSemester = document.getElementById('pilih-semester');

                // Disable 'Pilih Semester' if a range is being selected
                if (dariSemesterValue) {
                    pilihSemester.disabled = true;
                } else {
                    pilihSemester.disabled = false;
                }

                // Reset 'Sampai Semester' options
                sampaiSemester.innerHTML = '<option selected="" value="">Sampai Semester</option>';
                for (var i = dariSemesterValue + 1; i <= {{ $jumlahSemester }}; i++) {
                    var option = document.createElement('option');
                    option.value = i;
                    option.text = 'Semester ' + i;
                    // Apply the disabled logic as in Blade
                    if (i > {{ $currentSemester }} || {{ json_encode($usedSemesters) }}.includes(i)) {
                        option.disabled = true;
                    }

                    if (i > dariSemesterValue) {
                        sampaiSemester.appendChild(option);
                    }
                }
            });

            document.getElementById('pilih-semester').addEventListener('change', function() {
                var pilihSemesterValue = parseInt(this.value);
                var dariSemester = document.getElementById('dari-semester');
                var sampaiSemester = document.getElementById('sampai-semester');

                // Disable 'Dari Semester' and 'Sampai Semester' if 'Pilih Semester' is being selected
                if (pilihSemesterValue) {
                    dariSemester.disabled = true;
                    sampaiSemester.disabled = true;
                } else {
                    dariSemester.disabled = false;
                    sampaiSemester.disabled = false;
                }
            });

            // Function to reset dropdowns when modal is closed
            function resetDropdowns() {
                document.getElementById('dari-semester').value = '';
                document.getElementById('sampai-semester').value = '';
                document.getElementById('pilih-semester').value = '';
                document.getElementById('pilih-semester').disabled = false;
                document.getElementById('dari-semester').disabled = false;
                document.getElementById('sampai-semester').disabled = false;
                document.getElementById('sampai-semester').innerHTML = '<option selected="" value="">Sampai Semester</option>';
            }

            // Attach event to reset dropdowns when modal is closed
            document.getElementById('semester-modal').addEventListener('hidden.bs.modal', function() {
                resetDropdowns();
            });
        </script>



        {{-- script untuk modal click --}}
        <script>
            // Mendapatkan elemen modal dan tombol
            const modal = document.getElementById('semester-modal');
            const modalToggleButtons = document.querySelectorAll('[data-modal-toggle]');

            // Fungsi untuk membuka modal
            function openModal() {
                modal.classList.remove('hidden'); // Hapus kelas 'hidden' untuk menampilkan modal
            }

            // Fungsi untuk menutup modal
            function closeModal() {
                modal.classList.add('hidden'); // Tambahkan kelas 'hidden' untuk menyembunyikan modal
                resetDropdowns();
            }

            // Event listener untuk membuka modal saat tombol diklik
            modalToggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const isModalOpen = !modal.classList.contains('hidden');
                    if (isModalOpen) {
                        closeModal();
                    } else {
                        openModal();
                    }
                });
            });

            // Event listener untuk menutup modal saat klik di luar area modal
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        </script>

    @endsection
</x-app-layout>
