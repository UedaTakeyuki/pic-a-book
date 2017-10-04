<?php
/**
 * Pic a book information from ISBN and JAN code for purchase later.
 * 
 * @author Dr. Takeyuki UEDA
 * @copyright Copyright© Atelier UEDA 2017 - All rights reserved.
 *
 */

date_default_timezone_set("Asia/Tokyo");
session_start();
require_once("ndlsearch.php");

if($_SERVER["REQUEST_METHOD"] == "GET"){
  if (isset($_GET['command'])&&isset($_GET['barcord'])&&($_GET['command']=="addISBN")){
    // read bibliographicals from NDL and put it on the FORM.
    $ndl = new NDLsearch($_GET['barcord']);
    $_SESSION["title"] = (string)$ndl->title();
    $_SESSION["creator"] = (string)$ndl->creator();
    $_SESSION["publisher"] = (string)$ndl->publisher();
  }
  if (isset($_GET['command'])&&isset($_GET['barcord'])&&($_GET['command']=="addJAN")){
    // read the price and put it on the FORM.
    $_SESSION["price"] = substr($_GET['barcord'],7,5);
  }
}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
  $date = new DateTime();

  $list = array(
    $date->format('Y-m-d H:i:s'),$_SESSION["title"], $_SESSION["creator"], $_SESSION["publisher"], $_SESSION["price"]
  );
  $fp = fopen('data/bibliography.txt','w');
  rewind ($fp);
  fputcsv($fp,$list);
  fclose($fp);
  unset($_SESSION["title"]);
  unset($_SESSION["creator"]);
  unset($_SESSION["publisher"]);
  unset($_SESSION["price"]);
}else{

}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>pic a book</title>
  
	  <!-- JQM 1.3 start -->
  	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
  	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  	<script src="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
  	<!--  JQM 1.3 end -->

		<SCRIPT LANGUAGE="JavaScript">
    /*
      function addBarCord() {
        // launch pic2shop and tell it to open Google Products with scan result
	      window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/index.php%3Fcommand%3Dadd%26barcord%3DEAN";
      }
      function addQRCord() {
        // launch pic2shop and tell it to open Google Products with scan result
	      window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/index.php%3Fcommand%3Dadd%26barcord%3DQR";
      }
    */
      function readISBNCord() {
        // launch pic2shop and tell it to open Google Products with scan result
        window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/index.php%3Fcommand%3DaddISBN%26barcord%3DEAN";
      }
      function readJANCord() {
        // launch pic2shop and tell it to open Google Products with scan result
        window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/index.php%3Fcommand%3DaddJAN%26barcord%3DEAN";
      }
    </SCRIPT>
  </head>
  <body>
<!--  	<?php if (isset($_GET['command'])&&($_GET['command'] == "add")): ?>
  		<?php if (isset($_GET['barcord'])): ?>
  			<?= $_GET['barcord'] ?>
			<?php endif; ?>
		<?php endif; ?> -->
    <FORM>
      <INPUT TYPE=BUTTON OnClick="readISBNCord();" VALUE="ISBNコードのスキャン">
    </FORM>
    <FORM>
      <INPUT TYPE=BUTTON OnClick="readJANCord();" VALUE="JANコードのスキャン">
    </FORM>
    <form action="<?= $_SERVER['SCRIPT_NAME']; ?>" method="post" data-ajax="false">
      <input type="text" name="titel" id="title" value="<?= isset($_SESSION["title"])?$_SESSION["title"]:"" ?>" />
      <input type="text" name="creator" id="creator" value="<?= isset($_SESSION["creator"])?$_SESSION["creator"]:"" ?>" />
      <input type="text" name="publisher" id="publisher" value="<?= isset($_SESSION["publisher"])?$_SESSION["publisher"]:"" ?>" />
      <input type="text" name="price" id="price" value="<?= isset($_SESSION["price"])?$_SESSION["price"]:"" ?>" />
      <input type="submit" value="登録" />
    </form>
<!--		<FORM>
      <INPUT TYPE=BUTTON OnClick="addBarCord();" VALUE="Scan Barcode">
    </FORM>
		<FORM>
      <INPUT TYPE=BUTTON OnClick="addQRCord();" VALUE="Scan QRcode">
    </FORM> -->
  </body>
</html>
