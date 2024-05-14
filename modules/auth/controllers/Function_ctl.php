<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Auth
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
    }

    public function login()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $email = strtolower($email);
        if (!$_POST) {
            redirect('login');
        }
        if (!$email || !$password) {
            $data['status'] = 700;
            $data['message'] = 'Tidak ada data terdeteksi! Silahkan cek dan coba lagi.';
            echo json_encode($data);
            exit;
        }
        if (!validasi_email($email)) {
            $data['status'] = 700;
            $data['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
            echo json_encode($data);
            exit;
        }

        $result = $this->action_m->get_single('user', ['email' => $email]);
        if ($result) {
            if ($result->status == 'N') {
                if ($result->block_reason) {
                    $reason = ' dengan alasan </br></br><b>' . $result->block_reason . '!</b></br></br>';
                } else {
                    $reason = '!';
                }
                $data['status'] = 700;
                $data['message'] = 'Anda telah di blockir' . $reason . ' Anda tidak bisa melakukan akses pada sistem. Hubungi admin jika terjadi kesalahan';
                echo json_encode($data);
                exit;
            }
            if ($result->password == hash_my_password($email . $password)) {

                $arrSession['trash_id_user'] = $result->id_user;
                $arrSession['trash_nama'] = $result->nama;
                $arrSession['trash_email'] = $result->email;
                $arrSession['trash_id_role'] = $result->role;
                $arrSession['trash_role'] = get_role($result->role);

                $this->session->set_userdata($arrSession);

                $data['status'] = 200;
                $data['message'] = 'Data sesuai! Selamat datang ' . get_role($result->role) . ' ' . $result->nama;
                $data['redirect'] = base_url('dashboard');
               
            } else {
                $data['status'] = 500;
                $data['message'] = 'Kata sandi salah! Silahkan cek dan coba lagi.';
            }
        } else {
            $data['status'] = 500;
            $data['message'] = 'Email tidak terdaftar! Silahkan cek dan coba lagi.';
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function register()
    {
        $nama      = $this->input->post('nama');
        $email      = $this->input->post('email');
        $email      = strtolower($email);
        $password   = $this->input->post('password');
        $repassword   = $this->input->post('repassword');

        // PERIKSA URL
        if (!$_POST) {
            redirect('login');
        }
        // PERIKSA INPUT
        if (!$email || !$nama || !$password || !$repassword) {
            $data['status'] = 500;
            $data['message'] = 'Data tidak terdeteksi! Silahkan cek ulang data yang anda masukan';
            echo json_encode($data);
            exit;
        }
        if (!validasi_email($email)) {
            $data['status'] = 700;
            $data['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
            echo json_encode($data);
            exit;
        }
        if ($password != $repassword) {
            $data['status'] = 500;
            $data['message'] = 'Konfirmasi kata sandi salah!';
            echo json_encode($data);
            exit;
        }

        // CEK USER
        $result = $this->action_m->get_single('user', ['email' => $email]);
        if ($result) {
            $data['status'] = 500;
            $data['message'] = 'Email yang anda masukan sudah terdaftar!';
            echo json_encode($data);
            exit;
        }

        $arrInsert['email'] = $email;
        $arrInsert['nama'] = $nama;
        $arrInsert['password'] = hash_my_password($email . $password);
        $arrInsert['role'] = 2;
        $insert = $this->action_m->insert('user', $arrInsert);

        if ($insert) {
            $arrSession['trash_id_user'] = $insert;
            $arrSession['trash_email'] = $email;
            $arrSession['trash_nama'] = $nama;
            $arrSession['trash_id_role'] = 2;
            $arrSession['trash_role'] = get_role(2);


            $this->session->set_userdata($arrSession);

            $data['status'] = 200;
            $data['message'] = 'Anda berhasil mendaftar! Selamat datang';
            $data['redirect'] = base_url('dashboard');
        } else {
            $data['status'] = 700;
            $data['message'] = 'Gagal menambah data! silahkan cek data atau coba lagi nanti';
        }
        echo json_encode($data);
        exit;
    }

}