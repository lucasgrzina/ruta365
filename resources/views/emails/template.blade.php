<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Mailing - Microsoft Ruta365</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <style>
      html,
      body {
        height: 100%;
      }

      body {
        display: -ms-block;
        display: block;
        align-items: center;
        padding-top: 0px;
        padding-bottom: 0px;
        background-color: #fff; /*#00a1df;*/
        font-family: 'Lato', sans-serif;
        text-align: center;
      }

      .container {
        max-width: 600px;
        background-color: #00a1df;
        padding-bottom: 30px;
        margin-left: auto;
        margin-right: auto;
      }

      .container-fluid {
        margin-bottom: -3px;
      }
      
      .container-fluid p {
        margin-top: 13px;
        margin-bottom: 13px;
      }

      .correctamente {
        background-color: #fff;
      }

      .correctamente p {
        font-size: 14px !important;
        color: #000 !important;
      }

      .foto-header {
        width: 100%;
        margin-left: auto!important;
        margin-right: auto!important;
      }

      .container .h1 {
        color: #fff;
        font-size: 27px;
        font-weight: bold !important;
        padding-top: 50px;
        margin-top: 0;
      }

      .container .p {
        color: #fff;
        font-size: 15px;
        line-height: 17px;
        padding-bottom: 15px;
      }

      .container .link-001 {
        text-decoration: none;
      }

      .container .btn-002 {
        width: 230px;
        margin-top: 40px;
        margin-bottom: 40px;
        background-color: #000000;
        color:#fff;
        border-radius: 0;
        font-size: 11pt;
        margin-left: auto;
        margin-right: auto;
        padding-top: 11px;
        padding-bottom: 12px;
      }
    </style>
  </head>
  <body class="text-center">
    
    <div class="container">
      @if(!isset($respaldo))
      <div class="container-fluid correctamente">
        <p class="p font-weight-normal" style="text-align: center; margin-bottom: 0;">Si no puedes visualizar este newsletter correctamente, <a href="{{$linkRespaldo}}">haz click aquí</a>.</p>
      </div>
      @endif
      
      <div class="container-fluid">
        <img src="{{asset('img/Header-mailing.jpg')}}" class="mx-auto container-fluid foto-header" alt="Microsoft Ruta 365">
      </div>
      
      @yield('content')

      <p class="p mb-3 font-weight-normal" style="text-align: center;">Si usted no se suscribió a este sitio, por favor descarte este email.</p>
    </div>
</body>
</html>
