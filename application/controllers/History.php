<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
{
    
  public function __construct()
  {
      parent::__construct();
      if(!$this->session->userdata('email')) {
        redirect('auth/login');
      }
  }

public function index(){
        
    $data['user'] = $this->db->get_where('user', ['email' => 
    $this->session->userdata('email')])->row_array();
   $t=1;
   $a=1;
   $b=1;
        $hasil= $this->db->get_where('reservasi',array('user_id'=>$this->session->userdata('userid')));
        $data ['t'] = $t;
        //print_r($hasil);
        $data ['a'] = $a;
        $data['b'] = $b;
        $data['hasil'] = $hasil;
        $leo= $this->db->get_where('pay_private',array('user_id'=>$this->session->userdata('userid')));
        $data['leo'] = $leo;
        $eva= $this->db->get_where('pay_trainer',array('user_id'=>$this->session->userdata('userid')));
        $data['eva'] = $eva;
        $this->load->view('auth/history',$data);
}

public function payment(){
  $data['user'] = $this->db->get_where('user', ['email' => 
    $this->session->userdata('email')])->row_array();
    $t=1;
    $a=1;
    $b=1;
        $hasil= $this->db->get_where('pembayaran',array('user_id'=>$this->session->userdata('userid')));
        $data ['t'] = $t;
        //print_r($hasil);
        $data['hasil'] = $hasil;
        $leo= $this->db->get_where('pay_private',array('user_id'=>$this->session->userdata('userid')));
        $data['leo'] = $leo;
        $data ['a'] = $a;
        $data['b'] = $b;
        $eva= $this->db->get_where('pay_trainer',array('user_id'=>$this->session->userdata('userid')));
        $data['eva'] = $eva;
  $this->load->view('auth/hispay',$data);
}


}