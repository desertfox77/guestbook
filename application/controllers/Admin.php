<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if(!$this->session->userdata('email')) {
            redirect('auth/login');
          }else {
            $eva = $this->db->get_where('user', ['email' => 
            $this->session->userdata('email')])->row_array();
            if($eva['role_id']==2) {
                redirect('Menu');
          }elseif ($eva['role_id']==3) {
            redirect('Partner');
          }
        }
    }
    

        public function index()
        {
            
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
       // $hasil=$this->db->query("SELECT * FROM reservasi");
    $this->form_validation->set_rules('code', 'Code', 'required|trim|min_length[8]');
        if($this->form_validation->run() ==false) {
            //echo 'auth/index';
            $this->load->view('admin/menuadmin',$data);
                } else {
                   
                    $this->_login();
    
            }
        }
    
    
        private function _login() {
            
            $code = $this->input->post('code');
            $admin = $this->db->get_where('reservasi',['code' => $code])->row_array();
            $privat = $this->db->get_where('pay_private',['code_reservation' => $code])->row_array();
            $trainer = $this->db->get_where('pay_trainer',['code_reservation' => $code])->row_array();
            //jika usernya ada
            if($admin){
                //jika user aktif
                if($code == $admin['code'] ){
                    $data = [
                        'code' => $admin['code'],
                        
                    ];
                    //$hasil=$this->db->query("SELECT FROM reservasi WHERE code=$t");
                   // $data['result'] =$hasil;
                    //cek password
                    $this->session->set_userdata($data);
                    $gemuk = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
                    $aku = $gemuk['role_id'];
                    if($aku==1) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Already generating Guestbook code!
              </div>'); 
              redirect('Admin');
                    }else{
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Succesful generating Guestbook code!
              </div>');
              
                redirect('Admin');
                    }
                    
                    }
         
            }elseif($privat){
                
                if($code == $privat['code_reservation'] ){
                $data = [
                    'kode' => $privat['code_reservation'],
                    
                ];
                //$hasil=$this->db->query("SELECT FROM reservasi WHERE code=$t");
               // $data['result'] =$hasil;
                //cek password
                $this->session->set_userdata($data);
                $apel = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
                $aku = $apel['role_id'];
                if($aku==1) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Already generating Private Class code!
          </div>'); 
          redirect('Admin');
                }else {

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Succesful generating Private class code!
          </div>');
            redirect('Admin');
                }
     }
    }elseif($trainer){
                
        if($code == $trainer['code_reservation'] ){
        $data = [
            'kodtrainer' => $trainer['code_reservation'],
            
        ];
        //$hasil=$this->db->query("SELECT FROM reservasi WHERE code=$t");
       // $data['result'] =$hasil;
        //cek password
        $this->session->set_userdata($data);
        $mangga = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
        $aku = $mangga['role_id'];
                if($aku==1) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Already generating Gym With Trainer code!
          </div>'); 
          redirect('Admin');
                }else {

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Succesful generating Gym With Trainer code!
            </div>');
            redirect('Admin');
                }
}
}else {
        echo'belum reservasi';
    }
        }
        public function clients(){
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
           
            $gemuk = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
            //$t= $gemuk['user_id'];
            //print_r($t);
             $apel = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
            $mangga = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
            
            $anton = [
                'id' => $gemuk['user_id'],
                'idprivat' => $apel['user_id'],
                'idtrainer' => $mangga['user_id']
            ];
            $this->session->set_userdata($anton);
            
           
            $leo= $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $eva= $this->db->get_where('user', ['id' => $this->session->userdata('idprivat')])->row_array();
            $ayaka= $this->db->get_where('user', ['id' => $this->session->userdata('idtrainer')])->row_array();
            $data['leo'] = $leo;
            $data['eva'] =$eva;
            $data['ayaka'] =$ayaka;
            $t=$gemuk['id'];
            $a=$apel['id'];
            $b=$mangga['id'];
            date_default_timezone_set("Asia/Jakarta");
    $date = date("h:i:sa");
    if($t)  {
        $ola = $this->db->query("UPDATE reservasi SET role_id=1, date_arrival = '$date'WHERE id =$t");
        $data['hasil'] = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
        $data['sheren'] = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
        $data['sherrile'] = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
        $this->load->view('admin/clients',$data, $anton, $ola);
    } elseif($a) {
        $ola = $this->db->query("UPDATE pay_private SET role_id=1, date_arrival = '$date'WHERE id =$a");
        $data['hasil'] = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
        $data['sheren'] = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
        $data['sherrile'] = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
        $this->load->view('admin/clients',$data, $anton, $ola);
    } elseif($b) {
        $ola = $this->db->query("UPDATE pay_trainer SET role_id=1, date_arrival = '$date'WHERE id =$b");
        $data['hasil'] = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
        $data['sheren'] = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
        $data['sherrile'] = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
           
        $this->load->view('admin/clients',$data, $anton, $ola);
    }else {
        $data['hasil'] = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
        $data['sheren'] = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
        $data['sherrile'] = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
        $this->load->view('admin/clients',$data, $anton);

    }
    
            
            
            // $deng = $this->db->query("UPDATE reservasi SET role_id=1, date_arrival = '$date'WHERE id =$a");
            // $poi = $this->db->query("UPDATE reservasi SET role_id=1, date_arrival = '$date'WHERE id =$b");
        }
        
        public function clear(){
            $this->session->unset_userdata('code');
            $this->session->unset_userdata('kode');
            $this->session->unset_userdata('kodtrainer');
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['hasil'] = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
            $gemuk = $this->db->get_where('reservasi', ['code' => $this->session->userdata('code')])->row_array();
            //$t= $gemuk['user_id'];
            //print_r($t);
            $data['sheren'] = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
            $apel = $this->db->get_where('pay_private', ['code_reservation' => $this->session->userdata('kode')])->row_array();
            $data['sherrile'] = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
            $mangga = $this->db->get_where('pay_trainer', ['code_reservation' => $this->session->userdata('kodtrainer')])->row_array();
            
            $anton = [
                'id' => $gemuk['user_id'],
                'idprivat' => $apel['user_id'],
                'idtrainer' => $mangga['user_id']
            ];
            $this->session->set_userdata($anton);
            
           
            $leo= $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $eva= $this->db->get_where('user', ['id' => $this->session->userdata('idprivat')])->row_array();
            $ayaka= $this->db->get_where('user', ['id' => $this->session->userdata('idtrainer')])->row_array();
            $data['leo'] = $leo;
            $data['eva'] =$eva;
            $data['ayaka'] =$ayaka;
        
            $this->load->view('admin/clients',$data);
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

}