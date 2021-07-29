<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Confirmation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('email')) {
          redirect('auth/login');
        }else {
          
          $eva = $this->db->get_where('user', ['email' => 
      $this->session->userdata('email')])->row_array();
      if($eva['pay_id']==0) {redirect('Menu');
      }elseif( $eva['pay_id']==1){
        redirect('Payment');
      }elseif( $eva['pay_id']==3){
        redirect('Paypriva');
      }else {
  
      }
  
           }
  
    }
    public function index(){
        $user =$this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();
      $t=$user['id'];
    $ola = $this->db->query("UPDATE user SET pay_id=0 WHERE id=$t");
        $this->load->view('auth/confirmation');
    }
}  
