<?php
include_once("../connect.php");

$stmt = $pdo->prepare("SELECT COUNT(*) FROM vendas");
$stmt->execute();
$rows = $stmt->fetch();

// get total no. of pages
$total_pages = ceil($rows[0]/$row_limit);

$operacao = 'Vendas';

require_once '../header.php';
?>
        <div class="row">
            <!-- Adicionar registro -->
            <div class="text-left col-md-2 top">
                <a href="./add.php" class="btn btn-primary pull-left">
                    <span class="glyphicon glyphicon-plus"></span> Adicionar
                </a>
            </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody id="pg-results">
            </tbody>
        </table>
        <div class="panel-footer text-center">
            <div class="pagination"></div>
        </div>
    </div>
</div>
    
<script src="../assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/jquery.bootpag.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#pg-results").load("fetch_data.php");
    $(".pagination").bootpag({
        total: <?=$total_pages?>,
        page: 1,
        maxVisible: 18,
        leaps: true,
        firstLastUse: true,
        first: 'Primeira',//←
        last: 'Última',//→
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
    }).on("page", function(e, page_num){
        //e.preventDefault();
        $("#results").prepend('<div class="loading-indication"> Loading...</div>');
        $("#pg-results").load("fetch_data.php", {"page": page_num});
    });
});
</script>

<?php require_once '../footer.php'; ?>
