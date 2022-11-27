@extends('layouts.main')
@section('content')

<h1>Create User</h1>
<form action="/user" method="POST">
    @csrf
    <div class="mb-4">
        <label for="name" class="sr-only">Name</label>
        <input type="text" name="name" id="name" placeholder="Your Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">
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
            <label for="role">{{ $process->process_type_name }}</label>
            <input type="checkbox" name="role[]" value="{{ $process->id }}" id="role" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('role') border-red-500 @enderror" value="{{ old('role') }}">
                        
        @endforeach
        </div>
    <h2>Isi untuk mendaftar sebagai user</h2>
    <div class="mb-4">
        <label for="email" class="sr-only">Email</label>
        <input type="text" name="email" id="email" placeholder="Your Email" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}">
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