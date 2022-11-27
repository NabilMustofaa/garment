@extends('layouts.main')
@section('content')

<h1>Create User</h1>
<form action="/user/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="name" class="sr-only">Name</label>
        <input type="text" name="name" id="name" placeholder="Your Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ $user->name }}">
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
            @if (in_array($process->id, $user->personProcess->pluck('process_type_id')->toArray()))
                <input type="checkbox" name="process[]" value="{{ $process->id }}" checked>
                <label for="process">{{ $process->process_type_name }}</label>
            @else
                <input type="checkbox" name="process[]" value="{{ $process->id }}">
                <label for="process">{{ $process->process_type_name }}</label>
            @endif
                        
        @endforeach
        </div>
    <h2>Isi untuk mendaftar sebagai user</h2>
    <div class="mb-4">
        <label for="email" class="sr-only">Email</label>
        <input type="text" name="email" id="email" placeholder="Your Email" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ $user->email }}">
        @error('email')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    
    <div class="mb-4">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" placeholder="Choose a password" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" value="">
        @error('password')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Register</button>
    </div>
</form>
@endsection