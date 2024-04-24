@include ('layouts.funcoes')

@php
$arrayTheme = theme();
$tema = $arrayTheme['tema'];
$Dark_Light = $arrayTheme['Dark_Light'];
$value = $arrayTheme['value'];
$class = $arrayTheme['class'];

echo "<script></script>";
@endphp

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="@php echo $tema @endphp">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OuviAcess @yield('title')</title>
  <link rel="icon" href="../image/MegAfone.png" type="image/x-icon">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">--}}
  <link rel="stylesheet" href="../css/style.css">

</head>

<body>
  
  @yield('body')

  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>--}}
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/script.js"></script>

</body>

</html>
