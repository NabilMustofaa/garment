@extends('layouts.main')
@section('container')

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
    <form action="/production" method="POST" id="createProduction" class="flex flex-col m-12">
        @csrf
    <center>
        <hr class="navbar-divider">
        <label class="label">Form Produksi</label>
        <hr class="navbar-divider">
        <br>
    </center>
        <label class="label text-md">Production Name</label>
        <input required class="input" type="text" name="name" id="name" placeholder="Production Name">
        <label class="label text-md">Production Type</label>
        <select name="production_type" id="production_type" class="border border-gray-400 p-2 rounded">
            @foreach ($productionType as $type)
            <option value="{{ $type->id }}">{{ $type->production_type_name }}</option>
            @endforeach
        </select>
        <label class="label text-md">Production Description</label>
        <textarea required class="textarea" name="description" id="description" placeholder="Production Description"></textarea>
        <label for="end_date" class="label text-md">Production End Date</label>
        <input required type="date" name="end_date" id="end_date" class="border border-gray-400 p-2 rounded" value="{{ date('Y-m-d') }}">
    <center>
        <br>
        <hr class="navbar-divider">
            <label class="label">Material</label>
        <hr class="navbar-divider">
        <br>
    </center>
        <div class="materialContainer mb-0">
            <div class="flex h-20">
                <div class="flex flex-col w-3/4">
                    <label for="material_id" class="label">Material Type</label>
                    <div class=" w-full flex flex-row">
                        <select name="category" id="selectType_1" class=" border border-gray-400 p-3 m-0 w-1/3 rounded" onchange="changeSubtype(1)">
                            <option value="0" selected>Select Category</option>
                            @foreach ($materialCategory as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                
                            @endforeach
                        </select>
                
                        <select name="type" id="selectSubType_1" class="border border-gray-400 p-3 m-0 w-1/3 rounded" disabled>
                            <option value="0">Select Sub Category</option>
                        </select>
                        <select name="material_id_1" id="material_id_1" class="border border-gray-400 rounded-sm p-3 h-12 w-1/3 rounded" disabled>
                            <option value="0" selected>Select Sub Category first</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col w-1/4">
                    <label for="input_quantity" class="label">Quantity Material</label>
                    <input required type="number" name="input_quantity_1" id="input_quantity_1" class="border border-gray-400 rounded-sm p-3 h-12 rounded" min="0" >
                </div>
                    <img src="{{ Asset('uploads/material/default.jpg') }}" alt="" class="w-12 h-12 mt-8 object-cover" id="material_image_1">
            </div>
        </div>
        <br>
        <button id="materialButton" type="button" class="bg-blue-500 w-full m-0 p-2 text-white rounded">Add</button>
        <input required type="hidden" name="totalMaterial" id="totalMaterial" value="1">
        
        <center>
            <br>
            <hr class="navbar-divider">
            <label for="output_quantity" class="label">Projected Output</label>
            <hr class="navbar-divider">
        </center>
        <label for="output_quantity" class="label ">Pilih Warna</label>
        
        <div class="flex ">
            <div class="flex flex-col w-full">
                <div class="flex">
                    <input required type="text" name="search" id="colorSearch" class="border border-gray-400 p-2 w-11/12 rounded" placeholder="Search Color">
                    <button type="button" class="bg-blue-500 w-1/12 m-0 p-2 text-white rounded-sm disabled:bg-blue-300" id="colorAdd" disabled> Add</button>
                </div>
                <div class="bg-white w-11/12 shadow-lg p-2 hidden " id="colorList">
                    
                </div>

            </div>
        </div>

        {{-- <div class="flex" id="ukuranInput">
            @foreach ($ukurans as $ukuran)
            <div class="flex flex-col">
                <label for="output_quantity">{{ $ukuran->name }}</label>
                <input required type="number" name="output_quantity[]" id="output_quantity" class="border border-gray-400 p-2" value="0" min="0">
            </div>
            @endforeach
        </div> --}}

        <div id="placeholderInput">
        </div>
       <br>
        <button type="submit" class="button green">Submit</button>

    </form>
    @if (session('succes'))
        <div class="bg-green-500 text-white p-2">
            {{ session('succes') }}
            
        </div>
        <script>
            console.log('succes');
        </script>
    @endif

    <script src="{{ asset('js/production.js') }}"></script>

@endsection