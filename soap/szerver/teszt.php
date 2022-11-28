<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="utf-8">
  <title>Cukraszda</title>
  </head>

  <?php
     $options = array(
   
   'keep_alive' => false,
    //'trace' =>true,
    //'connection_timeout' => 5000,
    //'cache_wsdl' => WSDL_CACHE_NONE,
   );
  $client = new SoapClient('http://localhost/webprog2_cukraszda/szerver/Cukraszda.wsdl',$options);
  
  $tipus = $client->gettipus();
  echo "<pre>";
  print_r($tipus);
  echo "</pre>";
  
 $suti = $client->getsuti('muffin');
  echo "<pre>";
  print_r($suti);
  echo "</pre>";
  
  
  
  $arak = $client->getar('tortaszelet','Eszterházy');
  echo "<pre>";
  print_r($arak);
  echo "</pre>";
  ?>
    
  <body>
  </body>
</html>