<?php 

/* 
* ----------------------------------------------
* Pagination
* ----------------------------------------------
*/

$limit = 20;

// WHERE title LIKE ? LIMIT $start_from, $limit
$query = "SELECT title, price FROM books WHERE title LIKE ?";

$searchTerm = ""; 
if( isset($_GET['q']) ): 
    $searchTerm = htmlspecialchars($_GET['q']);
endif;

$s = $db->prepare($query);
$s->execute(array("%$searchTerm%"));
$total_results = $s->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $is_page = 1;
} else{
    $is_page = $_GET['page'];
}

$starting_limit = ($is_page - 1) * $limit;
$show  = "SELECT title, price FROM books WHERE title LIKE ? LIMIT $starting_limit, $limit";

$r = $db->prepare($show);
$r->execute(array("%$searchTerm%"));
$rows = $r->fetchAll(PDO::FETCH_ASSOC);

