<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Auth
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('trash_id_user')) {
            redirect('dashboard');
        }else{
            redirect('login');
        }
        
    }
    public function base($page = 'login')
    {
        if ($this->session->userdata('trash_id_user')) {
            redirect('dashboard');
        }
        // GLOBAL VARIABEL
        $this->data['title'] = 'Landing';
        $mydata['page'] = $page;

        // LOAD JS
        // $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/auth/login.js"></script>';


        // LOAD VIEW
        $this->data['content'] = $this->load->view('index', $mydata, TRUE);
        $this->display();
    }

    public function logout()
    {
        $this->session->unset_userdata('trash_id_user');
        $this->session->unset_userdata('trash_nama');
        $this->session->unset_userdata('trash_id_role');
        $this->session->unset_userdata('trash_role');
        $this->session->unset_userdata('trash_email');

        redirect('login');
    }
}
