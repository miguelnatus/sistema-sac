<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitacao extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->verifyLogin();
        $this->load->model("ModelSolicitacoes");
        $this->load->model("ModelMensagem");
    }

    public function index()
    {

        $this->load->template("user/registerSolicitacaoView");

    }

    public function register()
    {

        $id_user = $this->session->userdata("id");
        $dir_image = getcwd() . "/uploads/" . $id_user . "/";

        if (!is_dir($dir_image)) {
            mkdir($dir_image, 0777, true);
        }

        $config = array(
            'upload_path' => $dir_image,
            'allowed_types' => "png|jpg|jpeg",
            'overwrite' => TRUE,
            'max_size' => 4048
        );
        $this->load->library('upload', $config);

        $data = $this->input->post();

        /**
         * ------------------------------------------
         *
         * Regras para validação de formulário
         *
         * ------------------------------------------
         */
        $count = 0;
        $file_validated = TRUE;

        foreach ($data["itens"] as $key => $item) {

            $this->form_validation->set_rules('itens[' . $key . '][referencia]', 'Referência', 'required|min_length[10]');
            $this->form_validation->set_rules('itens[' . $key . '][quantidade]', 'Quantidade', 'required');
            $this->form_validation->set_rules('itens[' . $key . '][descricao]', 'Descrição', 'required');

            foreach ($_FILES["itens"]["name"][$key] as $key_ => $file) {
                $data_["images"][$key][$key_] = array();

                $_FILES["file"]["name"] = $_FILES["itens"]["name"][$key][$count];
                $_FILES["file"]["type"] = $_FILES["itens"]["type"][$key][$count];
                $_FILES["file"]["tmp_name"] = $_FILES["itens"]["tmp_name"][$key][$count];
                $_FILES["file"]["error"] = $_FILES["itens"]["error"][$key][$count];
                $_FILES["file"]["size"] = $_FILES["itens"]["size"][$key][$count];

                if (!$this->upload->do_upload('file')) {
                    $file_validated = FALSE;
                    $this->session->set_flashdata('error_image', '<p class="alert alert-danger alert-dismissible fade show" role="alert">Erro ao cadastrar solicitação: Insira todas as imagens do produto.</br> Tamanho máximo de 4 MB por Imagem.</p>');
                }

                $count++;
            }

            $count = 0;

        }
        $this->form_validation->set_error_delimiters('<p class="alert alert-danger alert-dismissible fade show" role="alert">', '</p>');

        if ($this->form_validation->run() == FALSE || $file_validated == FALSE) {

            $data_["forms"] = $data["itens"];

            $this->session->set_flashdata('error', '<p class="alert alert-danger alert-dismissible fade show" role="alert">Erro ao cadastrar solicitação: Alguns campos não foram preenchidos.</p>');
            $this->load->template("user/registerSolicitacaoView", $data_);

        } else {

            $fields_solitacoes = array(
                "id_usuario" => $id_user,
            );
            $id_new_solicitacao = $this->ModelSolicitacoes->insert("solicitacoes", $fields_solitacoes);

            foreach ($data["itens"] as $key => $item) {

                $fields_item = array(
                    "referencia" => $item["referencia"],
                    "quantidade" => $item["quantidade"],
                    "descricao" => $item["descricao"]
                );
                $id_new_item = $this->ModelSolicitacoes->insert("itens", $fields_item);

                $fields_solitacoes_itens = array(
                    "id_item" => $id_new_item,
                    "id_solicitacao" => $id_new_solicitacao
                );
                $this->ModelSolicitacoes->insert("solicitacoes_itens", $fields_solitacoes_itens);

                foreach ($_FILES["itens"]["name"][$key] as $path) {
                    $foto = str_replace(" ", "_", $path);
                    $fotoExtension = pathinfo($foto);
                    $fotoExtension = $fotoExtension['extension'];
                    $fotoNoExtension = pathinfo($foto, PATHINFO_FILENAME);
                    $fotoNoExtension = str_replace(".", "_", $fotoNoExtension);
                    $foto = $fotoNoExtension.'.'.$fotoExtension;

                    $path_image = base_url() . "uploads/" . $id_user . "/" . $foto;
                    $fields_fotos = array(
                        "url" => $path_image,
                        "id_item" => $id_new_item
                    );

                    $this->ModelSolicitacoes->insert("fotos", $fields_fotos);
                }
            }

            $fields_solitacoes_atualizacoes = array(
                "id_solicitacao" => $id_new_solicitacao
            );
            $this->ModelSolicitacoes->insert("solicitacoes_atualizacoes", $fields_solitacoes_atualizacoes);

            $this->sendNotification($id_new_solicitacao, 'nova Solicitação');
            $this->ModelSolicitacoes->log($id_user, $id_new_solicitacao, '"Nova Solicitação"');

            $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissible fade show" role="alert">Solicitação cadastrada com sucesso! Entraremos em contato em até 48h<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button></div>');
            redirect("user/painel");

        }

    }

    public function update()
    {

        $data = $this->input->post();

        $id_usuario = $this->session->userdata("id");

        $id_solicitacao = $data["id_solicitacao"];
        $status_itens = array();

        foreach ($data["itens"] as $key => $item) {
            $id_item = $item["id_item"];

            $fields_solicitacoes_itens = array(
                "id_tipo_problema" => $item["id_tipo_problema"],
                "id_status" => $item["id_status"]
            );
            $fields_itens = array(
                "referencia" => $item["referencia"],
                "quantidade" => $item["quantidade"],
                "descricao" => $item["descricao"]
            );

            $this->ModelSolicitacoes->update($id_item, $fields_solicitacoes_itens, "solicitacoes_itens");
            $this->ModelSolicitacoes->update($id_item, $fields_itens, "itens");

            $nome_status = $this->ModelSolicitacoes->status("id", $item["id_status"]);

            array_push($status_itens, $nome_status[0]->nome);
        }

        $fields_solicitacoes = array(
            "id_status_solicitacao" => $data['statusSolicitacao'],
        );
        $this->ModelSolicitacoes->update($id_solicitacao, $fields_solicitacoes, "solicitacoes", $id_solicitacao);

        $this->ModelSolicitacoes->log($id_usuario, $id_solicitacao, '"Status Atualizado"');

        $this->session->set_flashdata('success', '<p class="alert alert-success fade show" role="alert">Os dados da solicitação foram atualizados com sucesso!</p>');
        $this->solicitacaoDetalhe($id_solicitacao);

    }


    public function solicitacaoDetalhe($id_solicitacao)
    {

        $this->load->model("UserModel");
        $this->load->model("ModelMensagem");
        $this->load->library('upload');


        $funcao = $this->session->userdata('funcao');
        $data['user_id'] = $this->session->userdata('id');
        $data['user'] = $this->UserModel->usuarios($data['user_id']);
        $data['id_solicitacao'] = $id_solicitacao;
        $data['solicitacoesItens'] = $this->ModelSolicitacoes->solicitacoesItens($id_solicitacao);
        $data['status_solicitacao'] = $this->ModelSolicitacoes->status("id", $data['solicitacoesItens'][0]->id_status_solicitacao, "status_solicitacao");
        $data['data_atualizacao'] = $this->ModelSolicitacoes->atualizacoesSolicitacao($id_solicitacao)->data_atualizacao;
        $data['solicitacaoStatus'] = $this->ModelSolicitacoes->status("id", $id_solicitacao, 'solicitacoes');

        $data['fotos'] = array();


        foreach ($data['solicitacoesItens'] as $item) {
            $fotos = $this->ModelSolicitacoes->mostrarFotos($item->id_item);
            array_push($data['fotos'], $fotos);
        }

        $data['notas'] = $this->ModelSolicitacoes->mostrarNotas($id_solicitacao);
        $data['status'] = $this->ModelSolicitacoes->status();
        $data['tipoProblema'] = $this->ModelSolicitacoes->tipoProblema();
        $data['mensagens'] = $this->ModelMensagem->mensagens($id_solicitacao);
        $data['listaStatusSolicitacao'] = $this->ModelSolicitacoes->listaStatusSolicitacao($id_solicitacao);

        //Limpar notificações GERAL 
        if ($funcao == 'user') {
            $this->ModelSolicitacoes->deleteLogs($data['user_id'], $id_solicitacao, 'admin', 'operador');
        } else {
            $this->ModelSolicitacoes->deleteLogs($data['user_id'], $id_solicitacao);
        }


        $this->load->template('solicitacaoView', $data);
    }

    public function cadastrarNota()
    {
        $this->load->library('form_validation');
        $this->load->library('upload');

        $data['user_id'] = $this->session->userdata('id');
        $numeroNota = $this->input->post('numero-nota-1');
        $arquivoNota = $this->input->post('arquivo-nota-1');

        $id_solicitacao = $this->input->post('id-solicitacao');

        if (!is_dir('uploads/' . $data['user_id'])) {
            mkdir('uploads/' . $data['user_id'], 0777, TRUE);
        }

        $config['upload_path'] = 'uploads/' . $data['user_id'];
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 3000;
        // $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        $this->upload->initialize($config);


        if (!$this->upload->do_upload('arquivo-nota-1')) {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('message', 'Ocorreu um erro..');
            redirect('painel/solicitacao/' . $id_solicitacao);

            // $this->load->view('upload_form',);
            $this->load->template('dashboardView', $error);
        } else {


            $data = array('upload_data' => $this->upload->data());

            $data['user_id'] = $this->session->userdata('id');
            $data['nota'] = $numeroNota;
            $data['id_solicitacao'] = $id_solicitacao;
            $data['url'] = base_url('uploads/') . $data['user_id'] . '/' . $data['upload_data']['file_name'];

            //print_r($data);
            $this->ModelSolicitacoes->cadastroNotas($data);

            $this->sendNotification($id_solicitacao, 'Nota Fiscal cadastrada');

            $this->session->set_flashdata('message', 'Nota cadastrada com sucesso..');
            redirect(urlTypeUser() . 'solicitacao/' . $id_solicitacao);

        }

    }

    public function excluirNota($id_solicitacao, $id_nota)
    {
        $this->ModelSolicitacoes->deletarNota($id_nota);
        redirect(urlTypeUser() . 'solicitacao/' . $id_solicitacao);
    }

    public function enviarMensagem()
    {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('directory');
        $this->load->library('upload');


        $data['anexo'] = $this->input->post('anexo-msg');


        $data['user_id'] = $this->session->userdata('id');
        $data['id_solicitacao'] = $this->input->post('id_solicitacao');
        $data['mensagem'] = $this->input->post('nova-mensagem');
        $this->form_validation->set_rules('nova-mensagem', 'Nova-mensagem', 'required');
        if ($this->form_validation->run() == FALSE) {
            //echo '<script>alert("errooouuu")</script>';
            $this->session->set_flashdata('error', 'preencha o campo');
            redirect(urlTypeUser() . 'solicitacao/' . $data['id_solicitacao'] . '#mensagens');
        } else {
            // $this->session->set_flashdata('succ', 'preencha o campo');
            // redirect(urlTypeUser().'solicitacao/'.$data['id_solicitacao'].'#mensagens');
        }

        if (!is_dir('uploads/' . $data['user_id'])) {
            mkdir('uploads/' . $data['user_id'], 0777, TRUE);
        }


        $config['upload_path'] = 'uploads/' . $data['user_id'];
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 3000;
        // $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        //print_r($config);


        if (!$this->upload->do_upload('anexo-msg')) {
            $error = array('error' => $this->upload->display_errors());

            //$this->session->set_flashdata('error', 'Ocorreu um erro..');
            // redirect('solicitacao/'.$data['id_solicitacao']);
            //print_r($error);
            // $this->load->view('upload_form',);
            // $this->load->template('dashboardView', $error);
        } else {


            $data_ = array('upload_data' => $this->upload->data());

            $data_['user_id'] = $this->session->userdata('id');

            // $data_['id_solicitacao'] = $id_solicitacao; 
            $data_['url'] = base_url('uploads/') . $data_['user_id'] . '/' . $data_['upload_data']['file_name'];
            $data['url'] = $data_['url'];
            //print_r($data);

        }

        $returnMessage = $this->ModelMensagem->adicionar($data);

        if ($this->session->userdata('funcao') == 'user') {
            $this->sendNotification($data['id_solicitacao'], 'Mensagem na solicitação');
        }

        if ($returnMessage < 1) {
            $this->session->set_flashdata('error', 'Ocorreu um erro..');
            redirect(urlTypeUser() . 'solicitacao/' . $data['id_solicitacao'] . '#mensagens');
        } else {
            $this->ModelSolicitacoes->log($data['user_id'], $data['id_solicitacao'], '"Nova Mensagem"');
            $this->session->set_flashdata('success', 'enviado com sucesso!');
            redirect(urlTypeUser() . 'solicitacao/' . $data['id_solicitacao'] . '#mensagens');
        }


    }

    private function getSolicitacaoStatus($statusItens)
    {

        if (in_array("Em análise", $statusItens) && (in_array("Improcedente", $statusItens) || in_array("Conserto", $statusItens) || in_array("Devolução", $statusItens))) {
            $nome_status_solicitacao = "Parcial";
        } else if (in_array("Aberto", $statusItens) && !(in_array("Improcedente", $statusItens) || in_array("Conserto", $statusItens) || in_array("Devolução", $statusItens) || in_array("Em análise", $statusItens))) {
            $nome_status_solicitacao = "Aberto";
        } else if (!in_array("Em análise", $statusItens) && (in_array("Improcedente", $statusItens) || in_array("Conserto", $statusItens) || in_array("Devolução", $statusItens))) {
            $nome_status_solicitacao = "Finalizado";
        } else {
            $nome_status_solicitacao = "Em Análise";
        }

        $status_solicitacao = $this->ModelSolicitacoes->status("nome", $nome_status_solicitacao, "status_solicitacao");

        return $status_solicitacao[0];

    }
}
