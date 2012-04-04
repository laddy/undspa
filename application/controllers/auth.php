<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Auth controller

function lists
 index()
 regist()
 logout()

*/
class Auth extends CI_Controller {
    public $viewData = array();

    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(1);
    }

   /**
    * auth index this controller.
    */
    public function index()
    {
        // auth userdata
        //$userData = $this->db->get_where('user', array('login_id'=>$this->input->post('Username')) );
        $userData = $this->db->query("SELECT id,login_id,login_pass,user_name,org,hash FROM (user) where login_id = '{$this->input->post('Username')}'");
        $this->session->sess_destroy();

        foreach ( $userData->result_array() as $user )
        {
            if ( $user['login_pass'] == streaching($this->input->post('Password'), $this->config->item('salt_pass') ) )
            {
                $this->session->sess_create();
                $this->session->set_userdata( array(
                    'id'        => $user['id'],
                    'login_id'  => $user['login_id'],
                    'user_name' => $user['user_name'],
                    'org_id'    => $user['org'],
                    'hash'      => $user['hash'],
                    'login'     => TRUE
				));

                redirect('/top');
                return TRUE;
            }
        }
        
        echo '認証に失敗しました。';
        redirect('/', 'location');

        return FALSE;
    }
    

    /*
     * auth config
     */
    public function account()
    {

        // load library
        $this->load->library('image_lib');

        // file upload check
        $config['upload_path'] = './uddata/icon/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = rand_data();
        $this->load->library('upload', $config);
      
        if ( ! $this->upload->do_upload('fileInput') )
        {
            // $error = array('error' => $this->upload->display_errors());
            // var_dump($error);
        }
        else
        {
            // erase icon file
            $this->db->where('id',$this->session->userdata('id'));
            $query = $this->db->get('user');
            $icon_file = $query->result_array();

            if ( !empty($icon_file[0]['hash']) ) {
                unlink('./uddata/icon/'.$icon_file[0]['hash']);
            }
            
            $data = array('udata' => $this->upload->data());
            $savedata = array( 'hash' => $data['udata']['file_name']);
            $this->db->where('id',$this->session->userdata('id'));
            $this->db->update('user', $savedata);
        }

        if ( $this->input->post() )
        {
            $savedata = array();
            if ( '' != $this->input->post('pass1') ) {
                $savedata['login_pass'] =  streaching($this->input->post('pass1'), $this->config->item('salt_pass') );
            }
            $this->db->where('id',$this->session->userdata('id'));
            $savedata['user_name'] = $this->input->post('name');
            $savedata['org'] = $this->input->post('orgSelect');
            $this->db->update('user', $savedata);

            $savedata = array();
            $savedata['intro'] = $this->input->post('intro');
            $savedata['url'] = $this->input->post('url');
            $this->db->where('id',$this->session->userdata('id'));
            $this->db->update('user_profile', $savedata);
        }

        $userData = $this->db->query("SELECT id,login_id,login_pass,user_name,org,hash FROM user WHERE id = '{$this->session->userdata('id')}'");
        $this->session->sess_destroy();
        $this->session->sess_create();
        foreach ( $userData->result_array() as $user )
        {
            $this->session->set_userdata( array(
                'id'        => $user['id'],
                'login_id'  => $user['login_id'],
                'user_name' => $user['user_name'],
                'org_id'    => $user['org'],
                'hash'      => $user['hash'],
                'login'     => TRUE
            ));
        }

        redirect(site_url('/usr/').'/'.$this->session->userdata('login_id').'/account/');
        
    }

    /*
     * user regist id check
     */
    public function idcheck()
    {
        $id = $this->input->get("target");
        $query = $this->db->query("SELECT `login_id` FROM `user` WHERE `login_id` = '{$id}'");

        if ( count($query->result_array()) ) {
            return "false";
        }
        else {
            return "true";
        }
    }

    /*
     * session logout
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('/', 'location');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
