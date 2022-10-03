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
            display: flex;
        }

        .plate {
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            color: red;
            border: 1px solid red;
            margin: 10px;
         }

        .vin {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transformation: uppercase;
        }
        .others {
            height: auto;
            display: flex-row;
            width: 100%;
        }
        .co .order {
            width: 50%;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transformation: uppercase;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($plates as $plate)
        @if ($loop->odd && $loop->first)
            <div class="row">
        @endif
        <div class="column">
            <div class="label">
                <div class="plate">
                    {{ $plate->reference }}
                </div>
                @if (isset($plate->datas['vin']))
                    <div class="vin">
                        {{ strtoupper($plate->datas['vin'])}}
                        <br/>
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($plate->datas['vin'], 'C39') }}" height="40"
                    width="380" />
                    </div>
                @endif
                <div class="others">
                    <div class="co">
                        @if (isset($plate->datas['co2']))
                            CO²: {{ $plate->datas['co2'] }} g/km
                        @endif
                    </div>
                    <div class="order">
                        @if (isset($plate->datas['order_id']))
                            {{ $plate->datas['order_id'] }}
                        @endif
                    </div>
                </div>
                <div class="company">
                    @if (isset($plate->datas['driver']))
                        {{ $plate->datas['driver'] }}
                    @endif
                </div>
            </div>
        </div>
        @if ($loop->even || $loop->last)
            </div>
        @endif
    @endforeach
</body>

</html>
