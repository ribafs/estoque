<?php
include_once("../connect.php");

if (isset($_POST["page"])) {
    $page_no = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    if(!is_numeric($page_no))
        die("Error fetching data! Invalid page number!!!");
} else {
    $page_no = 1;
}

// get record starting position
$start = (($page_no-1) * $row_limit);

if($sgbd == 'mysql'){
    $results = $pdo->prepare("SELECT id,produto_id,quantidade FROM estoques ORDER BY id LIMIT $start, $row_limit");
}elseif($sgbd == 'pgsql'){
    $results = $pdo->prepare("SELECT id,produto_id,quantidade FROM estoques ORDER BY id LIMIT $row_limit OFFSET $start");    
}

$results->execute();

while($row = $results->fetch(PDO::FETCH_ASSOC)) {
    // Trazer a descrição do produto atual
    $sql = 'select descricao from produtos where id = '.$row['produto_id'];
    $stm = $pdo->query($sql);
    $produto = $stm->fetch(PDO::FETCH_OBJ);

    echo "<tr>" . 
    "<td>" . $row['id'] . "</td>" . 
    "<td>" . $produto->descricao . "</td>".
    "<td>" . $row['quantidade'] . "</td>
    </tr>";
}

