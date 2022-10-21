@extends('layouts.main')
@section('content')
    <h1>Table Material</h1>
    @if (session('succes'))
        <div class="bg-green-500 text-black p-2">
            {{ session('succes') }}
        </div>
        <script>
            alert('succes');
        </script>
        
    @endif
    <table class="table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Type</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materials as $material)
                <tr>
                    <td class="border px-4 py-2">{{ $material->material_name }}</td>
                    <td class="border px-4 py-2">{{ $material->material_description }}</td>
                    <td class="border px-4 py-2">{{ $material->material_quantity }} {{ $material->material_measure_unit }}</td>
                    <td class="border px-4 py-2">{{ $material->material_type }}</td>
                    <td class="border px-4 py-2">
                        <a href="/material/{{ $material->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                        <form action="/material/{{ $material->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (session()->has('success'))
    <div class="bg-green-500 text-black p-2">
        {{ session('success') }}
    </div>
    <script>
        alert('succes');
    </script>
    @endif
    @endsection