<?php
/**
 * Search bibliographic information from Japan National Diet library DataBase.
 * 
 * 
 * How to Use:
 * 
 *   $ndl = new NDLsearch($isbn_str);
 *   print "title: ".$ndl->title();
 * 
 * @author Dr. Takeyuki UEDA
 * @copyright Copyright© Atelier UEDA 2017 - All rights reserved.
 *
 */
class NDLsearch{
  private $dcNode = '';
  public function __construct($isbn){
    $this->dcNode = $this->search_node($isbn);
  }
  public function title(){
    return $this->dcNode->title;
  }
  public function creator(){
    return $this->dcNode->creator;
  }
  public function publisher(){
    return $this->dcNode->publisher;
  }
  public function subject(){
    return $this->dcNode->subject;
  }
  public function description(){
    return $this->dcNode->description;
  }
  public function language(){
    return $this->dcNode->language;
  }
  private function search_node($isbn){
    // make OpenURL for NDL search.
    // refer: http://iss.ndl.go.jp/information/api/
    $url = "http://iss.ndl.go.jp/api/sru?operation=searchRetrieve&query=isbn%3d".$isbn;
    $xml = simplexml_load_file($url);

    // bibliographical data is recorded as escaped string of DC, need parse again.
    $str = htmlspecialchars_decode($xml->records[0]->record->recordData);
    $xml1 = simplexml_load_string($str);
    // get Dublin Core node
    $dcNode = $xml1->children('http://purl.org/dc/elements/1.1/');

    return $dcNode;
  }
}
/*
$ndl = new NDLsearch('4062884399');
#var_dump($ndl);
print "title: ".$ndl->title();
print "creator: ".$ndl->creator();
print "publisher: ".$ndl->publisher();
foreach ($ndl->subject() as $string){
  print "subject: ".$string;
}
print "description: ".$ndl->description();
print "language: ".$ndl->language();
*/
