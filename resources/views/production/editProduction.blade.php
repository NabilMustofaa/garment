@extends('layouts.main')
@section('container')

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
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
                    <label class="label">Edit Form Produksi</label>
                    <form action="/production/{{ $production->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 ml-6">
                            <label for="production_name" >Name</label>
                            <input type="text" name="production_name" id="production_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ $production->production_name }}">
                        </div>
                        <div class="mb-4 ml-6">
                            <label for="production_description" >Description</label>
                            <input type="text" name="production_description" id="production_description" placeholder="Description" class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ $production->production_description }}">
                        </div>
                        
                        <div class="mb-4 ml-6">
                        <label for="production_type" >Type</label>
                        <select name="production_type" id="production_type" class="bg-gray-100 border-2 w-full p-3 rounded-lg">
                            {{ $production->production_type }}
                            @foreach ($productionType as $type)
                                @if ($type->id == $production->production_type)
                                    <option value="{{ $type->id }}" selected>{{ $type->production_type_name }}</option>
                                @else
                                    <option value="{{ $type->id }}">{{ $type->production_type_name  }}</option>    
                                @endif
                    
                            @endforeach
                        </select>
                        </div>
                    
                        <div class="mb-4 ml-6">
                            <label for="production_projected_end_date" >Projected End Date</label>
                            <input type="date" name="production_projected_end_date" id="production_projected_end_date" placeholder="Projected End Date" class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ $production->production_projected_end_date }}">
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-1">
                            <button type="submit" class="flex-end justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-5 mt-2"> Update</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('succes'))
    <div class="bg-green-500 text-white p-2">
        {{ session('succes') }}
        
    </div>
    <script>
        console.log('succes');
    </script>
@endif

@endsection
