@extends('layouts.main')
@section('content')
    <h1>
        Edit Material
    </h1>
    <form action="/material/{{ $material->id }}" method="POST" id="createMaterial" class="flex flex-col m-12">
        @csrf
        @method('PUT')
        <label for="name">Material Name</label>
        <input type="text" name="name" id="name" class="border border-gray-400 p-2" value="{{ $material->material_name }}">
        <label for="description">Material Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-400 p-2">{{ $material->material_description }}</textarea>
        <label for="quantity">Material Quantity</label>
        <div>
            <input type="number" name="quantity" id="quantity" class="border border-gray-400 p-2" value="{{ $material->material_quantity }}">
            <select name="measure_unit" id="measure_unit" class=" ">
                <option value="kg" {{ $material->material_measure_unit == 'kg' ? 'selected' : '' }}>kg</option>
                <option value="l" {{ $material->material_measure_unit == 'l' ? 'selected' : '' }}>l</option>
                <option value="m" {{ $material->material_measure_unit == 'm' ? 'selected' : '' }}>m</option>
                <option value="piece" {{ $material->material_measure_unit == 'piece' ? 'selected' : '' }}>piece</option>
            </select>
        </div>
        <label for="type">Material type</label>
        <select name="type" id="type" class="border border-gray-400 p-2">
            <option value="raw" {{ $material->material_type == 'raw' ? 'selected' : '' }}>Raw</option>
            <option value="semi-finished" {{ $material->material_type == 'semi-finished' ? 'selected' : '' }}>Semi-finished</option>
            <option value="finished" {{ $material->material_type == 'finished' ? 'selected' : '' }}>Finished</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2">Submit</button>
    </form>
    
@endsection