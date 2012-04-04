<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Conv extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(1);
    }

    public function index()
    {
        $query = $this->db->get('user');
        foreach ( $query->result_array() as $result )
        { 
            $pass = $result['login_pass'];
            for ( $i = 0; $i < 1000; $i++)
            {
                $pass = md5($pass . $this->config->item('salt_pass') . $pass);
            }
            echo $pass.'<br>';
            $this->db->where('id', $result['id']);
            $this->db->update('user', array('login_pass'=>$pass));
        }

    }
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
