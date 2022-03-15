<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelSolicitacoes extends CI_model {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function solicitacoes($id_usuario = null,$qtd = 0,$inicio = 0, $order = null){

        $fields = array("
            distinct(s.id) AS id,
            s.id_usuario,
            u.nome,
            count(n.solicitacao_id) existe_nota,
            sum(i.quantidade) qtd_produtos,
            s.data_criacao,
            st.nome status,
            sa.data_atualizacao,
            u.nome as cliente,
            u.nome_fantasia as nome_fantasia,
            u.razao_social
        ");



        $this->db->select($fields);
        $this->db->from("solicitacoes s");
        $this->db->join("(select max(data_atualizacao) data_atualizacao, id_solicitacao from solicitacoes_atualizacoes group by id_solicitacao) sa","sa.id_solicitacao = s.id");
        $this->db->join("(select solicitacao_id from nota_fiscal group by solicitacao_id) n","n.solicitacao_id = s.id","left");
        $this->db->join("status_solicitacao st","st.id = s.id_status_solicitacao");
        $this->db->join("usuarios u","u.id = s.id_usuario");
        $this->db->join("solicitacoes_itens si","si.id_solicitacao = s.id","left");
        $this->db->join("itens i","i.id = si.id_item","left");
        $this->db->group_by("status");
        $this->db->group_by("i.id");
        $this->db->order_by($order);
        if($id_usuario !== null){
            $this->db->where('id_usuario', $id_usuario);
        }

        if($qtd > 0) $this->db->limit($qtd, $inicio);  

        if(isset($_GET["s"])){

            if(strpos($_GET["s"],"/") !== FALSE){
                if (strpos($_GET["s"],"/")>6){
                    $match = $_GET["s"];
                } else {
                    $date = explode("/",$_GET["s"]);
                    if(!empty($date[2])){
                        $match = $date[2]."-".$date[1]."-".$date[0];
                    }else{
                        $match = $date[1]."-".$date[0];
                    }
                }
            }else{
                $match = preg_replace('/(#|\/|)/',"",$_GET["s"]);
            }
            
            $this->db->like('s.data_criacao', $match);
            $this->db->or_like('s.id', $match);
            $this->db->or_like('u.nome', $match);
            $this->db->or_like('u.nome_fantasia', $match);
            $this->db->or_like('st.nome', $match);
            $this->db->or_like('u.razao_social', $match);
            $this->db->or_like('u.cnpj', $match);
            $this->db->or_like('u.email', $match);
        }
        
        $query = $this->db->get()->result();
        $result = array(
            "num_rows" => count($query), 
            "solicitacoes" => $query
        );


        return $result;
    }

    

    public function insert($table,$data){
        $this->db->insert($table,$data);

        $id_ = $this->db->insert_id();
        
        return $id_;
    }

    public function solicitacoesItens($id_solicitacao){
        $this->db->select('solicitacoes_itens.id_item,solicitacoes_itens.id_solicitacao,solicitacoes_itens.id_status, solicitacoes_itens.id_tipo_problema,solicitacoes.id_status_solicitacao AS id_status_solicitacao,solicitacoes.data_criacao,itens.referencia,itens.quantidade,itens.descricao,status.nome AS status');
        $this->db->from('solicitacoes_itens');
        $this->db->join('solicitacoes', 'solicitacoes.id = solicitacoes_itens.id_solicitacao');
        $this->db->join('itens', 'itens.id = solicitacoes_itens.id_item');
        $this->db->join('status', 'status.id = solicitacoes_itens.id_status');
        $this->db->where('id_solicitacao', $id_solicitacao);

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function mostrarFotos($id_item){
        $this->db->select('*');
        $this->db->from('fotos');
        $this->db->where('id_item', $id_item);
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }

    public function mostrarNotas($id_solicitacao){
       $this->db->select('*');
       $this->db->from('nota_fiscal');
       $this->db->where('solicitacao_id', $id_solicitacao);
       $query = $this->db->get();
       $result = $query->result();

       return $result;
    }

    public function cadastroNotas($data){
        
        $fields = array(
            'usuario_id' => $data['user_id'],
            'nota' => $data['nota'],
            'solicitacao_id' => $data['id_solicitacao'],
            'url' => $data['url']
        );
        $this->db->insert('nota_fiscal',$fields);

        $this->log($data['user_id'], $data['id_solicitacao'], '"Nota cadastrada"');

        
        
    }

    public function status($key = NULL,$value = NULL, $table = "status"){
        $this->db->select('*');
        $this->db->from($table);

        if ($key !== NULL) {
            $this->db->where($key,$value);
        }

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }


    public function listaStatusSolicitacao(){
        $this->db->select('*');
        $this->db->from('status_solicitacao');

        $query = $this->db->get();
        $result = $query->result();

        return $result;

    }

    public function tipoProblema(){
        $this->db->select('*');
        $this->db->from('tipos_problemas');

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function update($id,$fields,$table,$id_solicitacao = NULL){

        if($table == "solicitacoes_itens"){
            $this->db->where("id_item",$id);
        }else{
            $this->db->where("id",$id);
        }

        $this->db->update($table,$fields);
       

        if($id_solicitacao !== NULL){
            $this->db->insert("solicitacoes_atualizacoes",array(
                "id_solicitacao" => $id_solicitacao
            ));
        }

      

    }

    public function deletarNota($id_nota){
        $this->db->where('id', $id_nota);
        return $this->db->delete('nota_fiscal');
    }

    public function atualizacoesSolicitacao($id_solicitacao){

        $this->db->select('data_atualizacao');
        $this->db->from("solicitacoes_atualizacoes");
        $this->db->where("id_solicitacao",$id_solicitacao);
        $this->db->order_by("data_atualizacao","DESC");

        $row = $this->db->get()->row();

        return $row;

    }



    public function log($id_usuario = null, $id_solicitacao, $descricao){

        $this->db->trans_start();
            $this->db->set('id_usuario', $id_usuario, FALSE);
            $this->db->set('id_solicitacao', $id_solicitacao, FALSE);
            $this->db->set('descricao', $descricao, FALSE);
            $this->db->insert('registro_logs');
            $last_id = $this->db->insert_id();
            $this->db->set('id_logs', $last_id, FALSE);
            $this->db->insert('registro_notificacoes');
        $this->db->trans_complete();

    }

    public function deleteLogs($id_usuario = null, $id_solicitacao = null, $funcao = 'user', $funcao2 = 'user'){

        $this->db->query("DELETE n FROM 
        registro_notificacoes n JOIN registro_logs l ON l.id = n.id_logs JOIN usuarios u ON u.id = l.id_usuario
        WHERE l.id_solicitacao = ".$id_solicitacao." AND l.id_usuario != ".$id_usuario." AND u.funcao = '".$funcao."' OR u.funcao = '".$funcao2."'");
        

    }

    public function solicitacoesCount(){
        $this->db->select('count(id) count');
        $this->db->from("solicitacoes");

        $query = $this->db->get();
        $result = $query->result();
    
        return $result[0];
    }
    

}