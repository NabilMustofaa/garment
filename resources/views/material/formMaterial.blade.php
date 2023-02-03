@extends('layouts.main')
@section('container')
@if (session()->has('success'))
<div class="bg-green-500 text-black p-2">
    {{ session('success') }}
</div>
<script>
    alert('succes');
</script>
@endif
    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Form Material</label>
        <hr class="navbar-divider">
        <br>
    </center>

    @if ($errors->any())

        <script>
            alert($errors);
        </script>

    @endif
    
    <form action="/material" method="POST" id="createMaterial" class="flex flex-col m-12" enctype="multipart/form-data">
        
        @csrf
        <label class="label">Material Name</label>
            <div class="control">
                <input required class="input" type="text" name="name" id="name" placeholder="Material Name">
            </div>
        <label class="label">Material Description</label>
            <div class="control">
              <textarea required class="textarea" name="description" id="description" placeholder="Material Description"></textarea>
            </div>
        <label class="label">Material Quantity</label>
        <div class="flex">
            <input required type="number" name="quantity" id="quantity" class="input">
            <div>
                <select name="measure_unit" id="measure_unit" class="input">
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                    <option value="m">m</option>
                    <option value="piece">piece</option>
                </select>
            </div>
        </div>
        
        <label class="label">Material Category</label>
        <div class="select" name="category" id="category">
            <select name="category" id="selectType" class=" border border-gray-400 p-2">
                <option value="0" selected>Select to filter by Category...</option>
                @foreach ($materialCategory as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    
                @endforeach
            </select>
    
            <select name="sub_category_id" id="selectSubType" class="border border-gray-400 p-2" disabled>
                <option value="0">Please select category first</option>
            </select>

        </div>

        <label class="label mt-2">Material Image</label>
        <div class="flex">
            <input class="block w-full text-sm text-gray-900 border rounded-lg p-2" id="file_input" name="material_image" type="file">
            <img src="" alt="" id="image" class=" w-24 h-24 hidden object-cover">
        </div>

        <br>
        <button type="submit" class="button green">Submit</button>
    </form>

    <script src="{{ asset("js/formMaterial.js") }}"></script>
@endsection