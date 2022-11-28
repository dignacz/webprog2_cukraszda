<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="utf-8">
  <title>CUKRÁSZDA</title>
  </head>

  <?php 
  $client = new SoapClient('http://localhost/webprog2_cukraszda/soap/szerver/cukraszda.wsdl');
  $tipusok = $client->gettipus();
  if(isset($_POST['tipus']) && trim($_POST['tipus']) != "")
    $arak = $client->getar($_POST['tipus']);
  ?>
    
  <body>
    <h1>Cukrászda</h1>
    <form name="tipusselect" method="POST">
      <select name="tipus" onchange="javascript:tipusselect.submit();">
        <option value="">Válasszon ...</option>
        <?php
          foreach($tipusok->tipusok as $tipus)
          {
            echo '<option value="'.$tipus['tipus'].'">'.$tipus['nev'].'</option>';
          }
        ?>
      </select>
        <?php
          if(isset($arak))
          {
            echo "<fieldset>";
            echo '<legend>'.$arak->nev.'('.$arak->tipus.') ára:</legend>';
            foreach($arak->arak as $ar)
            {
              echo $ar['ertek'].' - '.$ar['egyseg']."<br>";
            }
            echo "</fieldset>";
          }
        ?>
    </form>
  </body>                                                          
</html>
