<?php

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $id = $this->session->userdata('id');
        if(empty($id)) {
            $this->session->sess_destroy();
            redirect('home');
        } else {
            $data['judul'] = 'Halaman Akun';
            $data['css'] = 'produk_style.css';
            $data['is_login'] = TRUE;
            $this->load->view('templates/header', $data);
            $this->load->view('akun/index');
            $this->load->view('templates/footer');
        }
    }

    public function keranjang()
    {
        $id = $this->session->userdata('id');
        if(empty($id)) {
            $this->session->sess_destroy();
            redirect('home');
        } else {
            $data['judul'] = 'Halaman Keranjang';
            $data['css'] = 'produk_style.css';
            $data['is_login'] = TRUE;
            $data['keranjang'] = $this->User_model->getKeranjang($id);
            $this->load->view('templates/header', $data);
            $this->load->view('keranjang/index');
            $this->load->view('templates/footer');
        }
    }

    public function login()
    {
        $id = $this->session->userdata('id');
        if(!empty($id)) {
            redirect('home');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if($this->form_validation->run() == FALSE) {
                $this->load->view('login/index');
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $this->User_model->login($email, $password);
            }
        }
    }

    public function register()
    {
        $id = $this->session->userdata('id');
        if(!empty($id)) {
            redirect('home');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
            if($this->form_validation->run() == FALSE) {
                $this->load->view('register/index');
            } else {
                $this->User_model->register();
            }
        }
    }

    public function checkout()
    {
        $id = $this->session->userdata('id');
        if(empty($id)) {
            $this->session->sess_destroy();
            redirect('home');
        } else {
            $this->User_model->checkout();
        }
    }

    public function logout()
    {
        $this->session->set_userdata('email', FALSE);
        $this->session->sess_destroy();
        redirect('home');
    }

}