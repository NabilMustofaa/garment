@extends('layouts.main')

@section('content')

<h1>Edit Form Production</h1>

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

<form action="/production/{{ $production->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="production_name" >Name</label>
        <input type="text" name="production_name" id="production_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_name }}">
    </div>
    <div class="mb-4">
        <label for="production_description" >Description</label>
        <input type="text" name="production_description" id="production_description" placeholder="Description" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_description }}">
    </div>
    <div class="mb-4">
        <label for="production_status" >Status</label>
        <input type="text" name="production_status" id="production_status" placeholder="Status" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_status }}">
    </div>
    <div class="mb-4">
        <label for="production_projected_end_date" >Projected End Date</label>
        <input type="date" name="production_projected_end_date" id="production_projected_end_date" placeholder="Projected End Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_projected_end_date }}">
    </div>
    <div class="mb-4">
        <label for="production_output_quantity" >Output Quantity</label>
        <input type="number" name="production_output_quantity" id="production_output_quantity" placeholder="Output Quantity" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_output_quantity }}">
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
    </div>  
</form>

<h1>Create Process form</h1>

<form action="/api/process" method="POST" id="process">
    @csrf
    <div class="mb-4">
        <input type="hidden" name="production_id" id="production_id" value="{{ $production->id }}">
        <input type="hidden" name="user_id" id="user_id" value="1">
        <input type="hidden" name="process_status" id="process_status" value="menunggu">
    </div>
    <div class="mb-4">
        <label for="process_name" >Name</label>
        <input type="text" name="process_name" id="process_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_name') }}">
    </div>

    <div class="mb-4">
        <div>
            <label for="process_input_material_id" >Material</label>
            <select name="process_input_material_id" id="process_input_material_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="process_input_quantity" >Material Quantity</label>
            <input type="number" name="process_input_quantity" id="process_input_quantity" placeholder="Material Quantity" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>
    </div>

    <div class="mb-4">
        <div>
            <label for="process_output_material_id" >Material</label>
            <select name="process_output_material_id" id="process_output_material_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="process_output_quantity" >Material Quantity</label>
            <input type="number" name="process_output_quantity" id="process_output_quantity" placeholder="Material Quantity" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>
    </div>

    <div class="mb-4">
        <label for="process_start_date" >Projected Start Date</label>
        input with current date
        <input type="date" name="process_start_date" id="process_start_date" placeholder="Projected Start Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ date('Y-m-d'),old('process_start_date') }}">
    </div>

    <div class="mb-4">
        <label for="process_end_date" >Projected End Date</label>
        <input type="date" name="process_end_date" id="process_end_date" placeholder="Projected End Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ date('Y-m-d'),old('process_end_date') }}">
    </div>
    <div>
        <button type="button" id="submitProcess" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
    </div>

</form>

<h1>Process Tabel</h1>

<table class="table-auto" id="process">
    <thead>
        <tr>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Input Material</th>
            <th class="px-4 py-2">Input Quantity</th>
            <th class="px-4 py-2">Output Material</th>
            <th class="px-4 py-2">Output Quantity</th>
            <th class="px-4 py-2">Start Date</th>
            <th class="px-4 py-2">End Date</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Message</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($processes as $process)
            <tr>
                <td class="border px-4 py-2">{{ $process->process_name }}</td>
                <td class="border px-4 py-2">{{ $process->process_input_material_id}}</td>
                <td class="border px-4 py-2">{{ $process->process_input_quantity }}</td>
                <td class="border px-4 py-2">{{ $process->process_output_material_id }}</td>
                <td class="border px-4 py-2">{{ $process->process_output_quantity }}</td>
                <td class="border px-4 py-2">{{ $process->process_start_date }}</td>
                <td class="border px-4 py-2">{{ $process->process_end_date }}</td>
                <td class="border px-4 py-2">{{ $process->process_status }}</td>
                <td class="border px-4 py-2">{{ $process->process_message }}</td>
                <td class="border px-4 py-2">
                    <button class="bg-red-500 text-white" id="deleteProcess" data-id="{{ $process->id }}">Delete</button>
                    {!! QrCode::size(100)->generate(url('/').'/change/'. $process->id ) !!}
                </td>
            </tr>
        @endforeach
            
    </tbody>
<script src="{{ asset("js/process.js") }}"></script>


    


@if (session('succes'))
    <div class="bg-green-500 text-white p-2">
        {{ session('succes') }}
        
    </div>
    <script>
        console.log('succes');
    </script>
@endif

@endsection
