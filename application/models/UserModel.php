<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function usuarios($id_usuario = null){
		//$id_usuario = 2;
		if($id_usuario != null){
			$this->db->where('id', $id_usuario);
		}

		return $this->db->get("usuarios")->result();
	}

    public function update($data){

        $id_user = $this->session->userdata('id');

        $this->db->where('id', $id_user);
        return $this->db->update('usuarios', $data);
        
	}

	public function login($data){

		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('cnpj', $data['cnpj']);
		$query = $this->db->get()->row(); 
		if(count($query) < 1){
			return false;
		}
		
		$pass_crypto = sha1($data['senha']);
		
		if($query->senha !== $pass_crypto){
			return false;
		}
		return (array) $query;
	}

	public function getProfile($id = null){
		$this->db->select('id, nome, email, cnpj, funcao, logo, nome_fantasia, status');
		$this->db->from('usuarios');
		$this->db->where('id', $id);
		
		$query = $this->db->get(); 
		$result = $query->result();

        return $result;
	}

	public function getCompany($id = null){
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('id', $id);
		
		$query = $this->db->get(); 
		$result = $query->result();

        return $result;
	}
	
	public function create($data){

		// Criptografa senha com SHA1 e insere junto no array $data
		$pass_crypto = sha1($data['senha']);
		$data = array_merge($data, array('funcao' => 'user', 'senha' => $pass_crypto));
		$pass_crypto = (string)$pass_crypto;

		// Faz a pesquisa e verifica se já existe um usuário com o mesmo (Agora Apenas) cnpj.
		$this->db->select('cnpj, email');
		$this->db->from('usuarios');
		$this->db->where('cnpj', $data['cnpj']); 
		$query = $this->db->get(); 

		if( ($query->num_rows() < 1) ){

			// Pesquisa o id pelo cnpj
			$this->db->insert('usuarios', $data);
			$this->db->select('id');
			$this->db->from('usuarios');
			$this->db->where('cnpj', $data['cnpj']);
			$query = $this->db->get(); 

			foreach ($query->result() as $id){
        		$id= $id->id;
			}
		
			return $id;

		}else{

			return false;
		}

	}

	public function createAdminOrOperator($data){
		// Criptografa senha com SHA1 e insere junto no array $data
		$pass_crypto = sha1($data['senha']);
		$data = array_merge($data, array('senha' => $pass_crypto));
		$pass_crypto = (string)$pass_crypto;

		// Faz a pesquisa e verifica se já existe um usuário com o mesmo email
		$this->db->select('email');
		$this->db->from('usuarios');
		$this->db->where('email', $data['email']);  
		$query = $this->db->get(); 

		if( ($query->num_rows() < 1) ){

			// Cria o usuário
			$this->db->insert('usuarios', $data);
			$this->db->from('usuarios');

			$query = $this->db->get(); 
			return true;
		}else{

			return false;
		}

	}

	public function userExist($data){
		// Verifica se o usuário existe pelo CNPJ e Email
		$this->db->select('cnpj', 'email');
		$this->db->from('usuarios');
		$this->db->where('cnpj', $data['cnpj']);
		$this->db->where('email', $data['email']);
		
		$query = $this->db->get(); 
		$result = $query->result();

        return $result;
	}

	public function updatePassword($new_password,$cnpj){
        
        $fields = array(
            'senha' => sha1($new_password)
        );

        $this->db->where('cnpj', $cnpj);
		$result = $this->db->update('usuarios', $fields);
		return $result;
		
		
	}

	public function getLogs($id_usuario, $funcao){

		if($funcao == 'user'){

			$this->db->select('l.id_usuario, descricao, id_solicitacao, s.id, l.data_acesso');
			$this->db->from('registro_logs l');
			$this->db->join('registro_notificacoes n','l.id=n.id_logs');
			$this->db->join('solicitacoes s','s.id_usuario ='.$id_usuario);
			$this->db->where('s.id = l.id_solicitacao');
			$this->db->where('l.id_usuario !='.$id_usuario);
			
			$query=$this->db->get();
			return $query->result_array();
			
		}else{

			$this->db->select('n.id, l.id_usuario, descricao, id_solicitacao, l.data_acesso');
			$this->db->from('registro_logs l');
			$this->db->join('registro_notificacoes n','l.id=n.id_logs');
			$this->db->join('usuarios u','u.id = l.id_usuario');
			$this->db->where('l.id_usuario !='.$id_usuario);
			$this->db->where('u.funcao = "user"');

			$query=$this->db->get();
			return $query->result_array();
		}
		
	}

}