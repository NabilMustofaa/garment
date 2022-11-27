@extends('layouts.main')
@section('content')
<h1>Create Production Type</h1>

<Form method="POST" action="/productiontype" >
    @csrf
    <div class="mb-4">
        <label for="name" class="sr-only">Name</label>
        <input type="text" name="name" id="name" placeholder="Production Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">
        @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
        <div class="flex">
            @foreach ($processTypes as $process)
            <label for="role">{{ $process->process_type_name }}</label>
            <input type="checkbox" name="role[]" value="{{ $process->id }}" id="role" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('role') border-red-500 @enderror" value="{{ old('role') }}">
            @endforeach
        </div>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Register</button>
</Form>
@endsection