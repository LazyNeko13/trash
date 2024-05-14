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
        redirect('report/penukaran');
    }
    public function penukaran()
    {
        // GET FILTER DATA
        $tahun = ($this->input->get('tahun')) ? $this->input->get('tahun') : date('Y');
        $bulan = ($this->input->get('bulan')) ? $this->input->get('bulan') : date('m');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Penukaran';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "report/penukaran"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/report/penukaran.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $where = [];

        
         // GET DATA
        $params['arrjoin']['user']['statement'] = 'penukaran.id_pengirim = user.id_user';
        $params['arrjoin']['user']['type'] = 'LEFT';
        $params['arrjoin']['agen']['statement'] = 'penukaran.id_agen = agen.id_agen';
        $params['arrjoin']['agen']['type'] = 'LEFT';
        $select = 'penukaran.*,user.nama AS pengirim,agen.nama AS agen,(SELECT nama FROM user WHERE user.id_user = penukaran.id_penerima) AS penerima';
        $where['YEAR(penukaran.create_date)'] = $tahun;
        $where['MONTH(penukaran.create_date)'] = $bulan;
        $jumlah = $this->action_m->cnt_get_all('penukaran',$where);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        if ($this->id_role == 2) {
            $where['penukaran.id_pengirim'] = $this->id_user;
        }elseif ($this->id_role == 3) {
            $cek = $this->action_m->get_single('agen_member',['id_user' => $this->id_user]);
            if ($cek) {
                $where['penukaran.id_agen'] = $cek->id_agen;
            }else{
                $mydata['close'] = true;
            }
            
        }
        $result = $this->action_m->get_where_params('penukaran',$where,$select,$params);

        // CETAK DATA
        $mydata['result'] = $result;
        $mydata['tahun'] = $tahun;
        $mydata['bulan'] = $bulan;
        $mydata['offset'] =  ($offset+1);

        load_pagination('report/penukaran', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('penukaran', $mydata, TRUE);
        $this->display();
    }

    public function juragan()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Juragan';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/juragan"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/juragan.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $paramsuser = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['block'] = $status;
            }
        }
        if ($search) {
            $paramsuser['columnsearch'][] = 'nama';
            $paramsuser['columnsearch'][] = 'email';
            $paramsuser['columnsearch'][] = 'notelp';
            $paramsuser['search'] = $search;
        }
        $where['user.role'] = 3;
        $where['user.deleted'] = 'N';
      
        $jumlah = $this->action_m->cnt_where_params('user', $where, '*', $paramsuser);
        $paramsuser['limit'] = $limit;
        if ($offset) {
            $paramsuser['offset'] = $offset;
        }
        $user = $this->action_m->get_where_params('user', $where, '*', $paramsuser);
        // CETAK DATA
        $mydata['result'] = $user;
        $mydata['search'] = $search;

        load_pagination('master/juragan', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('juragan', $mydata, TRUE);
        $this->display();
    }

    public function customer()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $role = $this->input->get('role');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Customer';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/customer"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/customer.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        $paramsuser = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['block'] = $status;
            }
        }
        if ($search) {
            $paramsuser['columnsearch'][] = 'nama';
            $paramsuser['columnsearch'][] = 'email';
            $paramsuser['columnsearch'][] = 'notelp';
            $paramsuser['search'] = $search;
        }

         $where['user.role'] = 4;
         $where['user.deleted'] = 'N';
       
        $jumlah = $this->action_m->cnt_where_params('user', $where, '*', $paramsuser);
        $paramsuser['limit'] = $limit;
        if ($offset) {
            $paramsuser['offset'] = $offset;
        }
        $user = $this->action_m->get_where_params('user', $where, '*', $paramsuser);
        // CETAK DATA
        $mydata['result'] = $user;
        $mydata['search'] = $search;

        load_pagination('master/customer', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('customer', $mydata, TRUE);
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

    public function destroy(Type $var = null)
    {
        $this->session->sess_destroy();
    }
   
}
