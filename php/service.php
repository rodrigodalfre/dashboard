<?php

require "model.php";
require "conexao.php";


class Service{

    private $conexao;
    private $dashboard;

    public function __construct(Conexao $conexao, Dashboard $dashboard){
        $this->conexao = $conexao->conectar();
        $this->dashboard = $dashboard;
    }

    //Número de Vendas
    public function getNumeroVendas() {
        $query = 'SELECT 
                count(*) as numero_vendas 
            FROM 
                tb_vendas 
            WHERE 
                data_venda BETWEEN :data_inicio AND :data_fim ';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }

    //Total de Vendas
    public function getTotalVendas() {
        $query = 'SELECT 
                sum(total) as total_vendas 
            FROM 
                tb_vendas 
            WHERE 
                data_venda BETWEEN :data_inicio AND :data_fim ';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;
    }

}

//INSTANCIAS
$dashboard = new Dashboard();
$conexao = new Conexao();
$service = new Service($conexao, $dashboard);

//SETTERS
$dashboard->__set('data_inicio', '2020-08-01'); //DATA INÍCIO
$dashboard->__set('data_fim', '2020-08-31'); //DATA FIM
$dashboard->__set('numeroVendas', $service->getNumeroVendas()); //NÚMERO DE VENDAS
$dashboard->__set('totalVendas', $service->getTotalVendas()); //TOTAL DE VENDAS



echo '<pre>';
print_r($dashboard);

?>