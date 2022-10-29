@extends('layouts.main')

@section('content')

<h1>Table Production</h1>

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
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Projected End Date</th>
            <th class="border px-4 py-2">Output Quantity</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productions as $production)
            <tr>
                <td class="border px-4 py-2">{{ $production->production_name }}</td>
                <td class="border px-4 py-2">{{ $production->production_description }}</td>
                <td class="border px-4 py-2">{{ $production->production_status }}</td>
                <td class="border px-4 py-2"> {{ $production->production_actual_end_date }} / {{ $production->production_projected_end_date }}</td>
                <td class="border px-4 py-2">{{ $production->production_output_quantity }}</td>
                <td class="border px-4 py-2">
                    <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <form action="/production/{{ $production->id }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2">Delete</button>
                    </form>
               
            </tr>
        @endforeach
    </tbody>
</table>

@endsection