<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Parametrik Kurum Adı</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.2/katex.min.css" integrity="sha512-el2z+rjIj40JeIlKyqcoRjGNjvwHVlyahNQ1PhSs4PCztr6jJ4GgpjgN+1a++L9HZxhLXpa4eLG3ry976z0O2Q==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div id="app"></div>
<script defer src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script defer type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.2/katex.min.js" integrity="sha512-O7WTu9pghLBfbQSGAf2xOFoRxDrHKS3kjRuuiCWttAf76q6h8Qj+KYPBF5EdZsE24LvXiFUshVNWaAxBOij8VA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.13.2/contrib/mhchem.min.js" integrity="sha512-oGRFOTIYLFCM52dbNUeknDsKpeFmjrqvHTHR7mSDF9koxr+9nA4xAZ/qd1RlySCU/BS5HvHQMty0VAikZtfMqg==" crossorigin="anonymous"></script>
<script defer src="{{ asset('js/app/ckeditor/ckeditor.js') }}" type="application/javascript"></script>
<script defer src="{{ asset('js/app/manifest.js') }}" type="application/javascript"></script>
<script defer src="{{ asset('js/app/vendor.js') }}" type="application/javascript"></script>
<script defer src="{{ asset('js/app/app.js') }}" type="application/javascript"></script>
</body>
</html>
