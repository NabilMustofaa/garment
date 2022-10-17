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
    <form action="/add/production" method="POST" id="createProduction" class="flex flex-col m-12">
        @csrf
        <label for="name">Production Name</label>
        <input type="text" name="name" id="name" class="border border-gray-400 p-2">
        <label for="description">Production Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-400 p-2"></textarea>
        <label for="end_date">Production End Date</label>
        <input type="date" name="end_date" id="end_date" class="border border-gray-400 p-2">
        <label for="input_quantity">Input Quantity</label>
        <input type="number" name="input_quantity" id="input_quantity" class="border border-gray-400 p-2">
        <label for="material_id">Material Type</label>
        <select name="material_id" id="material_id" class="border border-gray-400 p-2">
            @foreach ($materials as $material)
                <option value="{{ $material->id }}">{{ $material->name }}</option>
            @endforeach
        </select>
        <label for="output_quantity">Projected Output</label>
        <input type="number" name="output_quantity" id="output_quantity" class="border border-gray-400 p-2">

        <button type="submit" class="bg-blue-500 text-white p-2">Submit</button>

    </form>
    @if (session('succes'))
        <div class="bg-green-500 text-white p-2">
            {{ session('succes') }}
        </div>
        
    @endif
</body>
</html>