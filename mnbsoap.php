<div class="container">
  <div class="row">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2><?= (isset($viewData['uzenet']) ? $viewData['uzenet'] : "") ?></h2>


<form action="" method="post" id="form1">
    <label class="select" for="deviza">Válassza ki az átváltandó devizát:</label><br><br>

    <input type="date" class="mnb" name="date" id="date" value="<?php echo date("Y-m-d"); ?>" required>
    <input type="number" class="mnb" name="mennyi" id="mennyi" placeholder="Összeg" value="1" required>
    <select class="mnb" name="deviza" id="deviza">
        <option value="USD">USD - Amerikai dollár</option>
        <option value="EUR">EUR - Euro</option>
        <option value="HUF">HUF - Magyar forint</option>
        <option value="GBP">GBP - Angol font</option>
        <option value="AUD">AUD - Ausztrál dollár</option>
        <option value="BGN">BGN - Bolgár leva</option>
        <option value="CAD">CAD - Kanadai dollár</option>
        <option value="CHF">CHF - Svájci frank</option>
        <option value="CNY">CNY - Kínai juan</option>
        <option value="CZK">CZK - Cseh korona</option>
        <option value="DKK">DKK - Dán korona</option>
        <option value="JPY">JPY - Japán yen</option>
    </select>

    <select class="mnb" name="deviza2" id="deviza2">
        <option value="HUF">HUF - Magyar forint</option>
        <option value="CAD">CAD - Kanadai dollár</option>
        <option value="HUF">HUF - Magyar forint</option>
        <option value="EUR">EUR - Euro</option>
        <option value="USD">USD - Amerikai dollár</option>
        <option value="GBP">GBP - Angol font</option>
        <option value="AUD">AUD - Ausztrál dollár</option>
        <option value="BGN">BGN - Bolgár leva</option>
        <option value="CHF">CHF - Svájci frank</option>
        <option value="CNY">CNY - Kínai juan</option>
        <option value="CZK">CZK - Cseh korona</option>
        <option value="DKK">DKK - Dán korona</option>
        <option value="JPY">JPY - Japán yen</option>
    </select>



    <input class=mnb_btn type="submit" name="valtas" value="Váltás" form="form1"><br><br>




    <?php
    if(isset($_POST['valtas'])){
        if (isset($_POST["deviza"]) && ($_POST["deviza2"]) && ($_POST["date"]) && ($_POST["mennyi"])) {
            $deviza = $_POST["deviza"];
            $deviza2 = $_POST["deviza2"];
            $date = $_POST["date"];
            $mennyi = $_POST["mennyi"];
            $nenezd = "HUF";

            unset($currates);

            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
            $currrates = $client->GetExchangeRates(array('startDate' => $date, 'endDate' => $date, 'currencyNames' => "$deviza"))->GetExchangeRatesResult;

            $dom_root = new DOMDocument();
            $dom_root->loadXML($currrates);

            $searchNode = $dom_root->getElementsByTagName("Day");

            foreach ($searchNode as $searchNode) {

                $rates = $searchNode->getElementsByTagName("Rate");

                foreach ($rates as $rate) {
                    $unit_1 = "\t" . $rate->getAttribute('unit') . " ";
                    $deviza_ = $rate->getAttribute('curr');
                    $dev_rate = $rate->nodeValue;
                    $deviza_rate = str_replace(",", ".", $dev_rate);
       
                }
            }

            $currrates2 = $client->GetExchangeRates(array('startDate' => $date, 'endDate' => $date, 'currencyNames' => "$deviza2"))->GetExchangeRatesResult;

            $dom_root = new DOMDocument();
            $dom_root->loadXML($currrates2);

            $searchNode = $dom_root->getElementsByTagName("Day");

            foreach ($searchNode as $searchNode) {

                $rates = $searchNode->getElementsByTagName("Rate");

                foreach ($rates as $rate) {
                    $unit_2 = "\t" . $rate->getAttribute('unit') . " ";
                    $deviza_2 = $rate->getAttribute('curr');
                    $dev_rate2 = $rate->nodeValue;
                    $deviza_rate2 = str_replace(",", ".", $dev_rate2);
                }
            }
            if (isset($deviza_rate) or isset($deviza_rate2)) {
                if ($deviza == $nenezd and $deviza2 !== $nenezd) {   //HUH - Deviza
                    $_POST['eredmeny'] = ($mennyi / $deviza_rate2) * $unit_2;
                }
                if ($deviza !== $nenezd and $deviza2 == $nenezd) {  //Deviza - HUF
                    $_POST['eredmeny'] = ($deviza_rate * $mennyi) / $unit_1;
                }
                if ($deviza !== $nenezd and $deviza2 !== $nenezd) {   //Deviza - Deviza
                    $_POST['eredmeny'] = (($deviza_rate * $unit_1) / ($deviza_rate2 * $unit_2)) * $mennyi;
                }
                if ($deviza == $nenezd and $deviza2 == $nenezd) {   //HUF - HUF
                    $_POST['eredmeny'] = $mennyi;
                }
            }
        }
        if(isset($_POST['eredmeny'])){
            ?>
            <input class="mnb" value="<?php echo $_POST['mennyi']; ?>" readonly>
            <input class="mnb" value="<?php echo $_POST['deviza']; ?>" readonly>
            <input class="mnb" value="<?php echo number_format($_POST['eredmeny'], 2); ?>" readonly>
            <input class="mnb" value="<?php echo $_POST['deviza2']; ?>" readonly>
            <?php
        }else{
            ?>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <p class="select">Ezen a napon nem volt árfolyamváltozás!</p>
            <?php
        }
    }else{
        ?>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
        <?php
    }
    ?>

</form>

    <form action="" method="post" id="form2">
        <br><br>
        <label class="select" for="deviza">Devizapár árfolyama egy adott időintervallumban:</label><br>
        <label class="select" for="deviza">Kezdete - Vége</label><br><br>

        <input type="date" class="mnb" name="date_interval_1" id="date_interval_1" value="2022-05-07" required>
        <input type="date" class="mnb" name="date_interval_2" id="date_interval_2" value="2022-05-17" required>
        <select class="mnb" name="deviza_iv" id="deviza_iv">
            <option value="USD">USD - Amerikai dollár</option>
            <option value="EUR">EUR - Euro</option>
            <option value="GBP">GBP - Angol font</option>
            <option value="AUD">AUD - Ausztrál dollár</option>
            <option value="BGN">BGN - Bolgár leva</option>
            <option value="CAD">CAD - Kanadai dollár</option>
            <option value="CHF">CHF - Svájci frank</option>
            <option value="CNY">CNY - Kínai juan</option>
            <option value="CZK">CZK - Cseh korona</option>
            <option value="DKK">DKK - Dán korona</option>
            <option value="JPY">JPY - Japán yen</option>
        </select>

        <select class="mnb" name="deviza2_iv" id="deviza2_iv">
            <option value="EUR">EUR - Euro</option>
            <option value="JPY">JPY - Japán yen</option>
            <option value="CAD">CAD - Kanadai dollár</option>
            <option value="USD">USD - Amerikai dollár</option>
            <option value="GBP">GBP - Angol font</option>
            <option value="AUD">AUD - Ausztrál dollár</option>
            <option value="BGN">BGN - Bolgár leva</option>
            <option value="CHF">CHF - Svájci frank</option>
            <option value="CNY">CNY - Kínai juan</option>
            <option value="CZK">CZK - Cseh korona</option>
            <option value="DKK">DKK - Dán korona</option>

        </select>
        
        <input class=mnb_btn type="submit" name="valtas_interval" value="Váltás" form="form2"><br><br>
        
     </form>

    <?php if (isset($_POST['valtas_interval'])) {
            if (isset($_POST["deviza_iv"]) && ($_POST["deviza2_iv"]) && ($_POST["date_interval_1"]) && ($_POST["date_interval_2"])) {

                $date_interval_1 = $_POST["date_interval_1"];
                $date_interval_2 = $_POST["date_interval_2"];
                $deviza_iv = $_POST["deviza_iv"];
                $deviza2_iv = $_POST["deviza2_iv"];
                $devizas_int = $_POST["deviza_iv"].",".$_POST["deviza2_iv"];
                $nenezd = "HUF";

                $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
                $currrates = $client->GetExchangeRates(array('startDate' => $date_interval_1, 'endDate' => $date_interval_2, 'currencyNames' => $devizas_int))->GetExchangeRatesResult;

                $dom_root = new DOMDocument();
                $dom_root->loadXML($currrates);

                $searchNode = $dom_root->getElementsByTagName("Day");

                $dev_rule = true;
                $date_arr = array();
                $dev1_arr = array();
                $dev2_arr = array();
                $unit1_arr = array();
                $unit2_arr = array();
                $dev_rate1_arr = array();
                $dev_rate2_arr = array();
                foreach ($searchNode as $searchNode) {
                    $date = $searchNode->getAttribute('date');
                    array_push($date_arr, $date);
                    $rates = $searchNode->getElementsByTagName("Rate");

                    foreach ($rates as $rate) {
                        $unit_1_iv = "\t" . $rate->getAttribute('unit') . " ";
                        $deviza_iv_ = $rate->getAttribute('curr');
                        $dev_rate_iv = $rate->nodeValue;
                        $deviza_rate_iv = str_replace(",", ".", $dev_rate_iv);

                        if($dev_rule == true) {
                            array_push($unit1_arr, $unit_1_iv);
                            array_push($dev1_arr, $deviza_iv_);
                            array_push($dev_rate1_arr, $deviza_rate_iv);
                            $dev_rule = false;
                        }else{
                            array_push($unit2_arr, $unit_1_iv);
                            array_push($dev2_arr, $deviza_iv_);
                            array_push($dev_rate2_arr, $deviza_rate_iv);
                            $dev_rule = true;
                        }
                    }
                }
                        $_POST['date_arr'] = $date_arr;
                        $_POST['unit1_arr'] = $unit1_arr;
                        $_POST['dev1_arr'] = $dev1_arr;
                        $_POST['dev_rate1_arr'] = $dev_rate1_arr;
                        $_POST['unit2_arr'] = $unit2_arr;
                        $_POST['dev2_arr'] = $dev2_arr;
                        $_POST['dev_rate2_arr'] = $dev_rate2_arr;

                        $_POST['valtas_interval_end'] = true;
                        $_GET['valtas_interval'] = true;
                        
                        }
            }
?> 

     <div style="overflow-x:auto;">
<table>
<?php
    if(isset($_GET['valtas_interval'])){
        
        if($_POST['valtas_interval_end']  = true) 
    {?>
                    <thead>
                    <tr>
                        <th>Dátum&ensp;</th>
                        <th>Egység&ensp;</th>
                        <th>Deviza&ensp;</th>
                        <th>Árfolyam&ensp;</th>
                        <th>Egység&ensp;</th>
                        <th>Deviza&ensp;</th>
                        <th>Árfolyam&ensp;</th>
                    </tr>
                    </thead>
                     <?php
                        $y = (count($_POST['date_arr']) -1);
                        for ($x = 0; $x <= $y; $x++) {
                        ?>
                    <tbody>
                    <tr>        
                         <td><?php print_r($_POST['date_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['unit1_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['dev1_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['dev_rate1_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['unit2_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['dev2_arr'][$x]); ?>&ensp;</td>
                         <td><?php print_r($_POST['dev_rate2_arr'][$x]); ?>&ensp;</td>
                    </tr>
                    </tbody>
                        <?php
                        $labels = $_POST['date_arr'];
                        $title1 = $_POST['dev1_arr'][0];
                        $adatok1 = $_POST['dev_rate1_arr'];
                        $title2 = $_POST['dev2_arr'][0];
                        $adatok2 = $_POST['dev_rate2_arr'];
                        }
                        ?>
                
<?php
    }
}
?>
</table>
</div>
<div>
  <canvas id="myChart" width="200" height="100" style=background:white;></canvas>
</div>
<?php 

?>
<script>	//-------- diagramm --------

const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
       datasets: [{
           label: <?php echo json_encode($title1); ?>,
           data: <?php echo json_encode($adatok1); ?>,
           borderColor: 'rgb(255,28,37)',
           borderWidth: 4,
           order: 2
       }, {
           label: <?php echo json_encode($title2); ?>,
           data: <?php echo json_encode($adatok2); ?>,
           type: 'line',
           borderColor: 'rgb(0,111,255)',
           borderWidth: 4,
           order: 1
           
       }],
       
       labels: <?php echo json_encode($labels); ?>
   },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>