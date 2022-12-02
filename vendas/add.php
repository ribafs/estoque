<?php
require_once '../header.php'; 
require_once('../connect.php');

// Receber o id e a descricao de todos os produtos para para popular a combo
$sql ='SELECT id,descricao FROM produtos;';
$stmt = $pdo->prepare($sql);
$stmt ->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pegar o maior id de vendas e somar mais 1 para mostrar no campo id, que é somente leitura
$sqlv ='SELECT MAX(id) AS id FROM vendas;';
$stmtv = $pdo->prepare($sqlv);
$stmtv ->execute();
$venda_id = $stmtv->fetchAll(PDO::FETCH_ASSOC);
$venda_id = $venda_id[0]['id'] + 1;
?>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <h3>Compras</h3>
        <table class="table table-bordered table-responsive">    
            <form method="post" action="add.php"> 
            <tr><td><b>ID</td><td><input type="text" name="id" value="<?=$venda_id?>" readonly></td></tr>
            <tr><td><b>Produto</td>
            <td>
            <select name="produto_id" id="produto_id">
                <option value="" selected>Selecione</option>
                <?php foreach($data as $row) : ?>
                    <option value="<?= $row['id']; ?>"><?= $row['descricao']; ?></option>
                <?php endforeach ?>
            </select>
            </td>
            </tr>
            <tr><td><b>Quantidade</td><td><input type="text" name="quantidade"></td></tr>
            <tr><td><b>Data</td><td><input type="text" name="data"></td></tr>
            <tr><td><b>Preço</td><td><input type="text" name="preco"></td></tr>
            <tr>
                <td></td><td><input class="btn btn-primary" name="enviar" type="submit" value="Cadastrar">&nbsp;&nbsp;&nbsp;
                    <input class="btn btn-warning" name="enviar" type="button" onclick="location='index.php'" value="Voltar">
                </td>
            </tr>
            </form>
        </table>
        </div>
    </div>
</div>

<?php
if(isset($_POST['enviar'])){
    // Receber valores digitados no form
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $data = $_POST['data'];
    $preco = $_POST['preco'];

    // Pegar estoque_minimo de produtos para $produto_id
    $sql ='SELECT estoque_minimo AS minimo FROM produtos WHERE id = '.$produto_id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $min = $stmt->fetch(PDO::FETCH_ASSOC);
    $min = $min['minimo'];

    // Pegar a quantidade em estoque para $produto_id
    $sql ='SELECT sum(quantidade) AS quantidade FROM estoques WHERE id = '.$produto_id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $soma_estoque = $stmt->fetch(PDO::FETCH_ASSOC);
    $soma_estoque = $soma_estoque['quantidade'];
    
    if(is_null($soma_estoque)) {
        $soma_estoque = 0;
    }

    if($quantidade > $soma_estoque) {
    ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
        <script>
          //  document.getElementById("olamundo").addEventListener("click", exibeMensagem);
            Swal.fire({
              icon: 'error',
              title: 'Quantidade muito alta',
              text: 'O estoque máximo é de '+"<?=$soma_estoque?>",
            })
        // https://blog.betrybe.com/desenvolvimento-web/sweetalert/
        </script>
    <?php
    }else{
        try{
           $sql = "INSERT INTO vendas(produto_id, quantidade, data, preco) VALUES (?,?,?,?)";
           $stm = $pdo->prepare($sql)->execute([$produto_id, $quantidade, $data, $preco]);
           $quant_form = $quantidade;

           if($soma_estoque == 0){
               // Adicionar a quantidade comprada ao estoque
               $sqle = "INSERT INTO estoques(produto_id, quantidade) VALUES (?,?)";
               $stme = $pdo->prepare($sqle)->execute([$produto_id, $quantidade]);
           }else{
               // Atualizar a quantidade comprada no estoque
               $estoque_atual = $soma_estoque - $quant_form;

               $sqle = "UPDATE estoques set quantidade = $estoque_atual WHERE produto_id = ?";
               $stme = $pdo->prepare($sqle)->execute([$produto_id]);     
           }

           if($stm){
               echo 'Dados inseridos com sucesso';
		       header('location: ../estoques/index.php');
           }
           else{
               echo 'Erro ao inserir os dados';
           }
       }
       catch(PDOException $e){
          echo $e->getMessage();
       }
    }
}

require_once('../footer.php');
?>
