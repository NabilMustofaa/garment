<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="{{ url('css/main.css?v=1628755089081')}}">
  <link rel="stylesheet" href="{{ url('https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css')}}">

</head>
<body class=" p-4">
    <div class=" p-0">
        <h1 class=" text-xl font-bold my-4"> Laporan Hasil Kerja</h1>
        <table class="table-fixed">
            <tr>
                <td class=" border border-black bg-gray-200">Nama Material</td>
                <td class=" border border-black">
                    <h2>{{ $product->material->material_name }}</h2>
                </td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Kode Produk</td>
                <td class=" border border-black"><h1>{{ $product->kode_produk }}</h1></td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Nama Produksi</td>
                <td class=" border border-black">{{ $product->production->production_name }}</td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Process Sekarang</td>
                <td class=" border border-black font-bold">{{ $product->currentProcess->process_name }}</td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Process Selanjutnya</td>
                <td class=" border border-black">{{ $nextProcess->process_name }}</td>
            </tr>


            
        </table>
        <br>
        <div class="flex flex-col my-4 {{ $product->currentProcess->id == $nextProcess->id ? 'hidden' : '' }}">
            <form action="/product/{{ $product->id }}/update" method="POST">
                @method('PUT')
                @csrf
                <select name="sub_process_id" class="input h-12" required>
                    @if ($subProcesses->count() == 0)
                        <option disabled>Silahkan Buat Target Produksi Terlebih Dahulu</option>
                        
                    @endif
                    @foreach ( $subProcesses as $subProcess )
                        <option value="{{ $subProcess->id }}">{{ $subProcess->user->name}}</option>
                    @endforeach
                </select>
                <div class="flex my-4 ">
                    <button class="bg-blue-500 text-white px-4 py-3 rounded font-medium " value="0" name="permak"> Konfirmasi</button>
                    @if ( strpos($product->currentProcess->process_name, 'Permak') === false && strpos($product->currentProcess->process_name, 'Kirim') === false )
                    <button class="bg-red-500 text-white px-4 py-3 rounded font-medium mx-4" value="1" name="permak"> Report Rusak</button>
                    @endif
                    
                </div>
            </form>
        </div>
        
        @if ($product->currentProcess->id == $nextProcess->id )
            Proses untuk {{ $product->material->material_name }} sudah selesai pada {{ $product->productLog->last()->accepted_at }}
        @endif

        <h1>Log</h1>
        <table class="table-fixed">
            <tr>
                <td class=" border border-black bg-gray-200">Nama Material</td>
                <td class=" border border-black bg-gray-200">Nama Process</td>
                <td class=" border border-black bg-gray-200">Nama User</td>
                <td class=" border border-black bg-gray-200">Tanggal</td>
            </tr>
            @foreach ($product->productLog as $log)
            <tr>
                <td class=" border border-black">{{ $log->product->material->material_name }}</td>
                <td class=" border border-black">{{ $log->process->process_name }}</td>
                <td class=" border border-black">{{ $log->user != null ?  $log->user->name : '' }}</td>
                <td class=" border border-black">{{ $log->accepted_at }}</td>
            </tr>
            @endforeach
        
    </div>

    <script>
        @if (session('alert'))
            alert('{{ session('alert') }}');
        @endif
    </script>
    <script src="{{ url('https://cdn.tailwindcss.com') }}"></script>
    <script type="text/javascript" src="{{ url('js/main.min.js?v=1628755089081')}}"></script>
</body>

</html>


