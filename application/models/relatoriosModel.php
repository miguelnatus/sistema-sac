<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class relatoriosModel extends CI_model {
    public function __construct(){
        parent::__construct();
    }

    public function solicitacoes($data_inicial=null, $data_final=null, $table=null){
        $this->db->select('solicitacoes.id, id_status_solicitacao');
        $this->db->from($table);
        $this->db->join("solicitacoes_itens i", "i.id_solicitacao =".$table.".id_usuario");
        $this->db->where("(data_criacao BETWEEN '".$data_inicial."' and '".$data_final."')");
        $this->db->where("(sol.data_criacao BETWEEN '".$data_inicial."' and '".$data_final."')");
        $query = $this->db->get();
        $result = $query->result();
    
        return $result;

    }

    public function buscarPelaReferencia($inicio = 0, $fim = 0, $group = 'referencia'){

        $this->db->select('referencia');
        $this->db->select('id_solicitacao');
        $this->db->select('sum(quantidade) as total');
        $this->db->select('count(referencia) as ocorrencia');
        $this->db->select('sum(case when id_tipo_problema = 1 then 1 else 0 end) as fabricacao');
        $this->db->select('sum(case when id_tipo_problema = 2 then 1 else 0 end) as fabricacao_coleta');
        $this->db->select('sum(case when id_tipo_problema = 3 then 1 else 0 end) as mau_uso');
        $this->db->select('sum(case when id_tipo_problema = 5 then 1 else 0 end) as projeto');
        $this->db->select('sum(case when id_tipo_problema = 6 then 1 else 0 end) as projeto_coleta');
        $this->db->select('sum(case when id_tipo_problema = 6 then 1 else 0 end) as material');
        $this->db->select('sum(case when id_tipo_problema = 7  then 1 else 0 end) as material_coleta');
        
        
        $this->db->from('solicitacoes_itens i');
        $this->db->join("solicitacoes sol", "i.id_solicitacao = sol.id");
        $this->db->join("itens", "i.id_item = itens.id");
        $this->db->join("tipos_problemas tp", "id_tipo_problema = tp.id");
        $this->db->where("(sol.data_criacao BETWEEN '".$inicio."' and '".$fim."')");
        $this->db->group_by($group);
        $query = $this->db->get();
        $result = $query->result();
    
        return $result;

    }

    public function buscarIdsPelaReferencia($inicio = 0, $fim = 0, $referencia){
        $this->db->select('distinct(id_solicitacao) id_solicitacao');
        $this->db->from('solicitacoes_itens');
        $this->db->join("itens", "id_item = itens.id");
        $this->db->join("solicitacoes s", "id_solicitacao = s.id");
        $this->db->where('referencia', $referencia);
        $this->db->where("(s.data_criacao BETWEEN '".$inicio."' and '".$fim."')");

        $query = $this->db->get();
        $result = $query->result();
    
        return $result;
    }

    public function buscarPorProblema($inicio = 0, $fim = 0){
        $this->db->select('id_solicitacao');
        $this->db->from('solicitacoes_itens');
        $this->db->join("itens", "id_item = itens.id");
        $this->db->where('referencia', $referencia);

        $query = $this->db->get();
        $result = $query->result();
    
        return $result;
    }

    
    public function buscarPeloLojista($inicio = 0, $fim = 0, $lojista = null){

        $this->db->select("ss.nome,
        u.razao_social,
        u.cnpj,
        u.email, 
        s.id,
        s.data_criacao,
        referencia,
        quantidade,
        tp.nome fabricacao

        ");
       
        $this->db->from('usuarios u');
        $this->db->join("solicitacoes s", "u.id = s.id_usuario");
        $this->db->join("status_solicitacao ss", "s.id_status_solicitacao = ss.id");
        $this->db->join("solicitacoes_itens si", "s.id = si.id_solicitacao");
        $this->db->join("itens", "si.id_item = itens.id");
        $this->db->join("tipos_problemas tp", "id_tipo_problema = tp.id");
  
        $this->db->where_in('u.id', $lojista);
     
        $this->db->where("(s.data_criacao BETWEEN '".$inicio."' and '".$fim."')");
    
       
        $query = $this->db->get();
        $result = $query->result();
    
        return $result;

    }
}