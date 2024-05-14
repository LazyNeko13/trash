<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Themes
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

    public function index()
    {
        redirect('master/user');
    }
    
    public function user()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $role = $this->input->get('role');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data User';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/user"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/user.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $paramsuser = [];
        $where = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['status'] = $status;
            }
        }
        if ($search) {
            $paramsuser['columnsearch'][] = 'nama';
             $paramsuser['columnsearch'][] = 'email';
            $paramsuser['search'] = $search;
        }
        if (!$role || $role == 'all') {
            $where['user.role > '] = 1;
        }else{
            if (in_array($role,[2,3])) {
                $where['user.role'] = $role;
            }else{
                $where['user.role > '] = 1;
            }
        }
        if ($this->id_role == 2) {
            $where['user.id_user !='] = $this->id_user;
        }
      
        $jumlah = $this->action_m->cnt_where_params('user', $where, '*', $paramsuser);
        $paramsuser['limit'] = $limit;
        if ($offset) {
            $paramsuser['offset'] = $offset;
        }
        $user = $this->action_m->get_where_params('user', $where, '*', $paramsuser);
        // CETAK DATA
        $mydata['result'] = $user;
        $mydata['search'] = $search;

        load_pagination('master/user', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('user', $mydata, TRUE);
        $this->display();
    }

    public function agen()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Produk';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/agen"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/agen.js"></script>';
        $where = [];
        $w = [];
        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($search) {
            $params['columnsearch'][] = 'agen.nama';
            $params['search'] = $search;
        }
        $order['order_by'] = 'agen.nama';
        $order['ascdesc'] = 'ASC';
        if ($status) {
            if (in_array($status,['Y','N'])) {
                $where['agen.status'] = $status;
            }
             
        }
        $w['user.status'] = 'Y';
        $p['arrjoin']['user']['statement'] = 'agen_member.id_user = user.id_user';
        $p['arrjoin']['user']['type'] = 'LEFT';
        $get_id = $this->action_m->get_all('agen_member');
        $jumlah = $this->action_m->cnt_where_params('agen', $where, 'agen.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $params['arrorderby']['kolom'] = 'nama';
         $params['arrorderby']['order'] = 'ASC';
        
        $result = $this->action_m->get_where_params('agen', $where, 'agen.*', $params);
        $user = $this->action_m->get_where_params('agen_member',$w,'agen_member.id_agen,user.*',$p);

        // CETAK DATA
        $arr = [];
        $no = 0;
        if ($result) {
            foreach ($result as $row) {
                $num = $no++;
                $arr[$num]['id_agen'] = $row->id_agen;
                $arr[$num]['nama'] = $row->nama;
                $arr[$num]['alamat'] = $row->alamat;
                $arr[$num]['latitude'] = $row->latitude;
                $arr[$num]['longitude'] = $row->longitude;
                $arr[$num]['status'] = $row->status;
                $arc = [];
                if ($user) {
                    $nu = 0;
                    foreach ($user as $key) {
                        $nuu = $nu++;
                        if ($key->id_agen == $row->id_agen) {
                            $arc[$nuu]['id_user'] = $key->id_user;
                            $arc[$nuu]['nama'] = $key->nama;
                        }
                    }
                }
                $arr[$num]['member'] = $arc;
            }
            
        }
        $mydata['result'] = $arr;
        $mydata['search'] = $search;

        load_pagination('master/agen', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('agen', $mydata, TRUE);
        $this->display();
    }

    public function poin()
    {

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Poin';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/poin"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/poin.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        
        $paramspoin = [];
        $where = [];
        $jumlah = $this->action_m->cnt_where_params('poin', $where, '*', $paramspoin);
        $paramspoin['limit'] = $limit;
        if ($offset) {
            $paramspoin['offset'] = $offset;
        }
        $poin = $this->action_m->get_where_params('poin', $where, '*', $paramspoin);
        // CETAK DATA
        $mydata['result'] = $poin;

        load_pagination('master/poin', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('poin', $mydata, TRUE);
        $this->display();
    }

    public function voucher()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Voucher';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/voucher"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/voucher.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $paramsvoucher = [];
        $where = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['status'] = $status;
            }
        }
        if ($search) {
            $paramsvoucher['columnsearch'][] = 'nama';
            $paramsvoucher['search'] = $search;
        }
      
        $jumlah = $this->action_m->cnt_where_params('voucher', $where, '*', $paramsvoucher);
        $paramsvoucher['limit'] = $limit;
        if ($offset) {
            $paramsvoucher['offset'] = $offset;
        }
        $voucher = $this->action_m->get_where_params('voucher', $where, '*', $paramsvoucher);
        // CETAK DATA
        $mydata['result'] = $voucher;
        $mydata['search'] = $search;

        load_pagination('master/voucher', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('voucher', $mydata, TRUE);
        $this->display();
    }


    // FUNGSI AJAX
    public function get_single_user()
    {
        $id = $this->input->post('id');

        $result = $this->action_m->get_single('user', ['id_user' => $id]);
        $data['user'] = $result;
        // sleep(1.5);
        echo json_encode($data);
        exit;
    }

     public function get_single_poin()
    {
        $id = $this->input->post('id');

        $result = $this->action_m->get_single('poin', ['id_poin' => $id]);
        $data['poin'] = $result;
        // sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function get_single_voucher()
    {
        $id = $this->input->post('id');

        $result = $this->action_m->get_single('voucher', ['id_voucher' => $id]);
        $data['voucher'] = $result;
        // sleep(1.5);
        echo json_encode($data);
        exit;
    }



    public function get_single_agen()
    {
        $id = $this->input->post('id');
        $result = $this->action_m->get_single('agen', ['id_agen' => $id]);
        // $data['user'] = $result;
        // sleep(1.5);
        echo json_encode($result);
        exit;
    }

    public function get_single_pengepul()
    {
        $id = $this->input->post('id');

        $get_aktif = $this->action_m->get_all('agen_member',['id_agen !=' => $id]);
        $fix = $this->action_m->get_all('agen_member',['id_agen' => $id]);
        $ed = [];
        if ($get_aktif) {
            foreach ($get_aktif as $row) {
               $ed[] = $row->id_user;
            }
        }
        $kd = [];
        if ($fix) {
            foreach ($fix as $row) {
               $kd[] = $row->id_user;
            }
        }
        $params = [];
        if (count($ed) > 0) {
            $params['not_where_in']['kolom'] = 'id_user';
            $params['not_where_in']['value'] = $ed;
        }
        

        $pengepul = $this->action_m->get_where_params('user',['role' => 3],'*',$params);

        $data['pengepul'] = $pengepul;
        $data['choose'] = $kd;
        $data['id_agen'] = $id;

        $this->load->view('modal/pengepul',$data);
    }
   
}
