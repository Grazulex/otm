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
@foreach ($items as $item)
   <table>
      <tr>
         <td width="50%">
            <img src="{{ storage_path('layout/otm.jpeg')}}" width="100%" />
         </td>
         <td width="50%" style="text-align: right;">
            <h1>
               Shipping list
            </h1>
         </td>
      </tr>
   </table>
   <br/><br/>
   <table width="100%">
      <tr width="100%">
         <td width="75%">
            <table>
               <tr>
                  <td width="10%">
                     <b>Client :</b>
                  </td>
                  <td width="90%">
                     @if (isset($item['datas']['destination_company'])) {{ $item['datas']['destination_company'] }}</br>@endif  
                     @if (isset($item['datas']['destination_name'])){{ $item['datas']['destination_name'] }}</br>@endif 
                     @if (isset($item['datas']['destination_street'])){{ $item['datas']['destination_street'] }}@endif @if (isset($item['datas']['destination_house_number'])){{ $item['datas']['destination_house_number'] }}</br>@endif 
                     @if (isset($item['datas']['destination_postal_code'])){{ $item['datas']['destination_postal_code'] }}@endif  @if (isset($item['datas']['destination_city'])){{ $item['datas']['destination_city'] }}@endif 
                  </td>
            </table>
         </td>
         <td width="15%">
            Quality check :
         </td>
         <td width="10%" style="border: 1px solid black;">
            &nbsp;
         </td>
      </tr>
      <tr>
         <td colspan="3">
            <b>Date :</b> 
         </td>
      </tr>
      <tr>
         <td colspan="3">
            <table width="100%">
               <tr width="100%">
                  <td width="50%" style="border: 1px solid black;font-size:20px;text-transform: uppercase;font-weight: bold;text-align: center;">
                     Operator : 867
                  </td>
                  <td width="50%" style="border: 1px solid black;font-size:20px;text-transform: uppercase;font-weight: bold;text-align: center;">
                     Number of plates : {{count($item['items'])}}
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
   <br/><br/>
   <table width="100%" style="border: 1px solid black; border-collapse: collapse;"> 
      <tr width="100%">
         <th width="10%" style="border: 1px solid black;">
            check
         </th>
         <th width="10%" style="border: 1px solid black;">
            Item
         </th>
         <th width="15%" style="border: 1px solid black;">
            Platenumber
         </th>
         <th width="65%" style="border: 1px solid black;">
            Remark
         </th>
      </tr>
      @foreach ($item['items'] as $plate)
      <tr style="border: 1px solid black;">
         <td style="border: 1px solid black;">
         </td>
         <td style="border: 1px solid black;text-align: center;">
            {{  strtoupper($plate['type']) }}
         </td>
         <td style="border: 1px solid black;text-align: center;">
            {{  strtoupper($plate['ref']) }}
         </td>
         <td style="border: 1px solid black;">
         </td>                           
      </tr>
      @endforeach
   </table>
      <p class="font-size: 10px;">
      Bedankt, U heeft gekozen voor een hoogwaardige nummerplaat. Alleen de OTM-nummerplaten worden geverfd (grond- en afwerkingslaag) en vernist waardoor ze kleurvast zijn en bestand zijn tegen chemische invloeden en reinigingsmiddelen.</br>
      Niet voor niets produceren we ook als enige leverancier de officiële nummerplaat voor de DIV en dat al meer dan 35 jaar!</br>
      Bij OTM kan u ook terecht voor (gepersonaliseerde) nummerplaathouders!
      </p>
      <p class="font-size: 10px;">
      Merci, vous avez choisi pour la meilleure plaque de Belgique! Seules les plaques d’OTM sont peintes (couche de fond et finition) et vernies. Les couleurs sont donc permanentes et résistantes aux agents chimiques contenus dans les produits de nettoyage.</br>
      C’est aussi pour cette raison que nous sommes le seul producteur des plaques d’immatriculation officielles pour la DIV.</br>
      Portes-plaques personnalisées? Contactez-nous.
      </p>
      <p class="font-size: 10px;">
      OTM-shop klantendienst (info@otm-shop.be)</br>
      Service Clientèle OTM-shop (info@otm-shop.be)
      </p>
      @if (!$loop->last)
      <div class="page-break"></div>
   @endif
@endforeach
</body>

</html>    