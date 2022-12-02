<?php require_once '../header.php'; ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <h3>Produtos</h3>
        <table class="table table-bordered table-responsive">    
            <form method="post" action="add.php"> 
            <tr><td><b>Descrição</td><td><input type="text" name="descricao"></td></tr>
            <tr><td><b>Estoque mínimo</td><td><input type="text" name="estoque_minimo"></td></tr>
            <tr><td><b>Estoque máximo</td><td><input type="text" name="estoque_maximo"></td></tr>
            <tr><td></td><td><input class="btn btn-primary" name="enviar" type="submit" value="Cadastrar">&nbsp;&nbsp;&nbsp;
            <input class="btn btn-warning" name="enviar" type="button" onclick="location='index.php'" value="Voltar"></td></tr>
            </form>
        </table>
        </div>
    </div>
</div>

<?php

if(isset($_POST['enviar'])){
    $descricao = $_POST['descricao'];
    $estoque_minimo = $_POST['estoque_minimo'];
    $estoque_maximo = $_POST['estoque_maximo'];

    require_once('../connect.php');
    try{
       $sql = "INSERT INTO produtos(descricao,estoque_minimo,estoque_maximo) VALUES (?, ?, ?)";
       $stm = $pdo->prepare($sql)->execute([$descricao, $estoque_minimo, $estoque_maximo]);;
 
       if($stm){
           echo 'Dados inseridos com sucesso';
		   header('location: index.php');
       }
       else{
           echo 'Erro ao inserir os dados';
       }
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
}
require_once('../footer.php');
?>

