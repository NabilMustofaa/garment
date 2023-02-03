@extends('layouts.main')
@section('container')
<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Edit Production Type</label>
    <hr class="navbar-divider">
    <br>
</center>

<Form method="POST" action="/productiontype/{{ $productionType->id }}" >
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="name" class="sr-only">Name</label>
        <input type="text" name="name" id="name" placeholder="Production Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ $productionType->production_type_name }}">
        @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
        <div class="mb-4">
            <label for="role" class="sr-only">Role</label>
            <div class="flex">
                @foreach ($processTypes as $process)
                    @if (in_array($process->id, $productionType->production_process->pluck('process_type_id')->toArray()))
                        <label for="process">{{ $process->process_type_name }}</label>
                        <input type="checkbox" name="process[]" value="{{ $process->id }}" class="bg-gray-100 border-2 w-full p-4 rounded-lg" checked>
                    @else
                        <label for="process">{{ $process->process_type_name }}</label>
                        <input type="checkbox" name="process[]" value="{{ $process->id }}" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                @endif
            @endforeach
            </div>
        </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Register</button>
</Form>
@endsection