<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('email')) {
      redirect('auth/login');
    }
  }
  public function index()
  {
    //$data['title'] ='My Profile';
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    $data['userid'] = $this->session->userdata('userid');
    // echo'selamat datang ' . $data['user']['name'];
    
    $this->load->view('auth/menu', $data);
  }

  public function add()
  {
   

   
      $date = $this->input->post('date');
      $new_date = date('Y-m-d H:i:s', strtotime($date));
        $data = [
            'namaPengirim' => htmlspecialchars($this->input->post('shop_name', true)),
            'tulisanPengirim' => htmlspecialchars($this->input->post('shop_location', true)),
            'alamatPengirim' => htmlspecialchars($this->input->post('shop_leo', true)),
            'date' => $new_date,
            'user_id' => $this->session->userdata('userid')
        ];

        $this->db->insert('addmessage', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Location has been added!
      </div>');
        redirect('Menu');
   

  }

  public function logout()
  {

    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');



    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Logout success!
      </div>');
    redirect('auth/login');
  }


  public function profile()
  {
    $data['title'] = 'My Profile';
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();
    // echo'selamat datang ' . $data['user']['name'];
    // this->db->query("select*from where kode= ")
    $this->load->view('auth/myprof', $data);
  }

  public function list(){
    $data['user'] = $this->db->get_where('user', ['email' => 
    $this->session->userdata('email')])->row_array();
    $user =$this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();
        $t=$user['id'];
        $a=1;
        $data ['a'] = $a;
        
    $hasil = $this->db->query("SELECT * FROM addmessage WHERE user_id='$t'"); 
    $data['hasil'] = $hasil;
    //print_r($hasil);
   $this->load->view('auth/list', $data);
}

}
