<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "includes/database.php"; 
include "includes/form-settings.php";
// require_once "includes/scrape.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Crawler</title>
  </head>
  <body>
  
      <div class="container mt-4">
        <div class="row">
          
          <!-- Search -->
          <div class="col col-6">
            <h1 class="font-weight-light mb-3">Books & Magazines</h1>
            <form method="GET" action="">
              <div class="form-row">
                <div class="col">
                  <input 
                    type="search" 
                    name="q" 
                    class="form-control" 
                    <?php if(isset($_GET['q'])): echo "value='{$_GET['q']}'"; endif; ?> 
                    placeholder="Enter a title...">
                </div>
                <div class="col">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Results -->
        <div class="row mt-4">
            <?php 
              if( isset($rows) && count($rows) > 0 ): 
                foreach($rows as $row): 
                  $row = (object) $row;
            ?>
                <div class="col col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <?php echo "<h4>{$row->title}</h4>"; ?>
                      <?php echo "<p class='badge badge-success'>{$row->price}</p>"; ?>
                    </div>
                  </div>
                </div>
            <?php 
                endforeach;
              endif;
            ?>
          </div>

          <!-- Pagination -->
          <div class="row">
            <div class="col">
                <ul class="list-inline">
                  <?php 
                    for ($page = 1; $page <= $total_pages ; $page++): 
                      $page_url = "?page={$page}";
                      if(isset($_GET['q'])):  
                        $page_url .= "&q={$_GET['q']}";
                      endif;
                  ?>
                    <li class="list-inline-item mb-2">
                      <a href='<?php echo $page_url; ?>' class="page-link <?php if($page == $is_page): ?>bg-primary text-white<?php endif; ?>">
                        <?php  echo $page; ?>
                      </a>
                    </li>
                  <?php endfor; ?>
                </ul>
            </div>
          </div>

      </div>
  </body>
</html>