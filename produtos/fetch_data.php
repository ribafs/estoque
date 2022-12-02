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
    $results = $pdo->prepare("SELECT id,descricao,estoque_maximo,estoque_minimo FROM produtos ORDER BY id LIMIT $start, $row_limit");
}elseif($sgbd == 'pgsql'){
    $results = $pdo->prepare("SELECT id,descricao,estoque_maximo,estoque_minimo FROM produtos ORDER BY id LIMIT $row_limit OFFSET $start");    
}

$results->execute();

while($row = $results->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>" . 
    "<td>" . $row['id'] . "</td>" . 
    "<td>" . $row['descricao'] . "</td>" . 
    "<td>" . $row['estoque_minimo'] . "</td>" .
    "<td>" . $row['estoque_maximo'] . "</td>";
		?>
	    <td><a href="update.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-edit" title="Editar"></a></td>
	    <td><a onclick="return confirm('Tem certeza de que deseja excluir este cliente ?')" href="delete.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-remove-circle" title="Excluir"></i></a></td>
<?php
print "
    </tr>";
}

