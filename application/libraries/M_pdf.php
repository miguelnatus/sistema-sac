<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 
include('mpdf/mpdf.php');
 
class M_pdf {
 
    public $param;
    public $pdf;
    public function __construct($param = "'c', 'A4-L'"){
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
}   
}