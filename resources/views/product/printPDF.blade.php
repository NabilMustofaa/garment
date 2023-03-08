<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite('resources/css/app.css')
</head>
<body>
    <div style="display:flex; justify-content:space-between; align-items:center">
        {!! QrCode::size(400)->generate(url('/product/'.$product->id)) !!}
        
        <h1 style="margin: 0 1rem 0 1rem;font-size:98px;width:50%;font-weight:900">{{ $product->material->material_name }} // {{ $product->kode_produk }} </h1>
    </div>

</body>
</html>