@extends('layouts.main')
@section('container')

    @if (session('success'))
    <div class="bg-green-500 shadow-lg mx-auto w-96 max-w-full text-sm pointer-events-auto bg-clip-padding rounded-lg block mb-3 mr-1" id="static-example" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
        <div class="bg-green-500 flex justify-between items-center py-2 px-3 bg-clip-padding border-b border-green-400 rounded-t-lg">
        <p class="font-bold text-white flex items-center">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
            </svg>
            Produksi</p>
        <div class="flex items-center">
            <button type="button" class="btn-close btn-close-white box-content w-4 h-4 ml-2 text-white border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-white hover:opacity-75 hover:no-underline" data-mdb-dismiss="toast" aria-label="Close"></button>
        </div>
        </div>
        <div class="p-3 bg-green-500 rounded-b-lg break-words text-white">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="card sm:rounded-lg shadow-md" style="padding: 2rem">
        <div class="card-body">
            <label class="label">Tabel Produksi</label>
                <div class="my-2 flex sm:flex-row flex-col">
                    <div class="absolute mt-2 mb-5" style="right:50px">
                        <a href="/production/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Tambah Produksi</a>
                    </div>
                </div>
                <br>
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-7">
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
                                               <li>  {{ $ppm->process_material_name }} / {{ $ppm->process_material_quantity }} </li>
                                               @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                    @endforeach</td>
                                    <td class="flex flex-auto gap-2 border px-8 py-2 text-center">
                                        <a href="/production/{{ $production->id }}" class="bg-green-500 text-white p-1.5 rounded">Detail</a>
                                        <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-1.5 rounded {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Edit</a>
                                        <form action="/production/{{ $production->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white p-1.5 rounded {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Delete</button>
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
                                               <li>  {{ $ppm->process_material_name }} / {{ $ppm->process_material_quantity }} </li>
                                               @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                    @endforeach</td>
                                    <td class="flex flex-auto gap-2 border px-8 py-2 text-center">
                                        <a href="/production/{{ $production->id }}" class="bg-green-500 text-white p-1.5 rounded">Detail</a>
                                        <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-1.5 rounded {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Edit</a>
                                        <form action="/production/{{ $production->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white p-1.5 rounded {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Delete</button>
                                        </form>
                                   
                                </tr>
                                @endif
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="row">
                    <div class="col mt-6 ">
                        {{ $productions->links() }}
                    </div> 
                </div> --}}
                <div class="flex justify-end align-middle mt-8">
                    <div class="flex shadow-md">
                        <input type="hidden" id="selectedPage" value="1">
                        <button href="#" id="previousButton" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" onclick="previousPage()">
                            <span class="" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            
                        </button>
                        <div id="pagination" class="flex">
    
                        </div>
                        <button href="#" id="nextButton" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" onclick="nextPage()">
                            <span class="" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            
                        </button>
                    </div>
                </div>
        </div>
    </div>

    <script src="{{ Asset('js/indexProduction.js') }}"></script>
@endsection