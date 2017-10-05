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
require_once("common.php");
require_once("ndlsearch.php");

if($_SERVER["REQUEST_METHOD"] == "GET"){
  if (isset($_GET['command'])&&isset($_GET['barcord'])&&($_GET['command']=="addISBN")){
    // read bibliographicals from NDL and put it on the FORM.
    $ndl = new NDLsearch($_GET['barcord']);
    $_SESSION["isbn"]       = $_GET['barcord'];
    $_SESSION["title"]      = (string)$ndl->title();
    $_SESSION["creator"]    = (string)$ndl->creator();
    $_SESSION["publisher"]  = (string)$ndl->publisher();
  }
  if (isset($_GET['command'])&&isset($_GET['barcord'])&&($_GET['command']=="addJAN")){
    // read the price and put it on the FORM.
    $_SESSION["price"] = intval(substr($_GET['barcord'],7,5))."円";
  }
}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
  $date = new DateTime();

  $list = array(
    $date->format('Y-m-d H:i:s'),$_POST["isbn"],$_POST["title"], $_POST["creator"], $_POST["publisher"], $_POST["price"], $_POST["memo"]
  );
  $fp = fopen('data/bibliography.csv','a');
  rewind ($fp);
  fputcsv($fp,$list);
  fclose($fp);
  unset($_SESSION["isbn"]);
  unset($_SESSION["title"]);
  unset($_SESSION["creator"]);
  unset($_SESSION["publisher"]);
  unset($_SESSION["price"]);
  header('Location: index.php');
}else{

}

$isSubmitEnabled = isset($_SESSION["isbn"])&&isset($_SESSION["price"]);

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?= TITLE ?></title>
  
    <?php require("common_script.php"); ?>

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
        window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/add.php%3Fcommand%3DaddISBN%26barcord%3DEAN";
      }
      function readJANCord() {
        // launch pic2shop and tell it to open Google Products with scan result
        window.location="pic2shop://scan?callback=http%3A//klingsor.uedasoft.com/tools/171002/add.php%3Fcommand%3DaddJAN%26barcord%3DEAN";
      }
    </SCRIPT>
  </head>
  <body>

    <div data-role="page">
      <div data-role="header" data-position="fixed" data-disable-page-zoom="false">
        <h1><?= TITLE ?></h1>
        <a href="" data-rel="back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
      </div> <!-- header -->

      <div data-role="content">

        <FORM>
          <INPUT TYPE=BUTTON OnClick="readISBNCord();" VALUE="ISBNコードのスキャン">
        </FORM>
        <FORM>
          <INPUT TYPE=BUTTON OnClick="readJANCord();" VALUE="JANコードのスキャン">
        </FORM>
        <form action="<?= $_SERVER['SCRIPT_NAME']; ?>" method="post" data-ajax="false">
          <input type="hidden" name="isbn"      id="isbn"       value="<?= isset($_SESSION["isbn"])?$_SESSION["isbn"]:"" ?>" />
          <input type="hidden" name="title"     id="title"      value="<?= isset($_SESSION["title"])?$_SESSION["title"]:"" ?>" />
          <input type="hidden" name="creator"   id="creator"    value="<?= isset($_SESSION["creator"])?$_SESSION["creator"]:"" ?>" />
          <input type="hidden" name="publisher" id="publisher"  value="<?= isset($_SESSION["publisher"])?$_SESSION["publisher"]:"" ?>" />
          <input type="hidden" name="price"     id="price"      value="<?= isset($_SESSION["price"])?$_SESSION["price"]:"" ?>" />
            ISBN: <?= isset($_SESSION["isbn"])?$_SESSION["isbn"]:"" ?><br>
            書名: <?= isset($_SESSION["title"])?$_SESSION["title"]:"" ?><br>
            価格: <?= isset($_SESSION["price"])?$_SESSION["price"]:"" ?><br>
          <input type="text"    <?= $isSubmitEnabled? '' : 'disabled="disabled"' ?> name="memo" id="memo" placeholder="メモ"/>
          <input type="submit"  <?= $isSubmitEnabled? '' : 'disabled="disabled"' ?> value="登録" />
        </form>
    <!--		<FORM>
          <INPUT TYPE=BUTTON OnClick="addBarCord();" VALUE="Scan Barcode">
        </FORM>
    		<FORM>
          <INPUT TYPE=BUTTON OnClick="addQRCord();" VALUE="Scan QRcode">
        </FORM> -->
      </div> <!-- content -->

      <div data-role="footer" data-position="fixed" data-disable-page-zoom="false">
        <h4>© Atelier UEDA <img src="favicon.ico"></h4>
      </div>
    </div> <!-- page -->
  </body>
</html>
