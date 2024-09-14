<x-app-layout>
    

    @section('content')

        @role('admin')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Role Admin") }}
                    </div>
                </div>
            </div>
        </div>
        @endrole

        @role('dosenWali')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Role Dosen Wali") }}
                    </div>
                </div>
            </div>
        </div>
        @endrole
        
        @role('mahasiswa')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Role Mahasiswa") }}
                    </div>
                </div>
            </div>
        </div>
        @endrole
    @endsection


</x-app-layout>
