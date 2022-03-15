<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv {

    private $path_csv;

    public function setCsv($path){
        $this->path_csv = $path;
    }

    public function getCsvData(){

        $handle = fopen($this->path_csv, "r");
        
        //VALORES DA PRIMEIRA LINHA DA TABELA (CHAVES)
        $header = explode(",",fgets($handle));
		
		$row = array();
		
		while ($data = fgetcsv($handle,1000, ",")) {
			$data_row = $data;
			
			//DEFINE UM ARRAY COM CHAVE (VALORES DO ARRAY $HEADER) E VALOR (VALORES DAS LINHAS ARMAZENADAS EM $DATA_ROW)
			for ($i=0; $i < count($header); $i++) { 
				$index = trim(strtolower($header[$i]));
				$row_index[$index] = $data_row[$i];
			}

			array_push($row, $row_index);	
		}

		fclose($handle);	

		return $row;
	}
	
	public function setJson($json_){
		$data = $this->getCsvData();
		$file = fopen($json_['path'].$json_['name'].".json", "w+a");

		$json = json_encode($data);

		fwrite($file,$json);

		fclose($file);
	}

	public function getRow($filter, $filter_value){
		$data = $this->getCsvData($this->path_csv);
		
		foreach ($data as $value) {
			if(isset($value[$filter])){
				$array_filter_value = explode(" ",$filter_value);
				$array_value = explode(" ",$value[$filter]);

				$result = array_diff_assoc($array_filter_value,$array_value);

				if(count($result) < count($array_filter_value)){
					return $value;
				}
			}
		}
		
	}

}