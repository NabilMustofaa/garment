@extends('layouts.main')
@section('content')
<h1>Edit Production Type</h1>

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
        <div class="flex">
            @foreach ($processTypes as $process)
            @if (in_array($process->id, $productionType->production_process->pluck('process_type_id')->toArray()))
                <input type="checkbox" name="process[]" value="{{ $process->id }}" checked>
                <label for="process">{{ $process->process_type_name }}</label>
            @else
                <input type="checkbox" name="process[]" value="{{ $process->id }}">
                <label for="process">{{ $process->process_type_name }}</label>
            @endif
            
            @endforeach
        </div>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Register</button>
</Form>
@endsection