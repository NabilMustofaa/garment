@extends('layouts.main')
@section('container')

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label text-center mb-4">Form Tipe Produksi</label>
                    <Form method="POST" action="/productiontype/{{ $productionType->id }}" >
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" id="name" placeholder="Production Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg mt-4 mb-4 @error('name') border-red-500 @enderror" value="{{ $productionType->production_type_name }}">
                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                            <div class="mb-4 ml-2">
                                <label for="role" class="sr-only">Role</label>
                                <div class="flex flex-col mt-4">
                                    @foreach ($processTypes as $process)
                                        @if (in_array($process->id, $productionType->production_process->pluck('process_type_id')->toArray()))
                                            <label for="process">{{ $process->process_type_name }}</label>
                                            <input type="checkbox" name="process[]" value="{{ $process->id }}" class="bg-gray-100 border-2 w-full rounded-lg" checked>
                                        @else
                                            <label for="process">{{ $process->process_type_name }}</label>
                                            <input type="checkbox" name="process[]" value="{{ $process->id }}" class="bg-gray-100 border-2 w-full rounded-lg">
                                    @endif
                                @endforeach
                                </div>
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