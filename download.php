<?php
/**
 * Make downloader.
 * 
 * Make downloader of .csv data file on one's folder.
 * 
 * Requires $_GET['serial_id']
 *          $_GET['name'] base name of download csv file for the account.
 * 
 * @author Dr. Takeyuki UEDA
 * @copyright Copyright© Atelier UEDA 2016 - All rights reserved.
 *
 */
// 参考：http://thr3a.hatenablog.com/entry/20131017/1381974853
#$serial_id = $_GET['serial_id'];
#$name = $_GET['name'];
#$fname = $name.'.csv'; //ファイル名
#$fpath = dirname(__FILE__)."/uploads/".$serial_id.'/'.$fname;
$fname = 'bibliography.csv'; //ファイル名
$org_fpath = "data/bibliography.csv";
$cnv_fpath = "data/a.csv";
`nkf --windows $org_fpath > $cnv_fpath`;

header('Content-Type: application/force-download');
header('Content-Length: '.filesize($cnv_fpath));
header('Content-disposition: attachment; filename="'.$fname.'"');
readfile($cnv_fpath);
?>