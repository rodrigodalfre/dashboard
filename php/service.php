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

    //Total de Despesas
    public function getTotalDespesas(){
        $query = 'SELECT
                sum(total) as total_despesas
            FROM
                tb_despesas
            WHERE
                data_despesa BETWEEN :data_inicio AND :data_fim';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total_despesas;
    }

    //Clientes Ativos
    public function getClientAtivos(){
        $query = "SELECT 
            COUNT(cliente_ativo) as cliente_ativo
        FROM 
            tb_clientes WHERE cliente_ativo = 1";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->cliente_ativo;
    }

    //Clientes Inativos
    public function getClientInativos(){
        $query = "SELECT 
            COUNT(cliente_ativo) as cliente_inativos
        FROM
            tb_clientes WHERE cliente_ativo = 0";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->cliente_inativos;
    }

    //Total de Reclamação
    public function getTotalReclamacao(){
        $query = "SELECT
            COUNT(tipo_contato) as reclamacao
        FROM 
            tb_contatos WHERE tipo_contato = 1";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->reclamacao;
    }

    //Total de Elogios
    public function getTotalElogios(){
        $query = "SELECT
            COUNT(tipo_contato) as elogios
        FROM
            tb_contatos WHERE tipo_contato = 3";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->elogios;
    }

    //Total de Sugestões
    public function getTotalSugestao(){
        $query = "SELECT
            COUNT(tipo_contato) as sugestao
        FROM 
            tb_contatos WHERE tipo_contato = 2";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->sugestao;
    }

}

//INSTANCIAS
$dashboard = new Dashboard();
$conexao = new Conexao();
$service = new Service($conexao, $dashboard);

//Ano e mês
$competencia = explode('-', $_GET['competencia']);
$ano = $competencia[0];
$mes = $competencia[1];

//Função nativa CalDaysInMonth espera 3 parâmetros, calendário(grego), mes e ano
$dia_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

//SETTERS
$dashboard->__set('data_inicio', $ano.'-'.$mes.'-01'); //DATA INÍCIO
$dashboard->__set('data_fim', $ano.'-'.$mes.'-'.$dia_mes); //DATA FIM
$dashboard->__set('numeroVendas', $service->getNumeroVendas()); //NÚMERO DE VENDAS
$dashboard->__set('totalVendas', $service->getTotalVendas()); //TOTAL DE VENDAS
$dashboard->__set('totalDespesas', $service->getTotalDespesas()); //TOTAL DESPESAS
$dashboard->__set('clientAtivos', $service->getClientAtivos()); //CLIENTES ATIVOS
$dashboard->__set('clientInativos', $service->getClientInativos()); //CLIENTES ATIVOS
$dashboard->__set('totalReclamacao', $service->getTotalReclamacao()); //RECLAMAÇÕES
$dashboard->__set('totalElogios', $service->getTotalElogios()); //ELOGIOS
$dashboard->__set('totalSugestao', $service->getTotalSugestao()); //SUGESTOES


//Transformar um objeto literal para o JavaScript
// echo json_encode($dashboard);
print_r($dashboard);


?>