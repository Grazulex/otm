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
   <table>
      <tr>
         <td width="60%">
            <img src="{{ storage_path('layout/cod2.png')}}" width="100%" />
         </td>
         <td width="30%">
            <img src="{{ storage_path('layout/otm.jpeg')}}" width="100%" />
         </td>
         <td width="10%" style="text-align: right;">
            <h2>00</h2>
         </td>
      </tr>
   </table>
   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      <center><h2 style="font-size: 16px">Relevé de compte de votre plaque d’immatriculation via COD</h2></center>
   @else
      <center><h2 style="font-size: 16px">AANREKENINGSNOTA NUMMERPLAAT VIA COD</h2></center>
   @endif

   <table width="100%">
      <tr width="100%">
         <td width="50%">
            @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
               <p>
                  OTM-shop</br>
                  Rue Potaarde 42</br>
                  1082 Bruxelles</br>
                  BE0836794848</br>
                  </br></br>
                  Helpdesk Autoconnect</br>
                  Webdiv: 03/210.07.70
               </p>
            @else
               <p>
                  OTM-shop</br>
                  Potaardestraat 42</br>
                  1082 Brussel</br>
                  BE0836794848</br>
                  </br></br>
                  Helpdesk Autoconnect</br>
                  Webdiv: 03/210.07.70
               </p>
            @endif
         </td>
         <td width="50%">
            <p>
               @if (isset($plate->datas['owner_fullName']))
                  {{ $plate->datas['owner_fullName'] }}</br>
               @endif
               @if (isset($plate->datas['owner_street']) && isset($plate->datas['owner_house_number']))
                  {{ $plate->datas['owner_street'] }} {{ $plate->datas['owner_house_number'] }}</br>
               @endif
               </br>
               @if (isset($plate->datas['owner_postal_code']) && isset($plate->datas['owner_city']))
                  {{ $plate->datas['owner_postal_code'] }} {{ $plate->datas['owner_city'] }}</br>
               @endif
            </p>
         </td>
      </tr>
   </table>

   <p style="font-style:bold; font-size: 14px; border: solid;text-align: center;">
      @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
         Conservez ce document avec les papiers du véhicule. Le verso contient un   certificat qui peut être utile lors d’une visite au controle technique.
      @else
         BEWAAR DIT DOCUMENT BIJ DE AUTOPAPIEREN VAN UW VOERTUIG, DE ACHTERZIJDE BEVAT EEN CERTIFICAAT DAT U KAN OVERHANDIGEN TIJDENS EEN TECHNISCHE CONTROLE VAN HET VOERTUIG.
      @endif
   </p>
  <p>
   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      Madame, Monsieur,<br/><br/>
      Cet envoi contient votre plaque d’immatriculation qui a été commandée via votre courtier d’assurance.
      Félicitations: vous avez opté pour une plaque avant d’une qualité identique à la plaque officielle. Les 2 plaques sont produites par OTM.
   @else
      Geachte mevrouw, geachte heer,<br/><br/>
      Wij sturen u, in opvolging van uw aanvraag, uw voorste kentekenplaat. U heeft terecht gekozen voor de kentekenplaat van identieke kwaliteit zoals de officiële kentekenplaat met 5 jaar garantie ! Zowel de officiële kentekentplaat als deze voorste kentekenplaat worden door OTM geproduceerd.
   @endif
  </p> 
  <p style="font-size: 10px; border: solid;text-align: center;">
   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      <font color="red">Avis aux garages:</font><br/><br/>
      A la demande explicite de votre client, la plaque d’immatriculation commandée par le courtier d’assurance, est livrée chez vous.<br/><br/>
      Votre client vous a donc demandé de payer (en espèces) la plaque au facteur.
      Pouvons-nous vous demander de bien vouloir avancer cette somme (tout comme pour la plaque d’immatriculation officielle).<br/>
      Si la plaque d’immatriculation est refusée, nous nous verrons dans l’obligation de facturer des frais administratifs au client.
   @else
      <font color="red">Bericht aan de garage die instaat voor de eventuele aflevering van de wagen :</font><br/><br/>
      U ontvangt deze kentekenplaat op expliciete vraag van uw klant. Via de verzekeringsmakelaar werd deze besteld.<br/><br/>
      Uw klant heeft verzocht om deze kentekenplaat cash te betalen aan de postbode. Mogen wij u vriendelijk vragen om dit bedrag voor te schieten (net zoals voor de retributie van @if (isset($plate->datas['price'])) {{ $plate->datas['price'] }} @endif € voor de officiële kentekenplaat).<br/>
      Indien de kentekenplaat geweigerd wordt, zijn er administratieve kosten die zullen doorgerekend worden aan de klant.
   @endif
  </p> 
   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      <h4>Informations sur le véhicule:</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Numéro de chassis:</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['vin'])) {{ $plate->datas['vin'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Marque:</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['make_type'])) {{ $plate->datas['make_type'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Plaque d’immatriculation:</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['plate_number'])) {{ $plate->datas['plate_number'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Date d'inscription:</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['registration_date'])) {{ $plate->datas['registration_date'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
      </table>

      <h4>Informations sur le propriétaire:</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Propriétaire :</td>
            <td width="60%" style="border: 1px solid black;">               
               @if (isset($plate->datas['owner_fullName']))
                  {{ $plate->datas['owner_fullName'] }}
               @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['owner_street']) && isset($plate->datas['owner_house_number']))
                  {{ $plate->datas['owner_street'] }} {{ $plate->datas['owner_house_number'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['owner_postal_code']) && isset($plate->datas['owner_city']))
                  {{ $plate->datas['owner_postal_code'] }} {{ $plate->datas['owner_city'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
      </table> 

      <h4>Informations sur le courtier d'assurance:</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Courtier d'assurance:</td>
            <td width="60%" style="border: 1px solid black;">               
               @if (isset($plate->datas['broker_name']))
                  {{ $plate->datas['broker_name'] }}
               @endif</td>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_phone']))
                  {{ $plate->datas['broker_phone'] }}
               @endif</td>
            </td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_address']))
                  {{ $plate->datas['broker_address'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_postal_code']) && isset($plate->datas['broker_city']))
                  {{ $plate->datas['broker_postal_code'] }} {{ $plate->datas['broker_city'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Compagnie d’assurance:</td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['insurance_company']))
                  {{ $plate->datas['insurance_company'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>         
      </table>   

      <h4>Informations concernant le relevé :</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Code d’article :</td>
            <td width="60%" style="border: 1px solid black;">Description :</td>
            <td width="40%" style="border: 1px solid black;">Quantité :</td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['plate_type']))
                  {{ $plate->datas['plate_type'] }}
               @endif            
            </td>
            <td width="60%" style="border: 1px solid black;">Plaque d’immatriculation avant</td>
            <td width="40%" style="border: 1px solid black;">1         
            </td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">&nbsp;</td>
            <td width="60%" style="border: 1px solid black;">&nbsp;</td>
            <td width="40%" style="border: 1px solid black;">&nbsp;</td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Total :</td>
            <td width="60%" style="border: 1px solid black;"></td>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['price']))
                  {{ $plate->datas['price'] }}€
               @endif               
            </td>
         </tr>
      </table>                  
   @else
      <h4>Gegevens mbt het voertuig :</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Chassissnummer :</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['vin'])) {{ $plate->datas['vin'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Merk :</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['make_type'])) {{ $plate->datas['make_type'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Nummerplaatcombinatie :</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['plate_number'])) {{ $plate->datas['plate_number'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Inschrijvingsdatum :</td>
            <td width="60%" style="border: 1px solid black;">@if (isset($plate->datas['registration_date'])) {{ $plate->datas['registration_date'] }} @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>                           
      </table>

      <h4>Gegevens mbt de aanvrager:</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Aanvrager :</td>
            <td width="60%" style="border: 1px solid black;">               
               @if (isset($plate->datas['owner_fullName']))
                  {{ $plate->datas['owner_fullName'] }}
               @endif</td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['owner_street']) && isset($plate->datas['owner_house_number']))
                  {{ $plate->datas['owner_street'] }} {{ $plate->datas['owner_house_number'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['owner_postal_code']) && isset($plate->datas['owner_city']))
                  {{ $plate->datas['owner_postal_code'] }} {{ $plate->datas['owner_city'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
      </table>


      <h4>Gegevens mbt de Verzekeringsmakelaar :</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Aanvrager :</td>
            <td width="60%" style="border: 1px solid black;">               
               @if (isset($plate->datas['broker_name']))
                  {{ $plate->datas['broker_name'] }}
               @endif</td>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_phone']))
                  {{ $plate->datas['broker_phone'] }}
               @endif</td>
            </td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_address']))
                  {{ $plate->datas['broker_address'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;"></td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['broker_postal_code']) && isset($plate->datas['broker_city']))
                  {{ $plate->datas['broker_postal_code'] }} {{ $plate->datas['broker_city'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Verzekeringsmaatschappij :</td>
            <td width="60%" style="border: 1px solid black;">
               @if (isset($plate->datas['insurance_company']))
                  {{ $plate->datas['insurance_company'] }}
               @endif
            </td>
            <td width="40%" style="border: 1px solid black;"></td>
         </tr>         
      </table>    

      
      <h4>Aanrekeningsdetails :</h4>
      <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
         <tr>
            <td width="40%" style="border: 1px solid black;">Artikelcode :</td>
            <td width="60%" style="border: 1px solid black;">Beschrijving :</td>
            <td width="40%" style="border: 1px solid black;">Hoeveelheid :</td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['plate_type']))
                  {{ $plate->datas['plate_type'] }}
               @endif            
            </td>
            <td width="60%" style="border: 1px solid black;">Duplicaatnummerplaat</td>
            <td width="40%" style="border: 1px solid black;">1         
            </td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">&nbsp;</td>
            <td width="60%" style="border: 1px solid black;">&nbsp;</td>
            <td width="40%" style="border: 1px solid black;">&nbsp;</td>
         </tr>
         <tr>
            <td width="40%" style="border: 1px solid black;">Totaal :</td>
            <td width="60%" style="border: 1px solid black;"></td>
            <td width="40%" style="border: 1px solid black;">
               @if (isset($plate->datas['price']))
                  {{ $plate->datas['price'] }}€
               @endif               
            </td>
         </tr>
      </table>          
   @endif 

   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      <p style="text-align:right;">
         @if (isset($plate->datas['price']))
            <strong>{{ $plate->datas['price'] }}€ a été payé au facteur.</strong>
         @endif 
      </p>
   @else
      <p style="text-align:right;">
         @if (isset($plate->datas['price']))
            <strong>{{ $plate->datas['price'] }}€ werd betaald aan de postbode door de ontvanger.</strong>
         @endif 
      </p>
   @endif 
   <div class="page-break"></div>
   <table>
      <tr>
         <td width="60%">
            <img src="{{ storage_path('layout/cod2.png')}}" width="100%" />
         </td>
         <td width="30%">
            <img src="{{ storage_path('layout/otm.jpeg')}}" width="100%" />
         </td>
         <td width="10%" style="text-align: right;">
            <h2>00</h2>
         </td>
      </tr>
   </table>

   @if (isset($plate->datas['plate_number']))
      @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
         <center><h2 style="font-size: 18px">OTM confirme que la plaque d'immatriculation {{ $plate->datas['plate_number'] }} a été produite conformément à la législation.</h2></center>
      @else
         <center><h2 style="font-size: 18px">OTM bevestigt dat de nummerplaat {{ $plate->datas['plate_number'] }} conform de wetgeving is geproduceerd.</h2></center>
      @endif
      <hr>
   @endif
   @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
      <center><h2 style="font-size: 18px">Message aux centres d'inspection GOCA: le numéro de certification "286375-OTM» est situé dans le coin supérieur gauche de la plaqueD</h2></center>
   @else
      <center><h2 style="font-size: 18px">Bericht aan de GOCA-keuringsstations : het certificatienummer « 286375-OTM » bevindt zich in de linkerhovenhoek van de plaat</h2></center>
   @endif

   <br/><br/>
   <p style="text-align:center;">
      @if (isset($plate->datas['owner_language']) && $plate->datas['owner_language'] == 'FR')
         <img src="{{ storage_path('layout/codfr.png')}}" width="450px" />
      @else
         <img src="{{ storage_path('layout/codnl.png')}}" width="450px" />
      @endif
   </p>


   @if (!$loop->last)
      <div class="page-break"></div>
   @endif
@endforeach
</body>

</html>    