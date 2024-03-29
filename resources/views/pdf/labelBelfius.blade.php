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
<table width="1050px" cellpadding="20">
    @foreach ($plates as $plate)
        @if ($loop->first)
            <tr width="100%"> 
        @else
            @if ($loop->odd)
                <tr width="100%"> 
            @endif
        @endif
        <td height="300px" width="50%" style="vertical-align:top;">
            <div>
                <div style="text-align: center;color:red;font-size: 48px;font-style: bold;border: 2px solid red">
                    {{ $plate->reference }}
                </div>
                <br/>
                @if (isset($plate->datas['vin']))
                    <div  style="text-align: center;font-size: 24px;">
                        {{ strtoupper($plate->datas['vin'])}}
                        <br/>
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($plate->datas['vin'], 'C39') }}" height="40"
                    width="450px" />
                    </div>
                @endif
                <br/>
                <div class="co" style="font-size: 20px;">
                    @if (isset($plate->datas['co2']))
                        CO²: {{ $plate->datas['co2'] }} g/km
                    @endif
                </div>
                <div class="datas">
                    <table width="100%">
                        <tr>
                            <td width="50%" style="font-size: 20px;">
                                @if (isset($plate->datas['driver']))
                                    {{ $plate->datas['driver'] }}
                                @endif
                            </td>                            
                            <td width="50%" style="font-size: 20px;text-align: right;">
                                @if (isset($plate->datas['order_id']))
                                    {{ $plate->datas['order_id'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                @if (isset($customer->logo_file))
                                    <img src="{{ storage_path('app/public/'.$customer->logo_file)}}" width="150px" />
                                @endif
                            </td>                            
                            <td width="60%" style="font-size: 18px;text-align: right;">
                                @if (isset($customer->co2_text))
                                    {{$customer->co2_text}}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        @if ($loop->last)
            @if ($loop->odd)
                <td height="300px" width="50%" style="vertical-align:top;">
                </td
            @endif
            </tr>
        @else
            @if ($loop->even)
                </tr>
            @endif
        @endif
        @if ($loop->iteration % 4 == 0)
            </table>
            <div class="page-break"></div>
            <table width="1050px" cellpadding="20">
        @endif
    @endforeach
</table>
</body>

</html>
