<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Themes
{
    var $id_role = '';
    var $id_user = '';
    var $nama = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_role = $this->session->userdata('trash_id_role');
        $this->id_user = $this->session->userdata('trash_id_user');
        $this->nama = $this->session->userdata('trash_nama');
    }



    // MASTER USER

    public function tambah_user()
    {
        // VARIABEL
        $arrVar['nama']             = 'Nama user';
        $arrVar['email']            = 'Alamat email';
        $arrVar['role']           = 'Peran';
        $arrVar['password']         = 'Kata sandi';
        $arrVar['repassword']       = 'Konfirmasi kata sandi ';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if (!in_array($var, ['password', 'repassword'])) {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            
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
                $post['password'] = hash_my_password($email . $password);
            }
            $post['user.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('user', $post);
            if ($insert) {
               

                $data['status'] = true;
                $data['alert']['message'] = 'Data user berhasil di tambahkan!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
                $data['modal']['id'] = '#kt_modal_user';
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

    public function ubah_user()
    {
        // VARIABEL
        $arrVar['id_user']          = 'Id user';
        $arrVar['nama']             = 'Nama user';
        $arrVar['email']            = 'Alamat email';
        $arrVar['role']           = 'Peran';

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
        $result = $this->action_m->get_single('user', ['id_user' => $id_user]);
        $password = $this->input->post('password');
        $repassword = $this->input->post('repassword');
        if (!validasi_email($email)) {
            $data['status'] = false;
            $data['alert']['message'] = 'Alamat email tidak valid!';
            echo json_encode($data);
            exit;
        }

        if ($result->email != $email) {
            $cek_email = $this->action_m->get_single('user', ['email' => $email]);
            if ($cek_email) {
                if ($cek_email->id_user != $result->id_user) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                    echo json_encode($data);
                    exit;
                }
                
            }   
            if (!$password) {
                $data['required'][] = ['req_password', 'Kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            } 
            if (!$repassword) {
                $data['required'][] = ['req_repassword', 'Konfirmasi kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            }     
        }
        if (!in_array(false, $arrAccess)) {
            
            if ($password) {
                if ($password != $repassword) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                    echo json_encode($data);
                    exit;
                } else {
                    $post['password'] = hash_my_password($email . $password);
                    $lp['id_user'] = $this->id_user;
                    $lp['tanggal'] = date('Y-m-d H:i:s');
                    $lp['tipe'] = 3;
                    $lp['keterangan'] = $this->nama.' telah merubah password user dengan nama <b>"'.$result->nama.'"</b>';
                }
            }
            $update = $this->action_m->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
               
                $data['status'] = true;
                $data['alert']['message'] = 'Data user berhasil di rubah!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
                $data['modal']['id'] = '#kt_modal_user';
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

    public function hapus_user()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('user',['id_user' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('user',['id_user' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data user berhasil dihapus';
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data user gagal dihapus! Coba lagi nanti atau laporkan';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data user tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }

    public function block_user($ent = 'user')
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $reason = $this->input->post('reason');
         $res = $this->action_m->get_single('user',['id_user' => $id]);
        if (!$res) {
             $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data '.$ent.' tidak ditemukan';
            echo json_encode($data);
            exit;
        }
        $set['status'] = $action;
        if ($action == 'N') {
            $set['block_reason'] = $reason;
            $t = 'block';
        } else {
            $set['block_reason'] = NULL;
            $t = 'unblock';
        }

        $update = $this->action_m->update('user', $set, ['id_user' => $id]);
        $alasan = '';
        if ($update) {


            $data['status'] = 200;
            $data['alert']['icon'] = 'success';
            if ($action == 'N') {
                $data['alert']['message'] = $ent.' berhasil di blockir! '.$ent.' tidak akan bisa melakukan akses pada sistem';
            } else {
                $data['alert']['message'] = 'Status blockir '.$ent.' telah dibuka! '.$ent.' bisa melakukan akses pada sistem';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = $ent.' gagal di blockir! Coba lagi setelah beberapa saat atau laporkan';
        }
        echo json_encode($data);
        exit;
    }

    public function drag_user($action = 'deleted')
    {
        $id = $this->input->post('id_batch');
        $cek = $this->action_m->get_all('user',['id_user' => $id]);
        $dt = [];
        if ($cek) {
            $no = 0;
            foreach ($cek as $key) {
                $num = $no++;
                $dt['value'][$num] = $key->nama; 
            }        
        }else{
            $dt['value'] = 'Tidak ada data ditemukan';
        }
         if (!$cek) {
                $data['status'] = 500;
                $data['alert']['message'] = 'Data user tidak ditemukan';
                echo json_encode($data);
                exit;
            }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data user belum terkait';
            echo json_encode($data);
            exit;
        }
        if ($action == 'block') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_user'] = $value;
                $set[$num]['status'] = 'N';
            }
            $block = $this->action_m->update_batch('user', $set, 'id_user');
            if ($block) {
                
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil melakukan block pada sejumlah user';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal melakukan block pada sejumlah user';;
            }
        } elseif ($action == 'unblock') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_user'] = $value;
                $set[$num]['status'] = 'Y';
            }
            $block = $this->action_m->update_batch('user', $set, 'id_user');
            if ($block) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil membuka block pada sejumlah user';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal membuka block pada sejumlah user';;
            }
        } elseif ($action == 'deleted') {
            $ed = [];
            foreach ($id as $value) {
                $ed[] = $value;
            }

            $set['id_user'] = $ed;
            
            
            $delete = $this->action_m->delete_batch('user', $set);
            if ($delete) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus sejumlah user';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus sejumlah user';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data aksi belum terkait';
        }
        echo json_encode($data);
        exit;
    }



    // MASTER AGEN
    public function tambah_agen()
    {
        // VARIABEL
        $arrVar['nama']                          = 'Nama agen';
        $arrVar['alamat']                        = 'Alamat';
        $arrVar['latitude']                      = 'Latitude';
        $arrVar['longitude']                     = 'Longitude';

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
        if (!in_array(false, $arrAccess)) {
            $insert = $this->action_m->insert('agen', $post);
            if ($insert) {

                $data['status'] = true;
                $data['alert']['message'] = 'Data agen berhasil di tambahkan!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/agen #reload_table');
                $data['modal']['id'] = '#kt_modal_agen';
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

    public function ubah_agen()
    {
        // VARIABEL
        $arrVar['id_agen']                       = 'ID agen';
        $arrVar['nama']                          = 'Nama agen';
        $arrVar['alamat']                        = 'Alamat';
        $arrVar['latitude']                      = 'Latitude';
        $arrVar['longitude']                     = 'Longitude';

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
        if (!in_array(false, $arrAccess)) {
            $update = $this->action_m->update('agen', $post, ['id_agen' => $id_agen]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data agen berhasil di rubah!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/agen #reload_table');
                $data['modal']['id'] = '#kt_modal_agen';
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

    public function hapus_agen()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('agen',['id_agen' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('agen', ['id_agen' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data agen berhasil dihapus';
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data agen gagal dihapus! Coba lagi nanti atau laporkan';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data agen tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }

    public function switch_agen()
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $reason = $this->input->post('reason');
        $res = $this->action_m->get_single('agen',['id_agen' => $id]);
        if (!$res) {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data agen tidak ditemukan';
            echo json_encode($data);
            exit;
        }
        $set['status'] = $action;
        if ($action == 'N') {
            $set['block_reason'] = $reason;
            $t = 'menyembunyikan';
        } else {
            $set['block_reason'] = NULL;
            $t = 'menampilkan';
        }

        $update = $this->action_m->update('agen', $set, ['id_agen' => $id]);
        $alasan = '';
        if ($update) {

            $data['status'] = 200;
            $data['alert']['icon'] = 'success';
            if ($action == 'N') {
                $data['alert']['message'] = 'Berhasil di sembunyikan! agen tidak akan bisa diakses oleh user';
            } else {
                $data['alert']['message'] = 'agen telah dibuka! agen bisa DIakses oleh user';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'agen gagal disembunyikan! Coba lagi setelah beberapa saat atau laporkan';
        }
        echo json_encode($data);
        exit;
    }

    public function drag_agen($action = 'deleted')
    {
        $id = $this->input->post('id_batch');
        $cek = $this->action_m->get_all('agen',['id_agen' => $id]);
        $dt = [];
        if ($cek) {
            $no = 0;
            foreach ($cek as $key) {
                $num = $no++;
                $dt['value'][$num] = $key->nama; 
            }        
        }else{
            $dt['value'] = 'Tidak ada data ditemukan';
        }
         if (!$cek) {
                $data['status'] = 500;
                $data['alert']['message'] = 'Data agen tidak ditemukan';
                echo json_encode($data);
                exit;
            }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data agen belum terkait';
            echo json_encode($data);
            exit;
        }
        if ($action == 'block') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_agen'] = $value;
                $set[$num]['status'] = 'N';
            }
            $block = $this->action_m->update_batch('agen', $set, 'id_agen');
            if ($block) {
                
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menyembunyikan sejumlah agen';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/agen #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal melakukan block pada sejumlah agen';
            }
        } elseif ($action == 'unblock') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_agen'] = $value;
                $set[$num]['status'] = 'Y';
            }
            $block = $this->action_m->update_batch('agen', $set, 'id_agen');
            if ($block) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menampilkan kembali sejumlah agen';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/agen #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menampilkan kembali sejumlah agen';
            }
        } elseif ($action == 'deleted') {
            $ed = [];
            foreach ($id as $value) {
                $ed[] = $value;
            }
            
            $set['id_agen'] = $ed;
            $delete = $this->action_m->delete_batch('agen', $set);
            if ($delete) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus sejumlah agen';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/agen #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus sejumlah agen';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data aksi belum terkait';
        }
        echo json_encode($data);
        exit;
    }


    public function set_pengepul()
    {
        $id_agen = $this->input->post('id_agen');
        $id_user = $this->input->post('id_user');

        $hapus = $this->action_m->delete('agen_member',['id_agen' => $id_agen]);
        $insert = 0;
        if (is_array($id_user)) {
            $no = 0;
            foreach ($id_user as $id) {
                $num = $no++;
               $post[$num]['id_agen'] = $id_agen;
               $post[$num]['id_user'] = $id;
            }

            $insert = $this->action_m->insert_batch('agen_member',$post);
        }
        
        $data['status'] = true;
        $data['alert']['message'] = 'Data pengepul berhasil di update!';
        $data['load'][0]['parent'] = '#base_table';
        $data['load'][0]['reload'] = base_url('master/agen #reload_table');
        $data['modal']['id'] = '#kt_modal_pengepul';
        $data['modal']['action'] = 'hide';

        echo json_encode($data);
        exit;
    }



    // MASTER POIN
    public function tambah_poin()
    {
        // VARIABEL
        $arrVar['jumlah_minimal']   = 'Jumlah minimal (Kg)';
        $arrVar['jumlah_maximal']   = 'Jumlah maximal (Kg)';
        $arrVar['poin']            = 'Poin';

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
        if (!in_array(false, $arrAccess)) {
            $post['create_by'] = $this->id_user;
            $insert = $this->action_m->insert('poin', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data poin berhasil di tambahkan!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/poin #reload_table');
                $data['modal']['id'] = '#kt_modal_poin';
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

    public function ubah_poin()
    {
        // VARIABEL
        $arrVar['jumlah_minimal']   = 'Jumlah minimal (Kg)';
        $arrVar['jumlah_maximal']   = 'Jumlah maximal (Kg)';
        $arrVar['poin']             = 'Poin';
        $arrVar['id_poin']          = 'ID Poin';

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
        $result = $this->action_m->get_single('poin', ['id_poin' => $id_poin]);
        if (!in_array(false, $arrAccess)) {
            $update = $this->action_m->update('poin', $post, ['id_poin' => $id_poin]);
            if ($update) {
               
                $data['status'] = true;
                $data['alert']['message'] = 'Data poin berhasil di rubah!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/poin #reload_table');
                $data['modal']['id'] = '#kt_modal_poin';
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

    public function hapus_poin()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('poin',['id_poin' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('poin',['id_poin' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data poin berhasil dihapus';
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data poin gagal dihapus! Coba lagi nanti atau laporkan';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data user tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }

    public function drag_poin($action = 'deleted')
    {
        $id = $this->input->post('id_batch');
        $cek = $this->action_m->get_all('poin',['id_poin' => $id]);
        $dt = [];
        if ($cek) {
            $no = 0;
            foreach ($cek as $key) {
                $num = $no++;
                $dt['value'][$num] = $key->nama; 
            }        
        }else{
            $dt['value'] = 'Tidak ada data ditemukan';
        }
         if (!$cek) {
                $data['status'] = 500;
                $data['alert']['message'] = 'Data poin tidak ditemukan';
                echo json_encode($data);
                exit;
            }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data poin belum terkait';
            echo json_encode($data);
            exit;
        }
        if ($action == 'deleted') {
            $ed = [];
            foreach ($id as $value) {
                $ed[] = $value;
            }

            $set['id_poin'] = $ed;
            
            
            $delete = $this->action_m->delete_batch('poin', $set);
            if ($delete) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus sejumlah poin';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/poin #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus sejumlah poin';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data aksi belum terkait';
        }
        echo json_encode($data);
        exit;
    }


    // MASTER VOUCHER

    public function tambah_voucher()
    {
        // VARIABEL
        $arrVar['nama']             = 'Nama voucher';
        $arrVar['keterangan']   = 'Keterangan';
        $arrVar['poin']            = 'Poin';

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
        if (!in_array(false, $arrAccess)) {
            $post['create_by'] = $this->id_user;
            $insert = $this->action_m->insert('voucher', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data voucher berhasil di tambahkan!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/voucher #reload_table');
                $data['modal']['id'] = '#kt_modal_voucher';
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

    public function ubah_voucher()
    {
        // VARIABEL
        $arrVar['nama']             = 'Nama voucher';
        $arrVar['keterangan']   = 'Keterangan';
        $arrVar['poin']            = 'Poin';
        $arrVar['id_voucher']          = 'ID Voucher';

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
        $result = $this->action_m->get_single('voucher', ['id_voucher' => $id_voucher]);
        if (!in_array(false, $arrAccess)) {
            $update = $this->action_m->update('voucher', $post, ['id_voucher' => $id_voucher]);
            if ($update) {
               
                $data['status'] = true;
                $data['alert']['message'] = 'Data voucher berhasil di rubah!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/voucher #reload_table');
                $data['modal']['id'] = '#kt_modal_voucher';
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

    public function hapus_voucher()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('voucher',['id_voucher' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('voucher',['id_voucher' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data voucher berhasil dihapus';
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data voucher gagal dihapus! Coba lagi nanti atau laporkan';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data user tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }

    public function drag_voucher($action = 'deleted')
    {
        $id = $this->input->post('id_batch');
        $cek = $this->action_m->get_all('voucher',['id_voucher' => $id]);
        $dt = [];
        if ($cek) {
            $no = 0;
            foreach ($cek as $key) {
                $num = $no++;
                $dt['value'][$num] = $key->nama; 
            }        
        }else{
            $dt['value'] = 'Tidak ada data ditemukan';
        }
         if (!$cek) {
                $data['status'] = 500;
                $data['alert']['message'] = 'Data voucher tidak ditemukan';
                echo json_encode($data);
                exit;
            }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data voucher belum terkait';
            echo json_encode($data);
            exit;
        }
        if ($action == 'block') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_voucher'] = $value;
                $set[$num]['status'] = 'N';
            }
            $block = $this->action_m->update_batch('voucher', $set, 'id_voucher');
            if ($block) {
                
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil melakukan block pada sejumlah voucher';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/voucher #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal melakukan block pada sejumlah voucher';;
            }
        } elseif ($action == 'unblock') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_voucher'] = $value;
                $set[$num]['status'] = 'Y';
            }
            $block = $this->action_m->update_batch('voucher', $set, 'id_voucher');
            if ($block) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil membuka block pada sejumlah voucher';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/voucher #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal membuka block pada sejumlah voucher';;
            }
        } elseif ($action == 'deleted') {
            $ed = [];
            foreach ($id as $value) {
                $ed[] = $value;
            }

            $set['id_voucher'] = $ed;
            
            
            $delete = $this->action_m->delete_batch('voucher', $set);
            if ($delete) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus sejumlah voucher';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/voucher #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus sejumlah voucher';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data aksi belum terkait';
        }
        echo json_encode($data);
        exit;
    }

    public function switch_voucher()
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $reason = $this->input->post('reason');
        $res = $this->action_m->get_single('voucher',['id_voucher' => $id]);
        if (!$res) {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data voucher tidak ditemukan';
            echo json_encode($data);
            exit;
        }
        $set['status'] = $action;
        if ($action == 'N') {
            $set['block_reason'] = $reason;
            $t = 'menyembunyikan';
        } else {
            $set['block_reason'] = NULL;
            $t = 'menampilkan';
        }

        $update = $this->action_m->update('voucher', $set, ['id_voucher' => $id]);
        $alasan = '';
        if ($update) {

            $data['status'] = 200;
            $data['alert']['icon'] = 'success';
            if ($action == 'N') {
                $data['alert']['message'] = 'Berhasil di sembunyikan! voucher tidak akan bisa diakses oleh user';
            } else {
                $data['alert']['message'] = 'voucher telah dibuka! voucher bisa DIakses oleh user';
            }
        } else {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'voucher gagal disembunyikan! Coba lagi setelah beberapa saat atau laporkan';
        }
        echo json_encode($data);
        exit;
    }
}
