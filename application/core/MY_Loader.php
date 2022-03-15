<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
    
    public function template($view,$data = [],$stage = "dashboard"){

        if(!empty($data['page'])){
            if( $data['page'] == "home" ){
                $this->view("primaryHeaderView",$data);
            }
        }
        else if($stage == "dashboard"){
            $this->view("headerView",$data);
        }
        
        $this->view($view);
        $this->view("footerView");
    }

}