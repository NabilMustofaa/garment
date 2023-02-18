<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body style="width: 100%">  
    <div style="display:grid; grid-template-columns: 1fr 1fr; justify-content:space-between; padding: 1rem; align-items:center;grid-gap: 1rem">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(250)->generate(url('/subproses/'.$id))) !!}" style="display: inline; margin: 10% 5% -10% 0;">
        <h2 style="display: inline; margin: -10vh 2vw; text-align: center;align-self: center">
            {{ $sh->SubProcess->process->process_type == 2 ? $sh->SubProcess->process->production->production_name : '' }} <span>  </span> {{ $sh->SubProcess->sub_proses_name }}</h2>
    </div>
</body>
<script>
</script>
</html>