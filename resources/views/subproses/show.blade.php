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
                <td class=" border border-black bg-gray-200">Nama Proses</td>
                <td class=" border border-black">
                    <h2>Proses {{ $subProses->subProcess->process->process_name }}</h2>
                </td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Nama Penyelesai</td>
                <td class=" border border-black"><h1>{{ $subProses->subProcess->user->name }}</h1></td>
                
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Nama Material</td>
                <td class=" border border-black">{{ $subProses->subProcess->processMaterial->process_material_name }}</td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Jumlah Target</td>
                <td class=" border border-black">{{ $subProses->subProcess->sub_proses_projected }}</td>
            </tr>

            <tr>
                <td class=" border border-black bg-gray-200">Jumlah yang sudah di proses</td>
                <td class=" border border-black">{{ $subProses->subProcess->sub_proses_actual }}</td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Jumlah yang diserahkan</td>
                <td class=" border border-black">{{ $subProses->quantity }}</td>
            </tr>
            <tr>
                <td class=" border border-black bg-gray-200">Tanggal Diselesaikan</td>
                <td class=" border border-black">{{ $subProses->subProcess->updated_at }}</td>
            </tr>
        </table>
        <br>
        @if ($subProses->is_done == 1)
            <h1>Sub Process Selesai dan telah dikonfirmasi</h1>

        @else
        <div class="flex">
        <form action="/subproses/update/{{ $subProses->subProcess->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="quantity" value="{{ $subProses->quantity }}">
            <input type="hidden" name="sph_id" value="{{ $subProses->id }}">
            <input type="hidden" name="user_id" value="{{ $subProses->subProcess->user_id }}">
            <input type="hidden" name="process_id" value="{{ $subProses->subProcess->process_id }}">
            <input type="hidden" name="process_material_id" value="{{ $subProses->subProcess->process_material_id }}">
            <input type="hidden" name="production_id" value="{{ $subProses->subProcess->process->production_id }}">
            <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Konfirmasi</button>
        
        </form>
        @if (strpos($subProses->subProcess->process->process_name, 'Potong') === false && strpos($subProses->subProcess->process->process_name, 'Permak') === false && $subProses->subProcess->process->process_type != 8 && $subProses->subProcess->process->process_type != 3)
        <a class="bg-red-500 text-white px-4 py-3 rounded font-medium mx-8" href="/report/{{ $subProses->id }}"> Report Rusak</a>
        @endif
        </div>
        @endif
        
        
    </div>
</body>
<script src="{{ url('https://cdn.tailwindcss.com') }}"></script>
<script type="text/javascript" src="{{ url('js/main.min.js?v=1628755089081')}}"></script>
</html>


