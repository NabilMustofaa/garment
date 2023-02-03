@extends('layouts.main')

@section('container')

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Tabel Produksi</label>
    <hr class="navbar-divider">
    <br>
</center>

<div class="mb-5">
    <a href="/production/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Tambah Produksi</a>
</div>

@if (session('succes'))
    <div class="bg-green-500 text-black p-2">
        {{ session('succes') }}
    </div>
    <script>
        alert('succes');
    </script>
@endif

<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-200 dark:text-gray-800" id="materialTable">
        <thead class="border-b bg-gray-300">
        <tr>
            <th class="border px-4 py-2 justify-between">
                <button class="w-full" id="sortName" onclick="sort(0)" >
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
            <th class="border px-4 py-2 justify-between">
                <button class="w-full" id="sortName" onclick="sort(1)" >
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
            <th class="border px-4 py-2 justify-between">
                <button class="w-full" id="sortName" onclick="sortDate(2)" >
                <div class="flex justify-between">
                <div>End Date</div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                      </svg>
                    </div>
                </div>
                </button>
            </th>
            <th class="border px-4 py-2 text-center">Projected Output Quantity</th>
            <th class="border px-4 py-2 text-center">Actual Output Quantity</th>
            <th class="border px-4 py-2 text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($productions as $production)
            @if ($no <= 5)
            <tr>
                <td class="border px-4 py-2">{{ $production->production_name }}</td>
                <td class="border px-4 py-2">{{ $production->production_description }}</td>
                <td class="border px-4 py-2">{{ $production->production_projected_end_date }} 
                    @php
                    ///date substract
                    $date1 = new DateTime($production->production_projected_end_date);
                    $date2 = new DateTime(date('Y-m-d'));
                    $diff = $date1->diff($date2);

                    @endphp
                @if ($diff->format('%R%a') > 0)
                    <span class="text-red-600 p-2">( {{ $diff->format('%a') }} Hari Telat )</span>
                @else
                    
                    <span class=" text-green-600 p-2">( {{ $diff->format('%a') }} Hari Lagi )</span>

                @endif
                </td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[1]))
                        @foreach ($pp->processMaterial as $ppm)
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->process_material_quantity }} </li>
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[5]))
                        @foreach ($pp->processMaterial as $ppm)
                            @if($ppm->material->material_quantity == 0)
                                @continue
                            @else
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->material->material_quantity }} </li>
                           @endif
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2">
                    <a href="/production/{{ $production->id }}" class="bg-green-500 text-white p-2 rounded">Detail</a>
                    <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-2 rounded">Edit</a>
                    <form action="/production/{{ $production->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete</button>
                    </form>
               
            </tr>
            @else
            <tr style="display: none">
                <td class="border px-4 py-2">{{ $production->production_name }}</td>
                <td class="border px-4 py-2">{{ $production->production_description }}</td>
                <td class="border px-4 py-2">{{ $production->production_projected_end_date }} 
                    @php
                    ///date substract
                    $date1 = new DateTime($production->production_projected_end_date);
                    $date2 = new DateTime(date('Y-m-d'));
                    $diff = $date1->diff($date2);

                    @endphp
                @if ($diff->format('%R%a') > 0)
                    <span class="text-red-600 p-2">( {{ $diff->format('%a') }} Hari Telat )</span>
                @else
                    
                    <span class=" text-green-600 p-2">( {{ $diff->format('%a') }} Hari Lagi )</span>

                @endif
                </td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[1]))
                        @foreach ($pp->processMaterial as $ppm)
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->process_material_quantity }} </li>
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[5]))
                        @foreach ($pp->processMaterial as $ppm)
                            @if($ppm->material->material_quantity == 0)
                                @continue
                            @else
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->material->material_quantity }} </li>
                           @endif
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2">
                    <a href="/production/{{ $production->id }}" class="bg-green-500 text-white p-2 rounded">Detail</a>
                    <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-2 rounded">Edit</a>
                    <form action="/production/{{ $production->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete</button>
                    </form>
               
            </tr>
            @endif
            @php
                $no++;
            @endphp
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
<script src="{{ Asset('js/indexProduction.js') }}"></script>
@endsection