<div class="container">
<div class="row">
  
    <h2><strong>Hírek</strong></h2>
    <hr>
    <?php if (isset($_SESSION['username'])) : ?>
    <?php
    //Új hír felvitele
    if (isset($_POST['ujhir'])) { 
        $cim = $_POST['cim'];
        $szoveg = $_POST['szoveg'];
        $datum = date("Y-m-d H:i:s");
        $username = $_SESSION['username'];
        $myConnection= mysqli_connect('localhost', 'root', '', 'webprog2_cukraszda') or die ("could not connect to mysql");
        mysqli_set_charset($myConnection,'utf8');

        $query_upload = mysqli_query($myConnection, "INSERT INTO `hirek` VALUES(NULL, '$cim', '$szoveg', '$datum', '$username')") or die(mysqli_error($myConnection));
       
    }

    //Új komment felvitele
    if (isset($_POST['komment'])) { 
        $username = $_SESSION['username'];
        $komment = $_POST['comment'];
        $comm_datum = date("Y-m-d H:i:s");
        $hirid = $_POST['id_hirek'];
        
        $myConnection= mysqli_connect('localhost', 'root', '', 'webprog2_cukraszda') or die ("could not connect to mysql");
        mysqli_set_charset($myConnection,'utf8');

        $query_upload = mysqli_query($myConnection, "INSERT INTO `comment` VALUES(NULL, '$username', '$comm_datum', '$komment', '$hirid')") or die(mysqli_error($myConnection));
       
    }
?>

<?php
    //Hírek listázása
    $connection = mysqli_connect('localhost', 'root', '', 'webprog2_cukraszda');
if(!$connection){
  die("Error: Failed to connect to database!");
}
    $query = mysqli_query($connection, "SELECT * FROM `hirek` ORDER BY `datum` DESC") or die(mysqli_error($connection));
    mysqli_set_charset($connection,'utf8');
    
    
    while ($row = mysqli_fetch_object($query)) {
        $_SESSION['hir_id'] = $row->id;
        echo "<h3>$row->cim</h3>";
        echo "<p>Írta: $row->username - $row->datum</p>";
        echo "<p>$row->szoveg</p>";
        ?>
        <div class="comment_div">
                    <?php
                    if ($_SESSION['hir_id']) {
                        $hir_id = $_SESSION['hir_id'];
                        $query2 = mysqli_query($connection, "SELECT * FROM `comment` ORDER BY `com_date` DESC") or die(mysqli_error($connection));
                        while ($row2 = mysqli_fetch_object($query2)) {
                            if ($row2->melyik_hir == $hir_id) {
                                echo "<p>$row2->username - $row2->com_date</p>";
                                echo "<p>$row2->comment</p>";
                            }
                        }
                    } ?>
                </div>
                <form action="" method="post">

                <td><input id="id_hirek" name="id_hirek" type="hidden" value=<?php echo $row->id; ?>>
                        <input id="tartalom" name="comment" class="comment" type="text" placeholder="Hozzászólás...">
                            <input type="submit" name="komment" class="btn_comment" value="Beküld">
                    </label></td>
            </form>
       <?php echo "<hr>";
        
    }
 ?>

<hr>
<div id="ujhirfelvitel" class="form-row">
<h3>Új hír felvitele</h3>
    <form method="post" action="index.php?page=hiroldal">
        <label>Cim:</label>
        <input class="form-control" type ="text" name="cim"><br>
        <label>Szöveg:</label><br>
        <textarea class="form-control" rows="3" name="szoveg"></textarea>
        <br>
        <input type="submit" name="ujhir" value="Beküld">
    </form>
</div>
<?php else : ?>
                <h4>Híreket és véleményeket csak regisztrált felhasználók érhetik el!</h4>
            <?php endif; ?>
    </div>
</div>