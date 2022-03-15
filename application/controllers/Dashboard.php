<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();   
        $this->load->model("ModelSolicitacoes");
        $this->load->model("ModelMensagem");
        $this->load->library("pagination");

    }

    public function user(){

        $data['user_id'] = $this->session->userdata('id');
        
        $config['base_url'] = urlTypeUser().'painel';
        $config['total_rows'] = count($this->ModelSolicitacoes->solicitacoes($data['user_id'])["solicitacoes"]);
        $config['per_page'] = 15;

        $qtd = $config['per_page'];
        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;

        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = 'Próximos';
        $config['next_tag_open'] = '<span class="nextlink">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = 'Anterior';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);

        $data['paginacao'] = $this->pagination->create_links();
        $data['solicitacoes'] = $this->ModelSolicitacoes->solicitacoes($data['user_id'],$qtd,$inicio, $this->order())["solicitacoes"];
        $data['qtd'] = $qtd;
        $data['total'] = count($this->ModelSolicitacoes->solicitacoes($data['user_id'])["solicitacoes"]);
        $data['user'] = $this->UserModel->usuarios($data['user_id']);

    	$this->load->template('dashboardView',$data);

    }

    public function admin(){
     

        $data['user_id'] = $this->session->userdata('id');

        $data['user'] = $this->UserModel->usuarios($data['user_id']);
        $data['profile'] = $this->profile(); //Pega informaçãões do perfil logado

        $config['base_url'] = urlTypeUser().'painel';
        $config['total_rows'] = $this->ModelSolicitacoes->solicitacoesCount()->count;
    
        $config['per_page'] = $data['qtd'] = 20;
        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;
        $data['solicitacoes'] = $this->ModelSolicitacoes->solicitacoes(null, $data['qtd'], $inicio, $this->order())["solicitacoes"];
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = 'Próximos';
        $config['next_tag_open'] = '<span class="nextlink">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = 'Anterior';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
       
        $this->pagination->initialize($config);
        $data['paginacao'] = $this->pagination->create_links();
        $this->load->template('dashboardView',$data);


    }

    public function busca(){
        $data["solicitacoes"] = $this->ModelSolicitacoes->solicitacoes();

        $this->load->template("dashboardView",$data);
    }

    public function order(){
        

        if($order = $this->input->get()){

            if(isset($order['qtd'])){
                if($order['qtd'] == 'max'){
                    return 'quantidade DESC';
                }else if($order['qtd'] == 'min'){
                    return 'quantidade ASC';
                }else{
                    return 'id DESC';
                }
            }
            if(isset($order['data'])){
                if($order['data'] == 'min'){
                    return 's.data_criacao ASC';
                }else{
                    return 'id DESC';
                }
            }
            if(isset($order['status'])){
                if($order['status'] == 'aberto'){
                    return 'st.id ASC';
                }else if($order['status'] == 'finalizado'){
                    return 'st.id DESC';
                }else{
                    return 'id DESC';
                }
            }
            
        }else{
            return 'id DESC';
        }

        
        

    }

}
