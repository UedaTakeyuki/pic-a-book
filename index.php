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
$data_file_path = 'data/bibliography.csv';

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?= TITLE ?></title>
  
	  <?php require("common_script.php"); ?>

  </head>
  <body>

    <div data-role="page">
    
      <div data-role="header" data-position="fixed" data-disable-page-zoom="false">
        <a href="download.php" data-transition="fade" data-ajax="false"><i class="fa fa-download" aria-hidden="true"></i></a>
        <h1 style="font-family: 'Parisienne', cursive; text-shadow: 4px 4px 4px #aaa;"><?= TITLE ?></h1>
        <a href="add.php" data-transition="fade" data-ajax="false"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
      </div> <!-- header -->

      <div data-role="content">
<?php
        if (file_exists($data_file_path)){
          $splFileObject = new SplFileObject($data_file_path);
          $splFileObject->setFlags(SplFileObject::READ_CSV);
  //        $csv = array();

          foreach ($splFileObject as $line ){
            $csv[] = $line;
  //           array_push ($csv[], $line);
          }
          $csv = array_reverse($csv);
          foreach ($csv as $line){
            if (1 != count($line)){
              echo "<b>登録日: </b>".$line[0]."<br>";
              echo "<b>タイトル: </b>".$line[2]."<br>";
              echo "<b>価格: </b>".$line[5]."<br>";
              echo "<b>メモ: </b>".$line[6]."<br><hr>";
            }
          }
        }
?>
      </div> <!-- content -->

      <div data-role="footer" data-position="fixed" data-disable-page-zoom="false">
        <h4>© Atelier UEDA <img src="favicon.ico"></h4>
      </div>
    </div> <!-- page -->
  </body>
</html>
