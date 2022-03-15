<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_model {

    public function insert($data){

        $this->db->insert("usuarios",$data);
    
    }

    public function update($fields,$id){
        $fields = $this->UserModel->getProfile($id);
		if($fields){
			$this->session->set_userdata($fields);
        }
        $this->db->where('id', $id);
        $this->db->update('usuarios', $fields);

    }

    public function updateAdminFromAdmin($data){
        
        if(empty($data['status'])){
            $data['status'] = '0';
        }else{
            $data['status'] = '1';
        }
        if(!(empty($data['senha']))){
            $pass_crypto = sha1($data['senha']);
            $data = array_merge($data, array('senha' => $pass_crypto));
        }
        
        $this->db->where('id', $data['id']);
        if($this->db->update('usuarios', $data)){
            return true;
        }

        

    }

    
    public function getUsers($filter = NULL){
        $this->db->from('usuarios');

        if ($filter !== NULL) {

            if(is_array($filter)){

                $this->db->where("funcao",$filter[0]);

                for ($i=1; $i < count($filter); $i++) { 
                    $this->db->or_where("funcao",$filter[$i]);
                }
                
            }else{

                $this->db->where("funcao",$filter);
            
            }
        
        }
        $busca = $this->input->get('sl');
        if ($busca):
            
            $this->db->like("nome",$busca);
            $this->db->or_like("nome_fantasia",$busca);
            $this->db->or_like("razao_social",$busca);
            $this->db->or_like("email",$busca);
            $this->db->or_like("cnpj",$busca);

        endif;

        // $this->db->where("funcao","admin");
        // $this->db->or_where("funcao","operador");
        
        $result = $query = $this->db->get()->result();
        
        return $result;
    }

    public function getLojistas(){
        $fields = array("id","nome","status","cnpj","endereco","nome_fantasia","razao_social", "proprietario");

        $this->db->where("funcao","user");
        $this->db->select($fields);
        $result = $query = $this->db->get('usuarios')->result();

        return $result;
    }

    public function updatePassword($new_password,$id){
        
        $fields = array(
            'senha' => $new_password
        );

        $this->db->where('id', $id);
        $this->db->update('usuarios', $fields);
    }

    public function updateStatus($new_status,$id){

        $fields = array(
            'status' => $new_status
        );

        $this->db->where('id', $id);
        $this->db->update('usuarios', $fields);

    }
}