@extends('layouts.main')
@section('content')
    <h1>
        FORM Material
    </h1>

    @if ($errors->any())

        <script>
            alert($errors);
        </script>

    @endif
    
    <form action="/material" method="POST" id="createMaterial" class="flex flex-col m-12">
        @csrf
        <label for="name">Material Name</label>
        <input type="text" name="name" id="name" class="border border-gray-400 p-2">
        <label for="description">Material Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-400 p-2"></textarea>
        <label for="quantity">Material Quantity</label>
        <div>
            <input type="number" name="quantity" id="quantity" class="border border-gray-400 p-2">
            <select name="measure_unit" id="measure_unit" class=" ">
                <option value="kg">kg</option>
                <option value="l">l</option>
                <option value="m">m</option>
                <option value="piece">piece</option>
            </select>
        </div>
        <label for="type">Material type</label>
        <select name="type" id="type" class="border border-gray-400 p-2">
            <option value="Raw Material">Raw</option>
            <option value="Semi-Finished">Semi-finished</option>
            <option value="Finished">Finished</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2">Submit</button>
    </form>
    @if (session()->has('success'))
        <div class="bg-green-500 text-black p-2">
            {{ session('success') }}
        </div>
        <script>
            alert('succes');
        </script>
    @endif
    
@endsection