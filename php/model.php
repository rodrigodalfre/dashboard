<?php 

class Dashboard {

    private $data_inicio;
    private $data_fim;
    private $numeroVendas;
    private $totalVendas;
    private $totalDespesas;
    private $clientAtivos;
    private $clientInativos;
    private $totalReclamacao;
    private $totalElogios;
    private $totalSugestao;

    public function __set($attr, $value){
        $this->$attr = $value;
        return $this;
    }

    public function __get($attr){
        return $this->$attr;
    }


}

?>