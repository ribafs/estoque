CREATE TABLE produtos (
    id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(50) UNIQUE NOT NULL,
    estoque_minimo INT NOT NULL,
    estoque_maximo INT NOT NULL,
    PRIMARY KEY (id)
);

insert into produtos (descricao, estoque_minimo, estoque_maximo) values 
('Banana', 10, 100);

CREATE TABLE compras (
    id INT NOT NULL AUTO_INCREMENT,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(9,2) NOT NULL,
    data DATE NULL DEFAULT NULL,
    PRIMARY KEY (id),
	constraint compra_fk foreign key (produto_id) references produtos(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE estoques (
    id INT NOT NULL AUTO_INCREMENT,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    PRIMARY KEY (id),
	constraint estoque_fk foreign key (produto_id) references produtos(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE vendas (
    id INT NOT NULL AUTO_INCREMENT,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    data DATE NULL DEFAULT NULL,
    preco DECIMAL(9,2) NOT NULL,
    PRIMARY KEY (id),
	constraint venda_fk foreign key (produto_id) references produtos(id) ON DELETE CASCADE ON UPDATE CASCADE
);

