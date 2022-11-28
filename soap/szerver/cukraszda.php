<?php
class Cukraszda {
  
  /**
    *  @return tipusok
    */
  public function gettipus(){
  
	$eredmeny = array("hibakod" => 0,
					  "uzenet" => "",
					  "tipusok" => Array());
	
	try {
	  $dbh = new PDO('mysql:host=localhost;dbname=webprog2_cukraszda','root', '',
					array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	  $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
  
	  $sql = "select tipus, nev from suti order by tipus";
	  $sth = $dbh->prepare($sql);
	  $sth->execute(array());
	  $eredmeny['tipusok'] = $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
	  $eredmeny["hibakod"] = 1;
	  $eredmeny["uzenet"] = $e->getMessage();
	}
	
	return $eredmeny;
  }

  /**
    *  @param string $tipus
    *  @return Arak
    */
  function getar($tipus){
  
	$eredmeny = array("hibakod" => 0,
					  "uzenet" => "",
					  "tipus" => "",
					  "nev" => "",
					  "arak" => Array());
	
	try {
	  $dbh = new PDO('mysql:host=localhost;dbname=webprog2_cukraszda','root', '',
					array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	  $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
  
	  $eredmeny["tipus"] = $tipus;
  
	  $sql = "select id, nev from suti where tipus = :tipus";
	  $sth = $dbh->prepare($sql);
	  $sth->execute(array(":tipus" => $tipus));
	  $tipus = $sth->fetch(PDO::FETCH_ASSOC);
	  $id = $tipus["id"];
	  $eredmeny["nev"] = $tipus["nev"];
  
	  $sql = "select ertek, egyseg from ar where sutiid=:id order by ertek";
	  $sth = $dbh->prepare($sql);
	  $sth->execute(array(":id" => $id));
	  $eredmeny['arak'] = $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
	  $eredmeny["hibakod"] = 1;
	  $eredmeny["uzenet"] = $e->getMessage();
	}
	
	return $eredmeny;
  }
}


class Tipus {
  /**
   * @var string
   */
  public $tipus;

  /**
   * @var string
   */
  public $nev;  
}

class Tipusok {
  /**
   * @var integer
   */
  public $hibakod;

  /**
   * @var string
   */
  public $uzenet;  

  /**
   * @var Tipus[]
   */
  public $tipusok;  
}

class ar {
  /**
   * @var string
   */
  public $arkod;

  /**
   * @var string
   */
  public $nev;  
}

class Arak {
  /**
   * @var integer
   */
  public $hibakod;

  /**
   * @var string
   */
  public $uzenet;  

  /**
   * @var string
   */
  public $tipus;

  /**
   * @var string
   */
  public $nev;  

  /**
   * @var Ar[]
   */
  public $arak;  
}
?>