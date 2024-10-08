<x-app-layout>

    @section('descendant_folder')
        > &nbsp;&nbsp;Prestasi
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div id="error-message"
                    class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                    role="alert">
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
                <div>
                    <a href="{{ route('masterdata.achievements.create', Auth::user()->id) }}" class="inline-block">
                        <button type="button"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Tambah
                            Prestasi Mahasiswa</button>
                    </a>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
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
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="col" class="px-6 py-3 border-b">NIM</th>
                            <th scope="col" class="px-6 py-3 border-b">Nama</th>
                            <th scope="col" class="px-6 py-3 border-b">Jenis Prestasi atau Organisasi</th>
                            <th scope="col" class="px-6 py-3 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($achievement)
                            @foreach ($achievement as $data)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    onclick="window.location.href='{{ route('masterdata.achievements.show', $data->student_id) }}'">
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b">
                                        {{ $data->nim ?? '-' }}</td>
                                    <!-- menggunakan null coalescing untuk menghindari error -->
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b">
                                        {{ $data->student_name ?? '-' }}</td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b">
                                        {{ $data->achievement_types }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('masterdata.achievements.show', $data->student_id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                                        <br>
                                        <a href="#"
                                            class="font-medium text-yellow-200 dark:text-blue-500 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="6" scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b">
                                    {{ $detail->student->nim }}</td>
                                Tidak ada prestasi/keaktifan organisasi
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

</x-app-layout>
