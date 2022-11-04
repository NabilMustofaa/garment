<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <h1> FORM</h1>
    {{-- {!! QrCode::size(100)->generate(Request::url()); !!} --}}
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
        <label for="name">Production Name</label>
        <input type="text" name="name" id="name" class="border border-gray-400 p-2">
        <label >Production Type</label>
        <select name="production_type" id="production_type" class="border border-gray-400 p-2">
            @foreach ($productionType as $type)
                <option value="{{ $type->id }}">{{ $type->production_type_name }}</option>
            @endforeach
        </select>
        <label for="description">Production Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-400 p-2"></textarea>
        <label for="end_date">Production End Date</label>
        <input type="date" name="end_date" id="end_date" class="border border-gray-400 p-2" value="{{ date('Y-m-d') }}">
        <div class="flex">
            <div>Material</div>
            <button id="materialButton" type="button" class="bg-blue-500 p-2 mx-4">Add</button>
            <input type="hidden" name="totalMaterial" id="totalMaterial" value="1">
        </div>
        <div class="materialContainer">
            <div class="flex">
                <div class="flex flex-col">
                    <label for="input_quantity">Input Quantit Material 1</label>
                    <input type="number" name="input_quantity_1" id="input_quantity_1" class="border border-gray-400 p-2" value="0" min="0">
                </div>
                <div class="flex flex-col">
                    <label for="material_id">Material Type 1</label>
                    <select name="material_id_1" id="material_id_1" class="border border-gray-400 p-2">
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>
        <label for="output_quantity">Projected Output</label>
        <div class="flex">
            @foreach ($ukurans as $ukuran)
            <div class="flex flex-col">
                <label for="output_quantity">{{ $ukuran->name }}</label>
                <input type="number" name="output_quantity_{{ $ukuran->id }}" id="output_quantity_{{ $ukuran->id }}" class="border border-gray-400 p-2" value="0" min="0">
            </div>
            @endforeach
        </div>
       
        

        <button type="submit" class="bg-blue-500 text-white p-2">Submit</button>

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
</body>
</html>