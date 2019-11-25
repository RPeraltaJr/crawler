<?php 
	
/* 
* ----------------------------------------------
* Scrape Results
* ----------------------------------------------
*/
	
require_once 'simplehtmldom_1_9_1/simple_html_dom.php';
$dom = new simple_html_dom();

$results = array();
$i = 0; // default count for array items
$startCount = 0; // default count for URL
$resultsLimit = 1000; // limit 

while($i < $resultsLimit):
    
    if($i % 120 === 0 && $i > 0): $startCount = $i; endif;
    $dom->load_file("https://newyork.craigslist.org/search/bka?s={$startCount}");
    
    if(!empty($dom)) {
        $divClass = $title = "";
        foreach($dom->find(".result-row") as $divClass) {

            // title
            foreach($divClass->find("a.result-title.hdrlnk") as $title ) {
				$results[$i]['title'] = htmlspecialchars($title->plaintext);
				
            }
            // price
            foreach($divClass->find("span.result-price") as $price ) {
                $results[$i]['price'] = htmlspecialchars($price->plaintext);
            }
      
            $i++;
        }
    }

endwhile;
$results = array_splice($results, -1000); // remove any additional items after 1000
	
/* 
* ----------------------------------------------
* Insert into Database
* ----------------------------------------------
*/

$table_name = "books";

$query = $db->prepare("TRUNCATE TABLE $table_name");
$query->execute();

$sql = "INSERT INTO $table_name (title, price) VALUES (:title, :price)";
foreach($results as $result):
	$stmt = $db->prepare($sql);
	$stmt->execute($result);
endforeach;