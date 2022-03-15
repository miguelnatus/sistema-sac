<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $path_csv = "https://docs.google.com/spreadsheets/d/e/2PACX-1vRvbMaPO5utdEKrryQuVTRc2hefyw6OPXcf0UyvHk3W_YOviL9-8H5dqCnzPfupCvTgI4Q0vB2K2oPa/pub?gid=0&single=true&output=csv";

	public function __construct() {
		
		parent::__construct();


		$this->load->library("session");

		$this->verifyLogin();

       
	}



	



	protected function verifyCnpj($data){
		
		/* Atualiza JSON que contém dados de precadastro da Planilha

        	$responseDocs = curl_init("http://localhost/giuliadomna/giuliadomna-sac/update/pre-cadastro");
        	curl_setopt($responseDocs, CURLOPT_RETURNTRANSFER, TRUE);
        	curl_exec($responseDocs);
			curl_close($responseDocs);
		*/

		$this->load->library("csv");
		
		// Consulta planilha do Docs e retorna dados em um array
		// $path_csv = "https://docs.google.com/spreadsheets/d/e/2PACX-1vRvbMaPO5utdEKrryQuVTRc2hefyw6OPXcf0UyvHk3W_YOviL9-8H5dqCnzPfupCvTgI4Q0vB2K2oPa/pub?gid=0&single=true&output=csv";
		$path_csv = base_url()."pre-cadastro.csv";
        $this->csv->setCsv($path_csv);
  		$precadastro = $this->csv->getCsvData();
	   
		// Se encontrar o cnpj nos dados da planilha, ele retornará true
		
		$value = $data['cnpj']; 
		$column = 'cnpj';
        	foreach ($precadastro as $val) {
                if ($val[$column] == $value) {
					$result = $val;
					return $result;
                }else{
					
				}
			}
			
	}

	protected function verifyLogin(){
		$usuario = $this->session->userdata();
		$route = $this->uri->segment(1, 'home');

		if(!empty($usuario['id']) && $route == 'home'){
			if($usuario['funcao'] != 'user'){
				return redirect('admin/painel');	
			}else{
				return redirect('user/painel');	
			}
		
		}
		if(empty($usuario['id']) && ($route == 'admin' || $route == 'user')){
			$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Efetue o login para entrar no sistema<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button></div>');
			return redirect('');	
		}else{
			if($route != 'admin' && $route != 'user'){
				
			}else{

				if( $usuario['funcao'] == 'user'){
					if( $route == 'admin'){
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Você não tem permissão para acessar a página anterior<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button></div>');
						return redirect('user/painel');
					}else{
						//Prosseguir
						return;
					}	
				}else{
					if( $route == 'user'){
						$this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Você não tem permissão para acessar a página anterior<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button></div>');
						return redirect('admin/painel');
					}else{
						//Prosseguir
						return;
					}

				}
			}
		}

	}

	protected function profile(){
		$id = $this->session->userdata('id');
		$resultado = $this->UserModel->getProfile($id);
		return $resultado;


	}

	public function sendNotification($id_solicitacao, $subject = 'Atualização'){

		/* 
		*	Montando e configurando email 
		*/

		$this->html = '
			<table> 
                <tr>
                	<td>Você tem uma <strong>'.$subject.'</strong> #'.$id_solicitacao.', clique no botão para conferir:</td>
            	</tr>
            	
				<tr style="width: 100%" align="center" cellpadding="0" cellspacing="0">
				<a href="'.base_url().'admin/solicitacao/'.$id_solicitacao.'"style="font-family:Arial,sans-serif;font-size:15px;line-height:.6em;color:#fff;text-decoration:none;display:inline-block;vertical-align:middle; text-align:center;zoom:1;width:250px;max-width:100%;text-transform:uppercase;white-space:nowrap;background-color:#6c757d;border-radius:10px;outline:none;padding:14px 0px;border:0" target="_blank" >Acessar Solicitação</a>
				</tr>
				
				
				
			</table>';
			$config['useragent']        = 'Codeigniter';
			$config['protocol']         = 'smtp';
			$config['smtp_host']        = 'smtp.sinoscorp.com.br';
			$config['smtp_user']        = 'site@giuliadomna.com.br';
			$config['smtp_pass']        = 'mailG4i4l518.';
			$config['smtp_port']        = 587;
			$config['smtp_timeout']     = 10;
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
	
			$this->email->initialize($config);
			$this->email->from('site@giuliadomna.com.br',  'Giulia Domna - Administrador'); 
				
			$this->email->to('devolucao@giuliadomna.com.br'); 
            
        $this->email->subject('Nova Notificação do Sistema #'.$id_solicitacao);
		$this->email->message($this->html);

		$this->email->send();
		
	}

}