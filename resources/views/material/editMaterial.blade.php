@extends('layouts.main')
@section('container')

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label">Edit Form Material</label>
                    <form action="/material/{{ $material->id }}" method="POST" id="createMaterial" class="flex flex-col m-12" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="label">Material Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" id="name" value="{{ $material->material_name }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label">Material Description</label>
                            <div class="control">
                                <textarea class="textarea" name="description" id="description">{{ $material->material_description }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label">Material Measures</label>
                            <select name="measure_unit" id="measure_unit" class="input">
                                <option value="kg" {{ $material->material_measure_unit == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="l" {{ $material->material_measure_unit == 'l' ? 'selected' : '' }}>l</option>
                                <option value="m" {{ $material->material_measure_unit == 'm' ? 'selected' : '' }}>m</option>
                                <option value="piece" {{ $material->material_measure_unit == 'piece' ? 'selected' : '' }}>piece</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="label">Material Category</label>
                            <div class="select" name="category" id="category">
                                <select name="category" id="selectType" class=" border border-gray-400 p-2 mb-3">
                                    <option value="0" selected>Select to filter by Category...</option>
                                    @foreach ($materialCategory as $category)
                                        <option value="{{ $category->id }}" {{ $material->materialSubCategory->materialCategory->id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option> 
                                    @endforeach
                                </select>
                                <select name="sub_category_id" id="selectSubType" class="border border-gray-400 p-2" >
                                    @foreach ($material->materialSubCategory->materialCategory->materialSubCategory as $subCategory)
                                        <option value="{{ $subCategory->id }}" {{ $material->material_sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->sub_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="mb-3">
                            <label class="label mt-2">Material Image</label>
                            <div class="flex">
                                <input class="block w-full text-sm text-gray-900 border rounded-lg p-2" id="file_input" name="material_image" type="file">
                                <img src="{{  asset('uploads/material/'.$material->material_image) }}" alt="" id="image" class=" w-24 h-24 hidden object-cover">
                            </div>
                                <br>
                                <div class="bg-gray-50 px-4 py-3 text-right sm:px-1">
                            <button type="submit" class="flex-end justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-5">Submit</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="{{ asset("js/formMaterial.js") }}"></script>
@endsection