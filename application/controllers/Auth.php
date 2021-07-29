<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        
    $this->load->view('auth/login');
    
    
    }


public function login(){
//echo 'leo gendut';
 $this->form_validation->set_rules('email','Email','trim|required|valid_email');
       $this->form_validation->set_rules('password','Password','trim|required');
       
         if($this->form_validation->run() ==false) {
    //echo 'auth/index';
    
    $this->load->view('auth/login');
    
        } else {
            $this->_login();

}

    }

    private function _login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user',['email' => $email])->row_array();
        

        //jika usernya ada
        if($user){
            //jika user aktif
            if($user['is_active'] == 1 ){
                //cek password
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'userid' => $user['id'],
                        'payid' =>$user['pay_id']
                    ];
                    $this->session->set_userdata($data);
                    if($user ['role_id'] == 1) {
                        redirect('Admin');
                    }else {
                        redirect('Menu');
                    }
                    

                }else {$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password!
                  </div>');
                    redirect('auth/login');
                    

                }

            }else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            This email has not been activated!
          </div>');
            redirect('auth/login');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!
          </div>');
            redirect('auth/login');
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim' );
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]',
    [
        'is_unique' => 'This email has already registered!']
    );
        // $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^[0-9]{12}$/]',[
        //     'regex_match' => 'Minimum 12 Characters Phonenumber!'
            
    
        // ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]',
    [
        'matches' => 'Password dont match!',
        'min_length' => 'Password too short!'

    ] );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]' );

        if($this->form_validation->run() == false) {


            $this->load->view('templates/auth_header');
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');

        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                // 'image' =>'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' =>2,
                'is_active' =>0,
                'date_created' => time(),
               // 'phone_number' => $this->input->post('phone', true)

            ];
            //siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Account has been created!
          </div>');
            redirect('auth/login');

        }
        //echo 'auth/index';
        


    }

private function _sendEmail($token, $type){

    $config = [
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_user' => 'cs.gofitid@gmail.com',
        'smtp_pass' => 'deustcher2',
        'smtp_port' => 465,
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"

    ];

    $this->email->initialize($config);

    $this->load->library('email', $config);
    $this->email->from('cs.gofitid@gmail.com', 'Contact Support');
    $this->email->to($this->input->post('email'));

    if($type == 'verify') {

        $this->email->subject('Account Verification');
        $this->email->message('Click this link to verify your account : 
            <a href="'.base_url() .'auth/verify?email=' . $this->input->post('email') . 
            '&token='. urlencode($token) . '">Activate</a>');
    }else if($type == 'forgot'){
        $this->email->subject('Reset Password');
        $this->email->message('Click this link to reset your password : 
            <a href="'.base_url() .'auth/reset?email=' . $this->input->post('email') . 
            '&token='. urlencode($token) . '">Activate</a>');
    }

    if($this->email->send()) {
        return true;
    }else {
       echo $this->email->print_debugger();
        die;
    }
}

public function verify(){
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' =>$email]) ->row_array();

    if($user) {
        $user_token = $this->db->get_where('user_token', ['token' =>$token])->row_array();
        if($user_token) {
                if(time() - $user_token['date_created'] < (60 * 60 * 24)){
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' =>$email]);

                    
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Account has been Activated! Please Login.
                </div>');
                redirect('auth/login');

                }else {

                    $this->db->delete('user', ['email' =>$email]);
                    $this->db->delete('user_token', ['email' =>$email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Account activation failed! Token already expired!
                   </div>');
                     redirect('auth/login');

                }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Account activation failed! Wrong Token!
      </div>');
        redirect('auth/login');
        }


    }else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Account activation failed! Wrong Email!
      </div>');
        redirect('auth/login');
    }
}

public function forgot(){

    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    if($this->form_validation->run() == false) {

        $this->load->view('auth/forgot');
        $this->load->view('templates/auth_footer');
    }else {
        $email = $this->input->post('email');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if($user) {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'forgot');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Please check your email to reset your password!
           </div>');
             redirect('auth/forgot');



        }else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!
           </div>');
             redirect('auth/forgot');
        }
    }
}

public function reset(){
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' =>$email]) ->row_array();

    if($user) {
        
        $user_token = $this->db->get_where('user_token', ['token' =>$token])->row_array();
        if($user_token) {

            $this->session->set_userdata('reset_email', $email);
            $this->changePassword();
            
        }else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Reset Password Failed! Wrong Token!
           </div>');
             redirect('auth/login');
        }
    }else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Reset Password Failed! Wrong Email!
       </div>');
         redirect('auth/login');
    }
}

public function changePassword () {

    if(!$this->session->userdata('reset_email')) {
        redirect('auth');
    }

    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[8]|matches[password1]');
    
    if($this->form_validation->run() == false) {

        $this->load->view('auth/changepassword');
        $this->load->view('templates/auth_footer');
    }else {
        $password =  password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
        $email = $this->session->userdata('reset_email');

        $this->db->set('password', $password);
        $this->db->where('email', $email);
        $this->db->update('user');

        $this->session->unset_userdata('reset_email');

        
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Password has been changed!
  </div>');
    redirect('auth/login');
    }
}

}