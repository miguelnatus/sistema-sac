<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

    // Para atualizar os dados de pré-cadastro acesse: http://localhost/giuliadomna/giuliadomna-sac/update/pre-cadastro


    public function index(){
        $json_  = array(
            "path" => getcwd()."/public/data/",
            "name" => "pre-cadastro"
        );

        $this->load->library("csv");
        $this->csv->setCsv($this->path_csv);
        $this->csv->setJson($json_);

        echo "<pre>";
        print_r($this->csv->getCsvData());
        echo "</pre>";

    }
}