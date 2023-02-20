@extends('layouts.main')
@section('container')

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label text-center mb-4">Form Tipe Proses</label>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        
                    </div>
                    <script>
                        alert('Please fill all the fields');
                    </script>
                    @endif

                    <Form method="POST" action="/processtype/{{ $processType->id }}" >
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" id="name" placeholder="Process Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ $processType->process_type_name }}">
                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-1">
                            <button type="submit" class="flex justify-start rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-5 {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Register</button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection