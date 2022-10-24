<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
@foreach ($plates as $plate)
   {{ $plate->reference }}
@endforeach
</body>

</html>    