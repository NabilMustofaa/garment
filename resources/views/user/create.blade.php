@extends('layouts.main')
@section('container')

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label text-center">Form User</label>
                    <form action="/user" method="POST">
                        @csrf
                            <div class="mb-4">
                                <label class="label">Name</label>
                                <input type="text" name="name" id="name" placeholder="Your Name" class="bg-gray-100 border-2 w-full p-3 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="label">Role</label>
                                <select name="role[]" id="role" class="bg-gray-100 border-2 w-full p-3 rounded-lg">
                                    @foreach ($processTypes as $process)
                                    <option value="{{ $process->id }}">{{ $process->process_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-4">
                                <label class="label">Email</label>
                                <input type="text" name="email" id="email" placeholder="Your Email" class="bg-gray-100 border-2 w-full p-3 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}"/>
                                @error('email')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="label">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-100 border-2 w-full p-3 rounded-lg @error('password') border-red-500 @enderror" value="">
                                @error('password')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-1">
                                <button type="submit" class="flex-end justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-5">Register</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection