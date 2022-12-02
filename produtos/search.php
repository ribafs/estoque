<?php 
require_once('../connect.php');

// Busca
if(isset($_GET['keyword'])){
    $keyword=$_GET['keyword'];

    $sql = "select * from produtos WHERE descricao LIKE :keyword order by id";
    $sth = $pdo->prepare($sql);
    $sth->bindValue(":keyword", $keyword."%");
    $sth->execute();
	//$nr = $sth->rowCount();
    $rows =$sth->fetchAll(PDO::FETCH_ASSOC);
}

require_once('../header.php');
?>

<div class="text-center"><h4><b>Registro(s) encontrado(s)</b>: <?=count($rows)?> com <?=$keyword?></h4></div>
<div class="text-center"><input name="send" class="btn btn-warning" type="button" onclick="location='index.php'" value="Voltar"></div>

<?php
if(count($rows) > 0){
?>

    <table class="table table-hover">
        <thead>  
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Estoque mínimo</th>
                <th>Estoque máximo</th>
            </tr>
        </thead>

<?php
    // Loop através dos registros recebidos
    foreach ($rows as $row){
        echo "<tr>" . 
        "<td>" . $row['id'] . "</td>" . 
        "<td>" . $row['descricao'] . "</td>" . 
        "<td>" . $row['estoque_minimo'] . "</td>" .
        "<td>" . $row['estoque_maximo'] . "</td>" .
        "</tr>";
    } 
    echo "</table>";

}else{
    print '<h3>Nenhum Registro encontrado!</h3>
</div>';
}
?>

<div class="text-center"><input name="send" class="btn btn-warning" type="button" onclick="location='index.php'" value="Voltar"></div>
</div>
<br>
<?php require_once('../footer.php'); ?>
