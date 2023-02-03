@extends('layouts.main')
@section('container')

@if (session('success'))
<div class="bg-green-500 text-black p-2">
    {{ session('success') }}
</div>
<script>
    alert('success');
</script>

@endif
    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Tabel Material</label>
        <hr class="navbar-divider">
        <br>
    </center>
    <div class="my-2 flex sm:flex-row flex-col">
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="category" id="selectType" class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="0" selected>Filter by Category</option>
                    @foreach ($materialCategory as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <select name="type" id="selectSubType" class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500" disabled>
                <option value="0">Please select category first</option>
            </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
        </div>
                    </div>
                </div>
                <div class="relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input type="text" name="search" id="search" placeholder="Search Items"
                        class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
                <div class="absolute"style="right:25px">
        <a href="/material/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Tambah Material</a>
                </div>
    </div>



    <br>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-200 dark:text-gray-800" id="materialTable">
        <thead class="border-b bg-gray-300">
            <tr>
                <th class="border px-4 py-2 text-center">Image</th>
                <th class="border px-4 py-2 w-1/5 justify-between">
                    <button class="w-full" id="sortName" onclick="sort(1)" >
                    <div class="flex justify-between">
                    <div>Name</div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                          </svg>
                        </div>
                    </div>
                    </button>
                </th>
                
                <th class="border px-4 py-2 w-1/5">
                    <button class="w-full" id="sortName" onclick="sort(2)" >
                    <div class="flex justify-between">
                    <div>Description</div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                          </svg>
                        </div>
                    </div>
                    </button>
                </th>
                <th class="border px-4 py-2 w-1/5">
                    <button class="w-full" id="sortName" onclick="sort(3)" >
                    <div class="flex justify-between">
                    <div>Category</div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                          </svg>
                        </div>
                    </div>
                    </button>
                </th>
                <th class="border px-4 py-2 w-1/5" ><div class="flex justify-between">
                    <button class="w-full" id="sortName" onclick="sortNumber(4)" >
                        <div class="flex justify-between">
                    <div>Quantity</div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                          </svg>
                        </div>
                    </div>
                    </div>
                    </button>
                    </th>
                    
                <th class="border px-4 py-2 w-1/5 text-center">Action</th>
            </tr>
        </thead>
        <tbody id="materialTableBody">
            @php
                $count = 0;
            @endphp
            @foreach ($materials as $material)
                @if (strpos($material->material_name,'(Rusak)') !== false)
                    @continue
                @else
                @if ($count <= 9)
                <tr class="{{ $material->material_sub_category_id }}">
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800"><img src="{{ asset('uploads/material/' . $material->material_image) }}" alt="" class="w-20"></td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800" >{{ $material->material_name }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->material_description }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->materialSubCategory->materialCategory->category_name }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->material_quantity }} {{ $material->material_measure_unit }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">
                        <a href="/material/{{ $material->id }}" class="bg-green-500 text-white p-2 rounded">History</a>
                        <a href="/material/{{ $material->id }}/edit" class="bg-blue-500 text-white p-2 rounded">Edit</a>
                        <form action="/material/{{ $material->id }}" method="POST" class="inline" onsubmit="return confirm('are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @else
                <tr class="{{ $material->material_sub_category_id }}" style="display: none">
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800"><img src="{{ asset('uploads/material/' . $material->material_image) }}" alt="" class="w-20"></td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800" >{{ $material->material_name }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->material_description }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->materialSubCategory->materialCategory->category_name }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">{{ $material->material_quantity }} {{ $material->material_measure_unit }}</td>
                    <td class="border px-4 py-2 text-gray-200 dark:text-gray-800">
                        <a href="/material/{{ $material->id }}" class="bg-green-500 text-white p-2 rounded">History</a>
                        <a href="/material/{{ $material->id }}/edit" class="bg-blue-500 text-white p-2 rounded">Edit</a>
                        <form action="/material/{{ $material->id }}" method="POST" class="inline" onsubmit="return confirm('are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endif
                @php
                    $count++;
                @endphp
                
                
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-center align-middle">
        <input type="hidden" id="selectedPage" value="1">
        <button href="#" id="previousButton" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-gray-700 hidden" onclick="previousPage()">
            <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            Previous
        </button>
          <div id="pagination" class="flex">

          </div>
          <button href="#" id="nextButton" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100 hover:text-gray-700 " onclick="nextPage()">
            Next
            <svg aria-hidden="true" class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
    </div>
    
    </div>


    <script src="{{ asset("js/material.js") }}"></script>
    @endsection