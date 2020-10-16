<?php 

class Dashboard {

    public $data_inicio;
    public $data_fim;
    public $numeroVendas;
    public $totalVendas;
    public $totalDespesas;
    public $clientAtivos;
    public $clientInativos;
    public $totalReclamacao;
    public $totalElogios;
    public $totalSugestao;

    public function __set($attr, $value){
        $this->$attr = $value;
        return $this;
    }

    public function __get($attr){
        return $this->$attr;
    }

}

?>