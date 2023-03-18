@extends('layouts.main')
@section('container')
    <div class="container shadow-md">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card sm:rounded-lg" style="padding: 2rem">
                    <div class="card-body">
                        <div class="formpost {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">
                        <label class="label">Create Process Form</label>
                        <form action="/process" method="POST">
                            @csrf
                            <h1></h1>
                            <div class="mb-4">
                                <input type="hidden" name="production_id" id="production_id" value="{{ $production->id }}">

                                <input type="hidden" name="process_status" id="process_status" value="menunggu">
                            </div>

                            <div class="mb-4">
                                <input type="hidden" name="process_name" id="process_name" placeholder="Name"
                                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="">
                            </div>
                            <div class="mb-4">
                                <label for="process_id">Pilih Prosess</label>
                                <select id="process_id" name="process_id"
                                    class="bg-gray-100 border-2 w-full p-3 rounded-lg ">
                                    
                                    @foreach ($processes as $process)
                                        @if (
                                            array_search( $process->process_type,[1,5]) !== false
                                            )
                                            @continue
                                        @else
                                            <option value="{{ $process->id }}" class="{{ $process->process_type }}">
                                                {{ $process->process_name }}</option>
                                        @endif
                                    @endforeach
                                    <option value="99">Produksi untuk {{ $production->production_name }}</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="user_id">Pilih User</label>
                                <select name="user_id" id="user_id" class="bg-gray-100 border-2 w-full p-3 rounded-lg">
                                    @foreach ($person as $user)
                                        <option value="{{ $user->user->id }}">{{ $user->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-4" id="potongOutput">
                                <div>
                                    <label for="process_output_material_id">Pilih Output</label>
                                    <div class="flex flex-row gap-2">
                                        <select name="process_output_material_id" id="process_output_material_id"
                                        class="bg-gray-100 border-2 w-11/12 p-3 rounded-lg">
                                        <option value="0">Potong Baju</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                                        @endforeach
                                        </select>
                                        <a href="/production/{{ $production->id }}/size" class="text-white bg-blue-500 rounded-md px-4 py-3 w-1/12 text-center">Tambah</a>
                                    </div>
                                    <input type="number" name="process_output_quantity" id="process_output_quantity"
                                        placeholder="Quantity" class="flex bg-gray-100 border-2 w-full p-3 rounded-lg"
                                        value="{{ old('process_output_quantity') }}">
                                </div>
                                <div class="hidden flex-wrap" id="ukuranBagian">
                                    @foreach ($ukuranBagian as $item)
                                        <div class="flex flex-col w-1/4 mt-2">
                                            <h1>{{ $item->material_name }}</h1>
                                            <input type="number" class="border border-gray-400 p-2"
                                                name="{{ 'process_output_bagian_' . $item->id }}" value=0>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <button type="submit" id="submitProcess"
                                    class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
                            </div>

                        </form>
                    </div>

                        <center>
                            <br><br>
                            <hr class="navbar-divider">
                            <label class="label">Sub Process Table</label>
                            <hr class="navbar-divider">
                        </center>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($processes->whereNotIn('process_type', [1,5]) as $p)

                            <div>
                                <div class="flex flex-row justify-between mt-12">
                                    <div>
                                    <h1 class=" font-bold">{{ $p->process_name }}</h1>
                                    <h1>Input Quantity</h1>
                                    </div>
                                    {{-- <div>
                                        @if ($p->process_type == 5)
                                        <button class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full"
                                        onclick="showSubProses('{{ $p->id }}')">Kirim ke Toko</button>
                                        @endif
                                    </div> --}}
                                </div>
                                @php
                                    $input = 0;
                                @endphp
                                @foreach ($p->processMaterial->where('process_material_status', 'Input Produksi') as $pm)
                                    @if ($input > 5)
                                        <span class="list_{{ $p->id }} hidden">
                                            - {{ $pm->process_material_name }}/{{ $pm->process_material_quantity }}
                                            <br>
                                        </span>
                                    @else
                                        <span class="list_{{ $p->id }}">
                                            - {{ $pm->process_material_name }}/{{ $pm->process_material_quantity }}
                                            <br>
                                        </span>
                                    @endif
                                    @php
                                        $input++;
                                    @endphp
                                @endforeach
                                @if ($p->processMaterial->where('process_material_status', 'Input Produksi')->count() > 5)
                                    <button class="text-blue-500" id="showInput_{{ $p->id }}"
                                        onclick="showInput('{{ $p->id }}')">Show More</button>
                                    <button class="text-blue-500 hidden" id="hideInput_{{ $p->id }}"
                                        onclick="hideInput('{{ $p->id }}')">Show Less</button>
                                @endif

                            </div>
                            @foreach ($p->subProses->GroupBy('user_id') as $subGroup)
                                <div class=" border border-gray-300 shadow-md rounded-md mb-10" id="subproses">
                                    <input type="hidden" id="table_no" value="{{ $no }}">
                                    <div class="grid grid-cols-8 gap-6 font-bold p-3 bg-gray-300">
                                        <h3>Nama Material</h3>
                                        <h3>Projected</h3>
                                        <h3>Actual</h3>
                                        <h3>Sisa</h3>
                                        <h3 class="col-span-3">Ambil</h3>
                                        <h1 class=" justify-end text-right">Pengerja :
                                            {{ $subGroup[0]->user->name }}</h1>
                                    </div>
                                    @php
                                        $rows = 0;
                                    @endphp
                                    <div id="row">
                                        
                                    </div>
                                    @foreach ($subGroup as $sp)
                                        @if ($rows < 5)
                                            <div id="row">
                                                <br>
                                                <form action="/subproses/{{ $sp->id }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-8 gap-6 px-3">
                                                        <p class="">
                                                            {{ $sp->processMaterial->process_material_name }}</p>
                                                        <input type="hidden" name="user_id" id="user_{{ $sp->id }}"
                                                            value="{{ $sp->user_id }}">
                                                        <input type="hidden" name="process_id"
                                                            id="process_{{ $sp->id }}"
                                                            value="{{ $sp->process_id }}">
                                                        <p>Target : {{ $sp->sub_proses_projected }}</p>
                                                        <p>Target : {{ $sp->sub_proses_actual }}</p>
                                                        <p>Target :
                                                            {{ $sp->sub_proses_projected - $sp->sub_proses_actual }}</p>
                                                        @if (array_search($p->process_type, [2, 3]) !== false)
                                                                <input type="number" name="quantityAmbil"
                                                                id="quantity_{{ $sp->id }}"
                                                                class=" border border-gray-200 rounded-md text-center px-2 py-3"
                                                                value="0"
                                                                max="{{ $sp->sub_proses_projected - $sp->sub_proses_actual }}"
                                                                onchange="submitAll({{ $no }},{{ $sp->id }})">
                                                            <button type="submit"
                                                                class="bg-blue-500 text-white px-2 py-3 rounded font-medium {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Update</button>
                                                            @if (!$sp->subProcessHistories->isEmpty())
                                                                <button type="button"
                                                                    class="bg-red-500 text-white px-4 py-3 rounded font-medium"
                                                                    id="button_{{ $sp->id }}"
                                                                    onclick="openDetail({{ $sp->id }})">Check
                                                                    Detail</button>
                                                            @endif     
                                                        @else
                                                            <h1 class="text-center col-span-3">Actual dan Sisa akan terupdate berdasarkan scan QR</h1>                                                        
                                                        @endif
                                                </form>
                                                <form action="/subproses/{{ $sp->id }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                                                </form>
                                            </div>
                                            <br>
                                            <hr class="navbar-divider">
                                </div>

                                @if (!$sp->subProcessHistories->isEmpty())
                                    <div id="detail_{{ $sp->id }}" class=" mb-4 hidden detail">
                                        <h3 class="font-bold">Detail Pengambilan</h3>
                                        <div class="grid grid-cols-8 gap-6">

                                            <h3>Quantity</h3>
                                            <h3>Time</h3>
                                        </div>
                                        @foreach ($sp->subProcessHistories as $history)
                                            <div class="grid grid-cols-8 gap-6">
                                                <p>{{ $history->quantity }}</p>
                                                <p>{{ $history->created_at }}</p>
                                                @if ($history->is_done != 1)
                                                    <a href="/subproses/{{ $history->id }}"
                                                        class="bg-blue-500 text-white px-4 py-3 rounded font-medium"
                                                        target="_blank">Check</a>
                                                    <form action="/subproses/history/{{ $history->id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                                                    </form>
                                                    <a href="/generate/{{ $history->id }}"
                                                        class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Generate
                                                        QR</a>
                                                    <button type="button"
                                                        class="bg-red-500 text-white px-4 py-3 rounded font-medium"
                                                        onclick="printExternal('{{ '/print/' . $history->id }}')">Print</button>
                                                @else
                                                    <a href="/subproses/{{ $history->id }}"
                                                        class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                                                    <p>Telah dikonfimasi</p>
                                                @endif

                                            </div>
                                            <br>
                                            <hr class="navbar-divider">
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div id="row" style="display: none">
                                    <br>
                                    <form action="/subproses/{{ $sp->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-8 gap-6">
                                            <p class="row-span-2">{{ $sp->processMaterial->process_material_name }}</p>
                                            <input type="hidden" name="user_id" id="user_{{ $sp->id }}"
                                                value="{{ $sp->user_id }}">
                                            <input type="hidden" name="process_id" id="process_{{ $sp->id }}"
                                                value="{{ $sp->process_id }}">
                                            <p>Target : {{ $sp->sub_proses_projected }}</p>
                                            <p>Target : {{ $sp->sub_proses_actual }}</p>
                                            <p>Target : {{ $sp->sub_proses_projected - $sp->sub_proses_actual }}</p>
                                            @if (array_search($p->process_type, [2, 3]) !== false)
                                                <input type="number" name="quantityAmbil" id="quantity_{{ $sp->id }}"
                                                class=" border border-gray-200 rounded-md text-center" value="0"
                                                max="{{ $sp->sub_proses_projected - $sp->sub_proses_actual }}"
                                                onchange="submit({{ $no }},{{ $sp->id }})">
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-4 py-3 rounded font-medium {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}">Update</button>
                                            @if (!$sp->subProcessHistories->isEmpty())
                                                <button type="button"
                                                    class="bg-red-500 text-white px-4 py-3 rounded font-medium"
                                                    id="button_{{ $sp->id }}"
                                                    onclick="openDetail({{ $sp->id }})">Check Detail</button>
                                            @endif
                                                
                                            @endif
                                    </form>
                                    <form action="/subproses/{{ $sp->id }}" method="POST" class="m-0" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                                    </form>
                                </div>
                                <br>
                                <hr class="navbar-divider">
                    </div>

                    @if (!$sp->subProcessHistories->isEmpty())
                        <div id="detail_{{ $sp->id }}" class=" mb-4 detail hidden">
                            <h3 class="font-bold">Detail Pengambilan</h3>
                            <div class="grid grid-cols-8 gap-6">

                                <h3>Quantity</h3>
                                <h3>Time</h3>
                            </div>
                            @foreach ($sp->subProcessHistories as $history)
                                <div class="grid grid-cols-8 gap-6">
                                    <p>{{ $history->quantity }}</p>
                                    <p>{{ $history->created_at }}</p>
                                    @if ($history->is_done != 1)
                                        <a href="/subproses/{{ $history->id }}"
                                            class="bg-blue-500 text-white px-4 py-3 rounded font-medium"
                                            target="_blank">Check</a>
                                        <form action="/subproses/history/{{ $history->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                                        </form>
                                        <a href="/generate/{{ $history->id }}"
                                            class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Generate QR</a>
                                        <button type="button" class="bg-red-500 text-white px-4 py-3 rounded font-medium"
                                            onclick="printExternal('{{ '/print/' . $history->id }}')">Print</button>
                                    @else
                                        <a href="/subproses/{{ $history->id }}"
                                            class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                                        <p>Telah dikonfimasi</p>
                                    @endif

                                </div>
                                <br>
                                <hr class="navbar-divider">
                                <br>
                            @endforeach
                        </div>
                    @endif
                    @endif
                    @php
                        $rows++;
                    @endphp
                    @endforeach
                    <div class="flex justify-between align-middle">
                        <div>
                            {{-- susah diimplementasi --}}
                            {{-- @if ($p->process_type == 2)
                            <select class="border border-gray-200 rounded-md text-center py-2.5">
                                @foreach ($bagians as $bagian)
                                    <option value="{{ $bagian->id }}">{{ $bagian->name }}</option>
                                @endforeach
                            </select>
                            @endif --}}
                        </div>
                        <div class="flex justify-center">

                            <input type="hidden" id="selectedPage_{{ $no }}" value="1">
                            <button href="#" id="previousButton_{{ $no }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-gray-700 hidden"
                                onclick="previousPage({{ $no }})">
                                <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Previous
                            </button>
                            <div id="pagination_{{ $no }}" class="flex">

                            </div>
                            <button href="#" id="nextButton_{{ $no }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100 hover:text-gray-700 "
                                onclick="nextPage({{ $no }})">
                                Next
                                <svg aria-hidden="true" class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <form action="/submit/all" method="POST" id="submitAll_{{ $no }}" class="flex m-0">
                            @csrf

                            <button type="submit" class="bg-blue-500 text-white  rounded font-medium py-2 px-3 {{  Auth::user()->is_admin == 0 ? 'hidden' : '' }}"
                                id="buttonSubmitAll_{{ $no }}" value="0">Submit All</button>
                        </form>
                    </div>
                </div>
                @php
                    $no++;
                @endphp
                @endforeach
                @endforeach

                <center>
                    <br><br>
                    <hr class="navbar-divider">
                    <label class="label">Product List</label>
                    <hr class="navbar-divider">
                </center>
                <div class="flex flex-row justify-between">
                    <div>
                    <div>
                        <select>
                            <option value="0">Filter by Ukuran</option>
                        </select>

                        <select>
                            <option value="0">Filter by Warna</option>
                        </select>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nama Produk</th>
                                <th class="px-4 py-2">Kode</th>
                                <th class="px-4 py-2">Process Terakhir</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ( $products as $product )
                            <tr>
                                <td class="border px-4 py-2">{{ $product->material->material_name }}</td>
                                <td class="border px-4 py-2">{{ $product->kode_produk }}</td>
                                <td class="border px-4 py-2">{{ $product->currentProcess->process_name }}</td>
                                <td class="border px-4 py-2">
                                    <a href="/product/{{ $product->id }}"
                                        class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                                    <button
                                        onclick="printExternal('{{ '/product/print/' . $product->id }}')"
                                        class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Print</button>
                                </td>
                            </tr>
                            
                        @endforeach

                {{-- @foreach ($processes as $process)
                @if ($process->process_type == 1 || $process->process_type == 2 || $process->process_type == 5 )
                    @continue
                @endif
                <div>
                    <div class="flex flex-row justify-between mt-12">
                        <div>
                        <h1 class=" font-bold">{{ $process->process_name }}</h1>
                        <div>
                            <select>
                                <option value="0">Filter by Ukuran</option>
                            </select>

                            <select>
                                <option value="0">Filter by Warna</option>
                            </select>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nama Produk</th>
                                    <th class="px-4 py-2">Kode</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Pekerja</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    @foreach ($products as $product)
                        @foreach ($product as $item)
                                @foreach ($item->productLog->where('process_id', $process->id) as $log)
                                    
                                    @if($log->accepted_at != null)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $item->material->material_name }}</td>
                                            <td class="border px-4 py-2">{{ $item->kode_produk }}</td>
                                            <td class="border px-4 py-2">{{ $log->accepted_at == null ? 'Belum Dikerjakan' : $log->accepted_at }}</td>
                                            <td class="border px-4 py-2">{{ $log->user_id == null ? 'Belum Dikerjakan' : $log->user->name }}</td>
                                            <td class="border px-4 py-2">
                                                <a href="/product/{{ $item->id }}"
                                                    class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                                                <button
                                                    onclick="printExternal('{{ '/product/print/' . $item->id }}')"
                                                    class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Print</button>
        
                                            </td>
                                        </tr>
                                    @elseif ($log->process_id == $item->current_process_id)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->material->material_name }}</td>
                                        <td class="border px-4 py-2">{{ $item->kode_produk }}</td>
                                        <td class="border px-4 py-2">{{ $log->accepted_at == null ? 'Belum Dikerjakan' : $log->accepted_at }}</td>
                                        <td class="border px-4 py-2">{{ $log->user_id == null ? 'Belum Dikerjakan' : $log->user->name }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="/product/{{ $item->id }}"
                                                class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                                            <button
                                                onclick="printExternal('{{ '/product/print/' . $item->id }}')"
                                                class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Print</button>
    
                                        </td>
                                    </tr>
                                    @endif
                                    
                                    
                                @endforeach
                        @endforeach
                    @endforeach
                            </tbody>
                        </table>
                        </div>
                        </div>
                </div>
                @endforeach --}}

            </div>
        </div>
    </div>
    </div>
    </div>


    <script src="{{ asset('js/process.js') }}"></script>
@endsection
