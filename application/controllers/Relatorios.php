<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
class Relatorios extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('relatoriosModel');
        $this->load->model('AdminModel');
    }

    public function index(){
        if($filter = $this->input->get()){
            $data['resultado'] = $this->relatoriosModel->solicitacoes($filter['inicio'],$filter['fim'], $filter['tipo']);      
        }
        
        $count = 0;    
        $this->load->template('relatorios/RelatoriosView');
    }

    public function createPdf(){

        $folder = './uploads/admin/';
        
        $this->deleteFilesOfFolder($folder);

        $this->load->library('m_pdf');
        $filename = time()."_relatorio.pdf";


        $fields = $this->input->get();

        if($fields['tipo'] == 'referencia'){
            $data['data'] = $this->relatoriosModel->buscarPelaReferencia($fields['inicio'], $fields['fim']);
            foreach($data['data'] as $referencia){
               
                $idsDaReferencia = $this->relatoriosModel->buscarIdsPelaReferencia($fields['inicio'], $fields['fim'], $referencia->referencia);

                $referencia->ids = $idsDaReferencia;
            }
            
            $html = $this->load->view('pdf/default_pdf',$data,true);
        }else if($fields['tipo'] == 'lojista'){
            $data['data'] = $this->relatoriosModel->buscarPeloLojista($fields['inicio'], $fields['fim'], $fields['lojistas']);
           $html =  $this->load->view('pdf/default_lojista_pdf',$data,true);
            
        }else if($fields['tipo'] == 'problemas'){
            $data['data'] = $this->relatoriosModel->buscarPorProblema($fields['inicio'], $fields['fim']);
            $this->load->view('pdf/default_lojista_simples_pdf',$data,true);
            
        }
        // $this->load->library('M_pdf');
 
        $this->generatePdf($html, $filename);
        // $this->m_pdf->pdf->WriteHTML($html);

        // $this->m_pdf->pdf->Output("./uploads/admin/".$filename, "F");

        redirect(base_url().'uploads/admin/'.$filename);

        
     
    }

    private function deleteFilesOfFolder($folder){

        $files = glob($folder . '/*');
 
        foreach($files as $file){
 
            if(is_file($file)){
     
            unlink($file);
            }
        }

    }

    private function generatePdf($html, $filename){

        $this->load->library('M_pdf');
 
        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output("./uploads/admin/".$filename, "F");

    }
    public function getResultFromReport(){
        if($filter = $this->input->get()){
            $data['resultado'] = $this->relatoriosModel->solicitacoes($filter['inicio'],$filter['fim'], $filter['tipo']);
            

            $countOpen = 0;
            $countReview = 0;
            $countClose = 0;
            $count = [];
            foreach ($data['resultado'] as $key => $value){ 
                if ($value->id_status_solicitacao == 1){ 
                   $count['open'] = $countOpen++; 
                }else if ($value->id_status_solicitacao == 2){ 
                    $count['review'] = $countReview++;
                }else if ($value->id_status_solicitacao == 3){ 
                    $count['close'] = $countClose++; 
                }
                print_r($value);
                
            }
            $count['total'] = $countOpen + $countReview + $countClose;
            print_r($countReview);
            print_r(json_encode($count));
           
        }

    }

    public function listLojista(){

        $data['lojistas'] = $this->AdminModel->getLojistas();

        print_r(json_encode($data['lojistas']));


    }

}

    