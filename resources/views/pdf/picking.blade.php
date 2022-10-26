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

        table {
         font-size: 16px;
        }
    </style>
</head>

<body>
   <table>
      <tr>
         <td width="50%">
            <img src="{{ storage_path('layout/otm.jpeg')}}" width="100%" />
         </td>
         <td width="50%" style="text-align: right;">
            <h1>
               Picking Accessories
            </h1>
         </td>
      </tr>
   </table>
   <br/><br/>

   <table width="100%">
      @foreach ($resumes as $name=>$quantity)
         <tr width="100%">
            <td width="50%" style="font-size:20px;text-transform: uppercase;font-weight: bold;">
               Total {{ $name }} :
            </td>
            <td width="50%" style="text-align: right;font-size:20px;font-weight: bold;">
               {{ $quantity }}
            </td>
         </tr>
      @endforeach
   </table>

   <br/><br/>
   <table width="100%">
      <tr  width="100%">
         <th>
            Box
         </th>
         <th>
            Type
         </th>
         <th>
            Name
         </th>
         <th>
            Street
         </th>
         <th>
            Zip
         </th>
         <th>
            City
         </th>
         <th>
         Quantity
         </th>
      </tr>   
      @foreach ($items as $item)
         @foreach ($item['items'] as $accessoire )
            <tr>
               <td>
                  {{ $item['box'] }} 
               </td>
               <td>
                  {{ $accessoire->type}}
               </td>
               <td>
                  {{ $accessoire->datas['destination_name'] }}
               </td>
               <td>
                  {{ $accessoire->datas['destination_street'] }}
               </td>
               <td>
                  {{ $accessoire->datas['destination_postal_code'] }}
               </td>
               <td>
                  {{ $accessoire->datas['destination_city'] }}
               </td>
               <td>
               1
               </td>
            </tr>
         @endforeach
      @endforeach
   </table>
</body>

</html>    