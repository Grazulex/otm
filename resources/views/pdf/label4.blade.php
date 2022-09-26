<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style>
        .column {
            float: left;
            width: 50%;
            border: 1px solid black;
        }

        .row {
            height: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .label {
            width: 90%;
            height: 90%;
            border: 1px solid gray;
            margin: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($plates as $plate)
        @if ($loop->odd)
            <div class="row">
        @endif
        <div class="column">
            <div class="label">
                {{ $plate->reference }}
            </div>
        </div>
        @if ($loop->even)
            </div>
        @endif
    @endforeach
    </div>
</body>

</html>
