<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['page'] = 'home';	
		
		$this->load->template('home/homeView', $data);
	}

	public function viewRegister(){
		$data['page'] = 'home';
		$this->load->template('home/registerView', $data);
			
	}

	public function viewTermos(){
		$data['page'] = 'home';
		$this->load->template('home/termosView', $data);

	}
	public function viewRecover(){
		$data['page'] = 'home';
		$this->load->template('home/recoverView', $data);
			
	}
	public function login(){

		$data = $this->input->post(array('cnpj', 'senha'), TRUE);

		$fields = $this->UserModel->login($data);
		
		if($fields){
			if ($fields["funcao"] == "admin" || $fields["funcao"] == "operador") {
				if($fields['status'] != 0){
					  
					$this->session->set_userdata($fields);
					
					redirect('admin/painel');
				}else{
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário invativo, contate o administrador<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button></div>');
			
					redirect('');
				}
				
			}else{
				if($fields['status'] != 0){
					$this->session->set_userdata($fields);
					redirect('user/painel');
				}else{
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário invativo, contate o administrador<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>');
			
			redirect('');
				}
				
			}

			
		}else{
			$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Senha ou CNPJ incorretos<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>');
			
			redirect('');
		}
		
	}
	
    public function create(){

		$data = $this->input->post(array('cnpj','email', 'senha'), TRUE);
		$confirmed = $this->input->post('senha-confirmada', TRUE);

		/**
        * ------------------------------------------
        *
        * Regras para validação de formulário
        *
        * ------------------------------------------
		*/
		
		$this->form_validation->set_rules('cnpj', 'CNPJ', 'required|max_length[18]');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('senha', 'Senha', 'required|min_length[6]');
		$this->form_validation->set_rules('lembrar', 'Lembrar', 'required');
		
		if ($this->form_validation->run() == FALSE){

            $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Ops, um ou mais campos não foram preenchidos corretamente <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>' );
            $this->load->template("home/registerView");
		
		}else{
			
		   	/* Se o CNPJ estiver no pré-cadastro, verifica se as senhas correspondem, 
			  chama o Create do Model do usuário e o deixa logado.
			*/

			if($resultVerify = $this->verifyCnpj($data)){
				if($data['senha'] == $confirmed){
					
					$data = array_merge($data, $resultVerify);
					
					if($id = $this->UserModel->create($data)){
						$fields = (array) $this->UserModel->login($data);
						if($fields){
							$this->session->set_userdata($fields);
							redirect('user/painel');
						}else{
							$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Senha ou e-mail incorretos<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button></div>');
			
							redirect('');
						}
					}else{
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">CNPJ ou e-mail já estão sendo usados<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				  		</button></div>');
						redirect('home/cadastro');
					}
					
					
				}else{
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Senhas não correspondem, tente novamente<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				  	</button></div>');
					redirect('home/cadastro');
				}
            }else{
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Ops!</strong>
					<p>Seu CNPJ não está cadastrado em nossa base.</p>
					<p>Caso você seja um lojista Cliente da Giulia Domna e não tenha conseguido criar seu usuário, por favor entre em contato conosco pelo número: 51 3097-9500.</p>
					<button class="btn btn-outline-danger">Ok, obrigado</button>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('home/cadastro');
				
			}
        }		
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}

	public function comoFunciona(){
		$this->load->template('comoFuncionaView');
	}

	public function passRecover(){
		$this->load->library('email');
		set_time_limit(90);
		// Gerando senha aleatória
		$basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $new_password= "";

        for($count= 0; 9 > $count; $count++){
            //Gera um caracter aleatório
            $new_password.= $basic[rand(0, strlen($basic) - 1)];
        }

		
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

		$data = $this->input->post(array('cnpj', 'email'), TRUE);
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('cnpj', 'CNPJ', 'required');

		if ($this->form_validation->run() == FALSE){

            $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Ops, um ou mais campos não foram preenchidos corretamente <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>' );
            redirect('recuperar-senha');
		
		}else{
			$userExist = $this->UserModel->userExist($data);
			
			// Se o usuário existir, envia o e-mail
			if($userExist){
				$this->email->initialize($config);
            	$this->email->from('miguel@iventocc.com',  'Giulia Domna - Lojista'); 
            
           		$this->email->to(''.$data['email']); 
            
            	$this->email->subject('Recuperação de senha');
            	$this->email->message($this->html);
     
            	if($this->email->send()){

					// Se o e-mail for enviado, a senha será atualizada no db
					$updatePass = $this->UserModel->updatePassword($new_password, $data['cnpj']);
					$this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">E-mail enviado com sucesso<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button></div>' );
					redirect('recuperar-senha');
            	}else{
					
					$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">E-mail não foi enviado, por favor tente novamente ou entre em contato: <a target="_blank" href="www.giuliadomna.com.br">giuliadomna/sac/contato</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button></div>' );
					redirect('recuperar-senha');
					}
			}else{
				$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Este e-mail ou CNPJ não se encontram em nosso cadastro <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button></div>' );
				redirect('recuperar-senha');
			}
		}
			
	}
		   
}
	

