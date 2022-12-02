# Estoque Simplificado

## Objetivo

O objetivo aqui não é o de entregar um sistema funcional, visto que o controle de estoque é um sistema bem grande, mas apenas mostrar algumas funcionalidades e dar uma ideia para que os interessados possam concluir o sistema. O sistema tem muito ainda por fazer para que fique funcional, mas estou compartilhando o que considero a ideia principal, que é a de efetuar certas operações via código, como a de adicionar ao estoque sempre que comprar e abater do estoque sempre que vender.

## Pesquise antes

É uma boa ideia fazer uma boa pesquisa sobre o assunto antes de iniciar o sistema, pois é um sistema complexo e que envolve especialistas de outras áreas, especialmente contabilidade.

## Trabalho em conjunto

Um sistema de estoque normalmente é criado por um programador experiente com a ajuda de um contador da empresa para a qual se vai criar o sistema. É importante que o programador faça inicialmente algumas reuniões com o contador para reunir informações que o possibilitem criar o sistema e em caso de alguma dúvida poder contar com a ajuda do contador. Caso a empresa tenha algum programa legado que será substituído é uma boa ideia estudar este programa. Caso não tenha é importante juntar alguns documentos sobre o sistema: compras, vendas, armazem e o sistema de armazenamento, que informações usam e qual a capacidade do(s) armazem(ns), entre outras.

## Codificação

A tabela estoques somente será cadastrada indiretamente, via código e somente nas operações insert nas tabelas compras e vendas.

- Quando for inserido um registro em compras, via código, o mesmo registro será inserido em estoques
- Quando for inserido um registro em vendas, via código, será removido o respectivo registro em estoques

## Simplificação do sistema

Para simplificação as tabelas compras e vendas somente terão as operações index/search e insert. Pois se usarmos update e delete nelas teremos também que ajustar o estoque, mas para este exemplo ficaremos apenas com index/select e insert.

- A tabela produtos contará com um CRUD completo
- Compras e vendas terão somente index, insert e busca
- Estoques terá somente index e busca

## Ambiente testado

- Linux Mint 21
- Apache2 2.4.52
- PHP 8.1
- MariaDb 10.6.11

## Rotinas

- Antes de efetuar uma compra, antes de inserir no banco, checar:
    - o estoque_maximo em produtos do respectivo produto 
    - e somente permitir a compra se a quantidade em estoque somada com a quantida que se pretende comprar,  somar um valor menor ou igual ao estoque_maximo.

- Antes de efetuar uma venda, checar o estoque_minimo para o produto que se pretende vender. 
    - Somente vender se existir quantidade suficiente em estoque. 
    - Caso, após a venda, a quantidade final do produto em estoque for igual ou inferior a quantidade do estoque_minimo em produtos 
    - então será disparado um aviso (usando o SwitchAlert) avisando para que o estoque seja reposto.

Obs.: num sistema em produção também devemos verificar a data de compra e a data de venda e nunca permitir que a data de venda de um produto seja menor que sua data de compra. Talvez inserir a data do sistema ao vender e ao comprar.

O preco de venda também precisa ser maior que o de compra. Idealmente estima-se um percentual de lucro e o sistema já faz isso automaticamente.


## Testando

Pra simplificar as coisas cadastrei somente um único produto, banana, com estoque_minimo 10 e estoque máximo 100


- Comprarei 50 bananas. Mas antes de comprar, preciso verificar o estoque_maximo de bananas, para garantir que não comprarei uma quantidade maior que o estoque máximo. Observe que a compra é feita pelo id do produto (produto_id, que é relacionado com produtos).

## Versões

- Criar versão com PHPOO
- Criar versão com MVC usando o micro-framework
