<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelMensagem extends CI_model {
    
    public function __construct(){
        parent::__construct();
    }

    public function mensagens($id_solicitacao){
        $this->db->select('*');
        $this->db->from('mensagens');
        $this->db->where('id_solicitacao', $id_solicitacao);
        $this->db->order_by('data', 'DESC');
        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function adicionar($data){
     //    echo '<pre>';
    	// print_r($data);
     //    echo '<script>alert(1)</script>';
        if(!isset($data['url'])){
            $data['url'] = NULL;
        }

    	$fields = array(
            'id_usuario' => $data['user_id'],
            'mensagem' => $data['mensagem'],
            'id_solicitacao' => $data['id_solicitacao'],
            'data' => date("Y/m/d H:i:s"),
            'anexo' => $data['url']
        );
        $this->db->insert('mensagens',$fields);
        return $this->db->affected_rows();  
    }   

    public function deleteMessage($id_message){
        
    
        return $this->db->delete('mensagens', array('id' => $id_message));
    }
}