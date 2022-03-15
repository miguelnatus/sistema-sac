<?php

function dateFormat($data_value){
    
    $date = new DateTime($data_value);
    return $date->format("d/m/Y H:i:s");
}

function statusToCssClass($status){
    $status = preg_replace(array("/(á|à|ã|â|ä)/","/(é|è|ê|ë)/","/(í|ì|î|ï)/","/(ó|ò|õ|ô|ö)/","/(ú|ù|û|ü)/","/(ñ)/","/(ç)/"),explode(" ","a e i o u n c"),$status);
    $css_class = str_replace(" ","_",strtolower($status));

    return $css_class;
}

function urlTypeUser(){
    $ci =& get_instance();

    $type_user = $ci->session->userdata("funcao");
    $url_user = $type_user == "user" ? base_url()."user/" : base_url()."admin/";

    return $url_user;
}

function getNotification(){

    $ci =& get_instance();
	return $ci->load->UserModel->getLogs($ci->session->userdata('id'), $ci->session->userdata('funcao'));


}
