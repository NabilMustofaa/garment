<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="w-100">
        <h1>{{ $sh->SubProcess->sub_proses_name }}</h1>
        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(500)->generate(url('/subproses/'.$id))) !!} ">
    </div>
</body>
<script>
</script>
</html>