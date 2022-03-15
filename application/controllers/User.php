<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("UserModel");
        // $this->verifyLoginAdmin();
        $this->load->library("csv");

    }

    public function create(){
        $ch = curl_init("http://localhost/giuliadomna/giuliadomna-sac/update/pre-cadastro");
        $precadastro = file_get_contents('public/data/pre-cadastro.json');
        curl_exec($ch);
        curl_close($ch);
        printf($precadastro);


    }

    public function update(){

        $data = $this->input->post(NULL, TRUE);
        $data = array_filter($data);

        $data['id'] = $this->session->userdata('id');
        $dir = getcwd()."/uploads/".$data['id']."/logo/";

       
        if (!is_dir($dir)) {
            mkdir($dir, 0777, TRUE);
        }
        
        $config['upload_path']          = 'uploads/' . $data['id'] . "/logo";
        $config['allowed_types']        = 'png|jpg';
        $config['max_size']             = 2048;
        $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('nome-responsavel', 'Nome');
        $this->form_validation->set_rules('email', 'E-mail','valid_email');
        $this->form_validation->set_rules('telefone', 'Telefone');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Erro ao atualizar seus dados de usuário: um ou mais campos não foram preenchidos. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button></div>');

            redirect('user/perfil/editar');
        }else{
            if(!empty($_FILES['logo']['type'])){
                
                if ( ! $this->upload->do_upload('logo')){

                    $this->session->set_flashdata('error',$this->upload->display_errors('<p class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>','</p>'));
                    redirect('user/perfil/editar');
            
                }else{

                    $dataImage = $this->upload->data();
                    $data['logo'] = base_url('uploads/').$data['id'].'/logo/'.$dataImage['file_name'];
                    
                }
            }
            
            
            $update_user = $this->UserModel->update($data);
        
            if($update_user){
                $id = $this->session->userdata('id');
                $fields = $this->UserModel->getProfile($id);
            
                if($fields){
                    $result = json_decode(json_encode($fields[0]), True);
                    $this->session->set_userdata($result);  
                    $this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">Seus dados de usuário foram atualizados com sucesso!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button></div>');
        
                    redirect('user/perfil/editar');
                }
            }
     
        }
                    
    }


    public function cadastrarNota(){
        $this->load->library('upload');

        $data['user_id'] = $this->session->userdata('id');
        $numeroNota = $this->input->post('numero-nota-1');
        $arquivoNota = $this->input->post('arquivo-nota-1');
        
        $id_solicitacao = $this->input->post('id-solicitacao');
        
        if (!is_dir('uploads/'.$data['user_id'])) {
            mkdir('uploads/' . $data['user_id'], 0777, TRUE);
        }
        
        $config['upload_path']          = 'uploads/' . $data['user_id'];
        $config['allowed_types']        = 'pdf|jpg|png';
        $config['max_size']             = 3000;
        // $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        //print_r($config);


        if ( ! $this->upload->do_upload('arquivo-nota-1')){
            $error = array('error' => $this->upload->display_errors());
            
            $this->session->set_flashdata('message', 'Ocorreu um erro..');
            redirect('painel/solicitacao/'.$id_solicitacao);
            
            // $this->load->view('upload_form',);
            $this->load->template('dashboardView', $error);
        }
        else{
            

            $data = array('upload_data' => $this->upload->data());

            $data['user_id'] = $this->session->userdata('id');
            $data['nota'] = $numeroNota;
            $data['id_solicitacao'] = $id_solicitacao; 
            $data['url'] = base_url('uploads/').$data['user_id'].'/'.$data['upload_data']['file_name'];

            //print_r($data);
            $this->ModelSolicitacoes->cadastroNotas($data);

            $this->session->set_flashdata('message', 'Nota cadastrada com sucesso..');
            redirect('painel/solicitacao/'.$id_solicitacao);
          
        }
       
    }

    public function edit(){

        $this->load->template('commom/editView');

    }

    public function contact(){

        $this->load->template("user/contactView");
    
    }

    public function termosdeuso(){

        $this->load->template("termosDeUsoView");
    
    }

    public function comofunciona(){

        $this->load->template("comoFuncionaView");
    
    }

}
