
<?php

$pdo = new PDO("mysql:dbname=search_me;host=localhost", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


/*

DB: search_engine -> table: sites -> column urls

page 1: 0 -> 20
page 2: 20 -> 40
page 3: 40 -> 60

0 20 40 60

$fromLimit = ($page_number - 1) * 20



*/

$page_number = isset($_GET['page']) ? $_GET['page'] : 1;

$fromLimit = ($page_number - 1) * 20;

$sql = "SELECT * FROM sites LIMIT :fromLimt, 20";
$query = $pdo->prepare($sql);
$query->bindParam(":fromLimt",$fromLimit,PDO::PARAM_INT);
$query->execute();


while( $row = $query->fetch() ) {
    echo  $row['id'] . $row['url'] . "<br>";
}

$sql = "SELECT * FROM sites";
$query = $pdo->prepare($sql);
$query->execute();

$num_of_results = (int)$query->rowCount();
$num_of_pages = ceil($num_of_results / 20);

$pages_to_show = 10;
$start_page = $page_number - ($pages_to_show/2);

$min_page = $page_number - ($pages_to_show/2);
$max_page = $page_number + ($pages_to_show/2);

if ($min_page < 1) {
    $min_page = 1;

}

for($i = $min_page; $i <= $max_page; $i++ ){

    if($page_number == $i){
        echo "<a class='page_number_active' href='pagination.php?page=$i'> $i </a> ";
    } else {
        echo "<a class='page_number' href='pagination.php?page=$i'> $i </a> ";
    }


}
?>
<style>
    .page_number {
        text-decoration: none;
        color: gray;
    }

    .page_number_active{
        color: black;
    }
</style>
