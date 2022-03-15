<?php
	class ModelDashboard extends CI_model {

		public function usuarios($id_usuario = null){
			//$id_usuario = 3;
			if($id_usuario != null){
				return $this->db->where('id', $id_usuario);
			}
		}

		public function clientes($id_cliente = null) {
				
			if ($id_cliente != null) {
				$this->db->where("id", $id_cliente);
			}
			
			$this->db->order_by("nome");
			return $this->db->get("clientes");
			
		}
		
		 public function salvar($dados){
		 	
		 	$fields = array(
		 		'nome' => $dados['cliente'],
		 		'cidade' => $dados['cidade'],
		 		'data' => $dados['data'],
		 		'titulo_trab' => $dados['titulo'],
		 		'info_trab' => $dados['informacoes'],
		 		//'imagem' => $dados['imagem_titulo']
		 	);
			$this->db->insert('clientes',$fields);
			return $this->db->insert_id();
			
		 }
	}	