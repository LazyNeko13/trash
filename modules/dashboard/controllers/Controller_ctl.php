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
        if (!in_array($this->id_role,[1,2])) {
            redirect('penukaran');
        }
        $mydata = [];
        $where = [];
        // GLOBAL VARIABEL
        $this->data['title'] = 'Dashboard';
        
         // LOAD JS
        $this->data['js_add'][] = '<script>var page = "dashboard"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/dashboard/dashboard.js"></script>';

        $user = $this->action_m->get_all('user',['status' => 'Y']);
        $ja = 0;
        $ju = 0;
        $jp = 0;
        if ($user) {
            foreach ($user as $row) {
                if ($row->role == 1) {
                    $ja += 1;
                }elseif ($row->role == 2) {
                   $ju += 1;
                }elseif ($row->role == 3) {
                    $jp += 1;
                }
            }
        }
         $limit = 5;
        $offset = $this->uri->segment(3);
        $jumlah = $this->action_m->cnt_where_params('agen', $where, 'agen.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $params['arrorderby']['kolom'] = 'nama';
        $params['arrorderby']['order'] = 'ASC';
        $parpar['arrjoin']['voucher']['statement'] = 'voucher_penukaran.id_voucher = voucher.id_voucher';
        $parpar['arrjoin']['voucher']['type'] = 'LEFT';
        
        $agen = $this->action_m->get_where_params('agen', $where, 'agen.*', $params);
        $pribadi = $this->action_m->get_single('user',['id_user' => $this->id_user]);
        $voucher = $this->action_m->get_where_params('voucher_penukaran',['id_user' => $this->id_user],'voucher.*',$parpar);



        // LOAD MYDATA
        $mydata['jumlah']['user'] = $ju;
        $mydata['jumlah']['admin'] = $ja;
        $mydata['jumlah']['pengepul'] = $jp;
        $mydata['pribadi'] = $pribadi;
        $mydata['agen'] = $agen;
        $mydata['voucher'] = $voucher;

        load_pagination('dashboard', $limit, $jumlah);
        // LOAD VIEW
        $this->data['content'] = $this->load->view('index', $mydata, TRUE);
        $this->display();
    }

    public function penukaran()
    {
        if (!in_array($this->id_role,[1,3])) {
            redirect('dashboard');
        }
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Penukaran';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "penukaran"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/dashboard/penukaran.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $paramspenukaran = [];
        $where = [];
        if ($search) {
            $paramspenukaran['columnsearch'][] = 'user.nama';
            $paramspenukaran['search'] = $search;
        }

        $where['DATE(penukaran.create_date)'] = date('Y-m-d');
      
        if ($this->id_role == 3) {
            $cek = $this->action_m->get_single('agen_member',['id_user' => $this->id_user]);
            if ($cek) {
                $id_agen = $cek->id_agen;
                $where['penukaran.id_agen'] = $cek->id_agen;
                $mydata['id_agen'] = $id_agen;
            }else{
                $mydata['close'] = true;
            }
        }
        $jumlah = $this->action_m->cnt_where_params('penukaran', $where, '*', $paramspenukaran);
        $paramspenukaran['limit'] = $limit;
        if ($offset) {
            $paramspenukaran['offset'] = $offset;
        }
        $paramspenukaran['arrjoin']['user']['statement'] = 'penukaran.id_pengirim = user.id_user';
        $paramspenukaran['arrjoin']['user']['type'] = 'LEFT';
        $paramspenukaran['arrjoin']['agen']['statement'] = 'penukaran.id_agen = agen.id_agen';
        $paramspenukaran['arrjoin']['agen']['type'] = 'LEFT';
        $penukaran = $this->action_m->get_where_params('penukaran', $where, 'penukaran.*,user.nama AS pengirim,agen.nama AS agen', $paramspenukaran);
        $user = $this->action_m->get_all('user',['role' => 2]);
        if ($this->id_role == 1) {
            $agen = $this->action_m->get_all('agen',['status' => 'Y']);
            $mydata['agen'] = $agen;
        }
        // CETAK DATA
        $mydata['result'] = $penukaran;
        $mydata['user'] = $user;
        $mydata['search'] = $search;

        load_pagination('master/penukaran', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('penukaran', $mydata, TRUE);
        $this->display();
    }

    public function get_all_pengepul()
    {
        $id = $this->input->post('id');
        $p['arrjoin']['user']['statement'] = 'agen_member.id_user = user.id_user';
        $p['arrjoin']['user']['type'] = 'LEFT';
        $result = $this->action_m->get_where_params('agen_member',['id_agen' => $id],'user.*',$p);

        $html = '';
        if ($result) {
            $html .= '<option value="" selected>Pilih pengepul</option>';
            foreach ($result as $row) {
                $html .= '<option value="'.$row->id_user.'">'.$row->nama.'</option>';
            }
        }

        $data['opsi'] = $html;
        echo json_encode($data);
    }


    public function tukar_poin()
    {
        $poin = $this->input->post('poin');
        $result = $this->action_m->get_all('voucher',['poin <=' => $poin]);

        $data['result'] = $result;
        $this->load->view('modal/voucher',$data);
    }
}