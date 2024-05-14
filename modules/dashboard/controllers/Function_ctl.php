<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Themes
{
    var $id_role = '';
    var $id_user = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_role = $this->session->userdata('trash_id_role');
        $this->id_user = $this->session->userdata('trash_id_user');
    }

    //  FUNGSI PENUKARAN
     public function tambah_penukaran()
    {
        // VARIABEL UNIT
        $arrVar['id_agen']             = 'Agen';
        $arrVar['id_penerima']       = 'Pengepul';
        $arrVar['id_pengirim']       = 'Pengirim';
        $arrVar['jumlah']            = 'Jumlah';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        if (!in_array($id_pengirim,['new'])) {
            $post['id_pengirim'] = $id_pengirim;
        }else{
            if ($id_pengirim == 'new') {
                // VARIABEL UNIT
                $arrVar2['nama']             = 'Nama pengirim';
                $arrVar2['email']            = 'Email';
                $arrVar2['password']             = 'Kata sandi';
                $arrVar2['repassword']             = 'Konfirmasi kata sandi';

                // INFORMASI UMUM
                foreach ($arrVar2 as $var => $value) {
                    $$var = $this->input->post($var);
                    if (!$$var) {
                        $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                        $arrAccess[] = false;
                    } else {
                        if (!in_array($var,['password','repassword'])) {
                            $post2[$var] = trim($$var);
                        }
                        
                        $arrAccess[] = true;
                    }
                }
            }
        }
         if (empty($_FILES['bukti_kirim']['tmp_name'])) {
            $data['required'][] = ['req_bukti_kirim', 'Bukti kirim utama tidak boleh kosong !'];
            $arrAccess[] = false;
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['bukti_kirim']['tmp_name'])) {
                $bukti_kirim = $_FILES['bukti_kirim'];
                $tujuan = './data/bukti_kirim/';
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_sub = [];

                if (!$this->upload->do_upload('bukti_kirim')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_sub = array('upload_data' => $this->upload->data());
                    $post['bukti_kirim'] = $data_sub['upload_data']['file_name'];
                }
            }else{
                 $data['status'] = false;
                $data['alert']['message'] = 'Bukti kirim tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            // GET POIN
            $order['order_by'] = 'poin';
            $order['ascdesc'] = 'DESC';
            $poi = $this->action_m->get_single('poin',['jumlah_minimal <= ' => $jumlah,'jumlah_maximal >= ' => $jumlah],$order);
            if (!$poi) {
                $poi = $this->action_m->get_where_params('poin',[],'MAX(poin) AS poin',[]);
                $poi = $poi[0];
            }

            $post['poin'] = $poi->poin;
            $post['create_by'] = $this->id_user;
            $post2['poin'] = $poi->poin;
            if ($id_pengirim == 'new') {
                $user_email = $this->action_m->get_single('user', ['email' => $email]);
                if (!validasi_email($email)) {
                    
                    $data['status'] = false;
                    $data['alert']['message'] = 'Alamat email tidak valid!';
                    echo json_encode($data);
                    exit;
                }

                if ($user_email) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                    echo json_encode($data);
                    exit;
                }

                if ($password != $repassword) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                    echo json_encode($data);
                    exit;
                } else {
                    $post2['password'] = hash_my_password($email . $password);
                }
                $post2['role'] = 2;

                $id = $this->action_m->insert('user', $post2);
                if (!$id) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Data pengepul gagal di tambahkan!';
                    echo json_encode($data);
                    exit;
                }else{
                    $post['id_pengirim'] = $id;
                }

            }else{
                $cu = $this->action_m->get_single('user',['id_user' => $id_pengirim]);
                $poin = $cu->poin + $poi->poin;
                $posti['poin'] = $poin;
                $update = $this->action_m->update('user',$posti,['id_user' => $id_pengirim]);
            }
            $insert = $this->action_m->insert('penukaran', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data penukaran berhasil di tambahkan!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('penukaran #reload_table');
                $data['modal']['id'] = '#kt_modal_penukaran';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function get_voucher()
    {
        $id_voucher = $this->input->post('id_voucher');

        $cek = $this->action_m->get_single('voucher',['id_voucher' => $id_voucher]);
        if ($cek) {
            $post['id_voucher'] = $id_voucher;
            $post['id_user'] = $this->id_user;
            $post['poin'] = $cek->poin;

            $this->action_m->insert('voucher_penukaran',$post);
            $get = $this->action_m->get_single('user',['id_user' => $this->id_user]);
            $set['poin'] = $get->poin - $cek->poin;
            $user = $this->action_m->update('user',$set,['id_user' => $this->id_user]);

            $data['status'] = true;
            $data['alert']['message'] = 'Voucher berhasil di ambil!';
            $data['load'][0]['parent'] = '#kt_app_content';
            $data['load'][0]['reload'] = base_url('dashboard #kt_app_content_container');
            $data['modal']['id'] = '#kt_modal_voucher';
            $data['modal']['action'] = 'hide';

            
        }else{
             $data['status'] = false;
            $data['alert']['message'] = 'Voucher tidak ditemukan!';
        }

        echo json_encode($data);
        exit;
        

    }
}