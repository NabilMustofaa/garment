@extends('layouts.main')

@section('container')

<div class="card sm:rounded-lg shadow-md mb-4" style="padding: 2rem">
    <div class="card-body">
        <label class="label mb-3 text-center">Tabel Process</label>
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-gray-200 dark:text-gray-800" id="materialTable">
                <thead class="border-b bg-gray-300">
                <tr>
                    <th class="border px-4 py-2 text-center">Name</th>
                    <th class="border px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($processTypes as $process)
                    <tr>
                        <td class="border px-4 py-2">{{ $process->process_type_name }}</td>
                        <td class="border px-3 py-2 text-center">
                            <a href="/processtype/{{ $process->id }}/edit" class="bg-blue-500 text-white p-1.5 rounded">Edit</a>
                            <!--<form action="/processtype/{{ $process->id }}" method="POST" class="inline">-->
                            <!--    @csrf-->
                            <!--    @method('DELETE')-->
                            <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                            <!--</form>-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="font-bold ml-4 mt-3 mb-3">
            Nb: Jalannya proses urut dari atas ke bawah
        </div>
        </div>
    </div>
</div>

 <!-- <div class="">
    <a href="/processtype/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Tambah Proses</a>
</div> -->

<div class="card sm:rounded-lg shadow-md mb-4" style="padding: 2rem">
    <div class="card-body">
        <label class="label mb-3 text-center">Tabel Tipe Produksi</label>
        <div class="mb-5">
            <a href="/productiontype/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Tambah +</a>
        </div>
        @if (session('success'))
        <div class="bg-green-500 shadow-lg mx-auto w-96 max-w-full text-sm pointer-events-auto bg-clip-padding rounded-lg block mb-3 mr-1" id="static-example" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
            <div class="bg-green-500 flex justify-between items-center py-2 px-3 bg-clip-padding border-b border-green-400 rounded-t-lg">
            <p class="font-bold text-white flex items-center">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                </svg>
                Process</p>
            <div class="flex items-center">
                <button type="button" class="btn-close btn-close-white box-content w-4 h-4 ml-2 text-white border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-white hover:opacity-75 hover:no-underline" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            </div>
            <div class="p-3 bg-green-500 rounded-b-lg break-words text-white">
                {{ session('success') }}
            </div>
        </div>
        @endif
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-gray-200 dark:text-gray-800" id="materialTable">
                <thead class="border-b bg-gray-300">
                <tr>
                    <th class="border px-4 py-2 text-center">Name</th>
                    <th class="border px-4 py-2 text-center">Description</th>
                    <th class="border px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productionProcessTypes as $production)
                    <tr>
                        <td class="border px-4 py-2">{{ $production[0]->production_type->production_type_name }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($production as $ps)
                                @if($ps->process_type_id == 1 || $ps->process_type_id ==5)
                                    @continue
                                @else
                                {{ $ps->process_type->process_type_name }} <br>
                                @endif
        
                                
                            @endforeach
                        </td>
                        {{-- Link Benerin --}}
                        <td class="border px-3 py-2 text-center">
                            <a href="/productiontype/{{ $production[0]->production_type->id }}/edit" class="bg-blue-500 text-white p-1.5 rounded">Edit</a>
                            <!--<form action="/productiontype/{{ $production[0]->production_type->id }}" method="POST" class="inline">-->
                            <!--    @csrf-->
                            <!--    @method('DELETE')-->
                            <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                            <!--</form>-->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card sm:rounded-lg shadow-md mb-4" style="padding: 2rem">
    <div class="card-body">
        <label class="label mb-3 text-center">Tabel Pekerja</label>
        <div class="mb-5">
            <a href="/user/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Tambah +</a>
        </div>
        @if (session('success'))
        <div class="bg-green-500 shadow-lg mx-auto w-96 max-w-full text-sm pointer-events-auto bg-clip-padding rounded-lg block mb-3 mr-1" id="static-example" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
            <div class="bg-green-500 flex justify-between items-center py-2 px-3 bg-clip-padding border-b border-green-400 rounded-t-lg">
            <p class="font-bold text-white flex items-center">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                </svg>
                Process</p>
            <div class="flex items-center">
                <button type="button" class="btn-close btn-close-white box-content w-4 h-4 ml-2 text-white border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-white hover:opacity-75 hover:no-underline" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            </div>
            <div class="p-3 bg-green-500 rounded-b-lg break-words text-white">
                {{ session('success') }}
            </div>
        </div>
        @endif
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-gray-200 dark:text-gray-800" id="materialTable">
                <thead class="border-b bg-gray-300">
                <tr>
                    <th class="border px-4 py-2 text-center">Name</th>
                    <th class="border px-4 py-2 text-center">Description</th>
                    <th class="border px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($personProcesses as $person)
                    <tr>
                        <td class="border px-4 py-2">{{ $person[0]->user->name }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($person as $ps)
                            @if ($ps->process_type_id == 7)
                            @continue
                            @else
                            {{ $ps->process_type->process_type_name }} <br>
                            @endif
                                
                            @endforeach
                        </td>
                        {{-- Link Benerin --}}
                        <td class="border px-3 py-2 text-center">
                            <a href="/user/{{ $person[0]->user->id }}/edit" class="bg-blue-500 text-white p-1.5 rounded">Edit</a>
                            <!--<form action="/user/{{ $person[0]->user->id }}" method="POST" class="inline">-->
                            <!--    @csrf-->
                            <!--    @method('DELETE')-->
                            <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                            <!--</form>-->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection