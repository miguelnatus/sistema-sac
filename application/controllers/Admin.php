<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("AdminModel");
        $this->load->model("UserModel");
        $this->load->model("ModelMensagem");
        // $this->verifyLoginAdmin();
        
    }

    public function create(){
        $data = $this->input->post(array('nome','email', 'funcao', 'senha'), TRUE);
		$confirmed = $this->input->post('senha-confirmada', TRUE);

		/**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
		*/
		
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        $this->form_validation->set_rules('senha-confirmada', 'Senha', 'required');
	
		
		if ($this->form_validation->run() == FALSE){

            $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Ops, um ou mais campos não foram preenchidos corretamente <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>' );
            redirect('admin/usuarios/cadastro');
		
		}else{

				if($data['senha'] == $confirmed){
					
					if($this->UserModel->createAdminOrOperator($data)){
						$this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">Usuário criado com sucesso<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button></div>');
                            redirect('admin/usuarios/cadastro');
						
					}else{
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Seu e-mail já está sendo usado<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				  		</button></div>');
						redirect('admin/usuarios/cadastro');
					}
					
					
				}else{
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Senhas não correspondem, tente novamente<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				  	</button></div>');
					redirect('admin/usuarios/cadastro');
				}
           
        }	
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

            redirect('admin/perfil/editar');
        }else{

            if(!empty($_FILES['logo']['type'])){
            if ( ! $this->upload->do_upload('logo')){

                $this->session->set_flashdata('error',$this->upload->display_errors('<p class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>','</p>'));
                redirect('admin/perfil/editar/');
        
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
        
                    redirect('admin/perfil/editar');
                }
            }
     
        }
                    
    }


    public function edit(){
        $id = $this->session->userdata();
       
        $data['empresa'] = $this->UserModel->getCompany($id['id']);

        $this->load->template('commom/editView',$data);
    }

    public function users(){
        
        $data["users"] = $this->AdminModel->getUsers();
        $data['profile'] = $this->profile();
        $this->load->template("admin/usersView", $data);
    
    }   

    public function lojistas(){
        $filter = "user";

        $data["lojistas"] = $this->AdminModel->getUsers($filter);
        $data['profile'] = $this->profile();
        $this->load->template("admin/logistasView", $data);

    }

    public function userUpdate($id = 0){
        $data = $this->input->post(null, TRUE);
        $data = array_filter($data);
        

        $result = $this->AdminModel->updateAdminFromAdmin($data);
        if($result){
            $this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">Usuário editado com sucesso!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('admin/usuarios/atualizar/'.$data['id']);
        }

    }

    public function userPasswordUpdate($id = 0){
        $data = $this->input->post(null, TRUE);
        $data = array_filter($data);

        $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $new_password= "";

        for($count= 0; 9 > $count; $count++){
            //Gera um caracter aleatório
            $new_password.= $basic[rand(0, strlen($basic) - 1)];
        }
        

        $result = $this->UserModel->updatePassword($new_password, $data['cnpj']);
        
        
        if($result){
            
            

            /* 
		*
		*	Montando e configurando email 
		*
		*/
		$this->html = '
        <table> 
            <tr>
                <td>Esta é a sua nova senha, entre na sua conta com ela:</td>
            </tr>
            <tr>
                <td> <strong>'.$new_password.'</strong> </td>
            </tr>
            <tr>
                <td> Acesse o sistema em <strong> https://www.giuliadomna.com.br/sac </strong> </td>
            </tr>
           
        </table>';
              
    $config['useragent']        = 'Codeigniter';
    $config['protocol']         = 'smtp';
    $config['smtp_host']        = 'smtp.gmail.com';
    $config['smtp_user']        = 'miguel@inventocc.com';
    $config['smtp_pass']        = 'ozoutros';
    $config['smtp_port']        = 465;
    $config['smtp_timeout']     = 7;
    $config['smtp_crypto']      = 'ssl';
    $config['smtp_debug']       = 0;
    $config['wordwrap']         = TRUE;
    $config['wrapchars']        = 76;
    $config['mailtype']         = 'html';
    $config['charset']          = 'utf-8';
    $config['validate']         = TRUE;
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
    $config['bcc_batch_mode']   = false;
    $config['bcc_batch_size']   = 200; 
    
    /* 
    *
    *	Email construído 
    *
    */

        
        // Se o usuário existir, envia o e-mail
      
            $this->email->initialize($config);
            $this->email->from('miguel@iventocc.com',  'Giulia Domna - Lojista'); 
        
               $this->email->to(''.$data['email']); 
        
            $this->email->subject('Recuperação de senha');
            $this->email->message($this->html);
 
            if($this->email->send()){

                // Se o e-mail for enviado, a senha será atualizada no db
                $updatePass = $this->UserModel->updatePassword($new_password, $data['cnpj']);
                $this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">Senha resetada com sucesso! O usuário recebeu um e-mail com a nova senha<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button></div>');
                redirect('admin/usuarios/atualizar/senha/'.$data['id']);
            }else{
                
                $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">E-mail não foi enviado, por favor tente novamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button></div>' );
                redirect('admin/usuarios/atualizar/senha/'.$data['id']);
                }
        
        }

    }

    public function userUpdateView($id = 0){

        $id_param = $this->uri->segment(4);       
        $data['profile'] = $this->UserModel->getProfile($id_param);
        $this->load->template("admin/userUpdateView", $data);
    }

    public function userUpdatePasswordView($id = 0){

        $id_param = $this->uri->segment(5);       
        $data['profile'] = $this->UserModel->getProfile($id_param);
        $this->load->template("admin/userUpdatePasswordView", $data);
    }
    public function userRegister(){
        $this->load->template("admin/userRegisterView");
    }

    public function lojistaUpdate(){
        $this->load->template("admin/userRegisterView");
    }

    public function lojistaRegister(){
        $this->load->template("admin/userRegisterView");
    }

    public function resetPasswordTemplate(){
        $this->load->template("admin/resetPasswordView");
    }

    public function addUser(){

        $data = $this->input->post();

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('funcao', 'Função', 'required');
        $this->form_validation->set_rules('senha', 'Senha', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Erro ao cadastrar os dados do usuário: um ou mais campos não foram preenchidos.');
        }else{
            $this->AdminModel->insert($data);
            $this->session->set_flashdata('success','Usuário cadastrado com sucesso!');
        }

        $this->load->template("admin/userRegisterView");

    }

    public function updateUser(){

        $data = $this->input->post();

        $fields = array(
            'nome' => $data['nome'],
            'email' => $data['email'],
            'funcao' => $data['funcao']
        );

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('funcao', 'Função', 'required');
        
        if ($this->form_valiadation->run() == FALSE){
            $this->session->set_flashdata('error','Erro ao atualizar os dados de usuário: um ou mais campos não foram preenchidos.');
        }else{
            $this->AdminModel->update($fields,$data['id']);
            $this->session->set_flashdata('success','Os dados de usuário foram atualizados com sucesso!');
        }

        $this->load->template("admin/userUpdateView");
    }

    public function addLojista(){

        $data = $this->input->post();

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('razao-social', 'Razão Social', 'required');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('nome', 'Nome', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Erro ao cadastrar um novo lojista: um ou mais campos não foram preenchidos.');
        }else{
            $this->AdminModel->insert($data);
            $this->session->set_flashdata('success','Lojista cadastrado com sucesso!');
        }

    }

    public function updateLojista(){

        $data = $this->input->post();

        $fields = array(
            'nome' => $data['nome'],
            'logo' => $data['logo'],
            'nome_fantasia' => $data['nome_fantasia'],
            'email' => $data['email'],
            'telefone' => $data['telefone']
        );

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required');


        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Erro ao atualizar os dados do lojista: um ou mais campos não foram preenchidos.');
        }else{
            $this->AdminModel->update($fields,$data['id']);
            $this->session->set_flashdata('success','Os dados do lojista foram atualizados com sucesso!');
        }
    }

    public function resetPassword(){
        $data = $this->input->post();
        $id = $data["id"];

        /**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
        */
        $this->form_validation->set_rules('senha', 'Senha', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Erro ao atualizar a senha do usuário: um ou mais campos não foram preenchidos.');
        }else{
            $this->AdminModel->updatePassword($data["senha"],$id);
            $this->session->set_flashdata('success','Senha do usuário alterada com sucesso!');
        }

        $this->load->template("admin/resetPasswordView");

    }

    public function changeUserStatus(){
        $data = $this->input->post();

        $id = $data["id"];

        $this->AdminModel->updateStatus($data["status"],$id);

        echo TRUE;
    }

   

    public function deleteMessage(){
        $data = $this->input->post();

        $id = $data["id"];
        $this->ModelMensagem->deleteMessage($id);
        echo true;
        redirect('');
    }



}