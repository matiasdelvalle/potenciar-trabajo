<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font:'sans-serif';
            margin:auto;
            text-align:center;
        }
    </style>
</head>
<body>
    <p>Cerficado:</p>
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate( url('acreditaciones/'.$url) )) !!} ">
</body>
</html>