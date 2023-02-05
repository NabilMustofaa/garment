@extends('layouts.main')
@section('container')

@if (session('success'))
<div class="bg-green-300 text-black p-4 mb-4 rounded-lg transition duration-150 ease-out">
    {{ session('success') }}
</div>
@endif

<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label">Form Material</label>
                    @if ($errors->any())
                        <script>
                            alert($errors);
                        </script>
                    @endif
                    <form action="/material" method="POST" id="createMaterial" class="flex flex-col m-12" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="label">Material Name</label>
                            <div class="control">
                                <input required class="input" type="text" name="name" id="name" placeholder="Material Name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label">Material Description</label>
                            <div class="control">
                                <textarea required class="textarea" name="description" id="description" placeholder="Material Description"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
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
                        </div>
                        <div class="mb-3">
                            <label class="label">Material Category</label>
                            <div class="select" name="category" id="category">
                                <select name="category" id="selectType" class=" border border-gray-400 p-2 mb-3">
                                    <option value="0" selected>Select to filter by Category...</option>
                                    @foreach ($materialCategory as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <select name="sub_category_id" id="selectSubType" class="border border-gray-400 p-2" disabled>
                                    <option value="0">Please select category first</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label mt-2">Material Image</label>
                                <div class="flex">
                                    <input class="block w-full text-sm text-gray-900 border rounded-lg p-2" id="file_input" name="material_image" type="file">
                                    <img src="" alt="" id="image" class=" w-24 h-24 hidden object-cover">
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