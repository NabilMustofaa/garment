@extends('layouts.main')
@section('container')

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Create User</label>
    <hr class="navbar-divider">
    <br>
</center>

<form action="/user" method="POST">
    @csrf
    <div class="mb-4">
        <label class="label">Name</label>
        <input type="text" name="name" id="name" placeholder="Your Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">
        @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label class="label">Role</label>
        <select name="role[]" id="role" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            @foreach ($processTypes as $process)
            <option value="{{ $process->id }}">{{ $process->process_type_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="label">Email</label>
        <input type="text" name="email" id="email" placeholder="Your Email" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}"/>
        @error('email')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label class="label">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" value="">
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