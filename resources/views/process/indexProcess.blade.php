@extends('layouts.main')

@section('content')

<h1>Table Process</h1>

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
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($processes as $process)
            <tr>
                <td class="border px-4 py-2">{{ $process->process_name }}</td>
                <td class="border px-4 py-2">{{ $process->process_description }}</td>
                <td class="border px-4 py-2">
                    <a href="/process/{{ $process->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <form action="/process/{{ $process->id }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection