<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * TODO:  write constract functon
 *  
 */

/*
 * tweet type
 * null or 1=everywhere;  2=Org;  3=PJ;  4 = Direct; 5 = followers;
*/
class Tweet extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
    }

	public function write()
    {
        $this->db->cache_delete_all();

        // open, org, follow, project-x
        $data = $this->input->post();
        $adddata = '';

        @mkdir('uddata/'.date('Y').'/'.date('m'), 0755, TRUE);

        // file upload
        $config['upload_path']   = 'uddata/'.date('Y/m');
        $config['allowed_types'] = 'pdf|doc|docx|pptx|xlsx|ppt|xls|jpg|jpeg|png|gif|csv|odf|html|ods|odg|txt';
        $config['file_name']     = md5(uniqid("", 1));
        $config['max_size']      = 50000; // 50Mbyte制限
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('upfile') )
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
        else
        {
            $fdata = $this->upload->data();
            $origin_name = htmlspecialchars($fdata['client_name']);
/*
            // if image file
            if ( $fdata['is_image'] ) {
                $adddata .= '<img src="'.site_url('/') . 'uddata/' . date('Y/m/').$fdata['file_name'].'" alt="'.$origin_name.'" />';
            }
            else {
                $adddata .= '<a href="'.site_url('/').'uddata/'.date('Y/m/').$fdata['file_name'].'" target="_blank">'.$origin_name.'</a>';
            }
*/
            $img_data = array(
                'pass' => $fdata['file_name'],
                'name' => $origin_name,
                'is_image' => $fdata['is_image']
            );
        }
        // end file upload


        // project id divide
        $group_id = null;
        if ( strstr($data['range'], 'project-') ) {
           list($data['range'], $group_id) = explode('-', $data['range']);
        }   
        else if ( 'org' === $data['range'] ) {
            $group_id = $this->session->userdata('org_id');
        }  

        $this->Write_tweet_model->write_tweet(
            $this->session->userdata('id'),
            $data['range'],
            htmlspecialchars($data['tweet']),
            $group_id,
            (!empty($fdata['file_name']) ? $img_data : null)
        );

        if ( 'org' === $data['range'] )
            redirect(site_url('/').'organize/');

        else if ( 'project' === $data['range'] )
            redirect(site_url('/').'project/'.$group_id);

        else if ( 'open' === $data['range'] )
            redirect(site_url('/').'login/');

        else
            redirect(site_url('/').'all/');

        return TRUE;
	}

    public function loadnext()
    {
        // login check
        if ( !($this->session->userdata('login')) ) { redirect('/'); }

        if ( 'login' == $this->input->get('type') ) 
            $view_data['stream'] = $this->Get_tweet_model->get_my_tweet($this->session->userdata('id'), $this->input->get('next'));
        else if ( 'reply' == $this->input->get('type') ) 
            $view_data['stream'] = $this->Get_tweet_model->get_reply_tweet($this->session->userdata('login_id'), $this->input->get('next'));
        else if ( 'organize' == $this->input->get('type') ) 
            $view_data['stream']   = $this->Get_tweet_model->get_org_tweet($this->session->userdata('org_id'), $this->input->get('next'));
        else if ( 'project' == $this->input->get('type') ) 
            $view_data['stream'] = $this->Get_tweet_model->get_project_tweet($this->input->get('pj'), $this->input->get('next'));
        else if ( 'all' == $this->input->get('type') ) 
            $view_data['stream'] = $this->Get_tweet_model->get_open_tweet(0, $this->input->get('next'));

            
         
        $view_data['users'] = $this->Option_model->load_users();
        $view_data['pj_list'] = $this->Option_model->load_project();
        $view_data['org_name'] = $this->Get_tweet_model->get_orgname($this->session->userdata('org_id'));

        $this->load->view('stream', $view_data);
        
    }

    /*
     * get tweet max id
     */
    public function maxtweet()
    {
        $login_id = $this->session->userdata('id');

        if ( 'login' === $this->input->get('tweet') )
        {
            $follow_list = array();
            $query = $this->db->where('login_id', $login_id)->get('follow');
            foreach ( $query->result_array() as $f )
            {
                $follow_list[] = $f['honor'];
            }
    
            if ( 0 < count($follow_list) ) { 
                $this->db->where_in('login_id', $follow_list);
            }
            $this->db->where_in('tweet_class', array(1,2,3));
            $this->db->or_where('login_id', $login_id);
        }
        else if ( 'reply' === $this->input->get('tweet') )
        {
            $this->db->like('tweet', '@'.$login_name.' ');
            $this->db->or_like('tweet', '@'.$login_name.'　');
            $this->db->where('tweet_class', 1);
        }
        else if ( 'organize' === $this->input->get('tweet') )
        {
            $this->db->where('group_id', $this->session->userdata('org'));
            $this->db->where('tweet_class', 2);
        }
        else if ( 'all' === $this->input->get('tweet') )
        {
            $this->db->where('tweet_class', 1);
        }

        else if ( 'project' === $this->input->get('tweet') )
        {
            $this->db->where('group_id', (int)$this->input->get('pj'));
            $this->db->where('tweet_class', 3);
        }

        echo $this->db->count_all_results('stream');

        return 0;

    }
    

    
    public function ftoggle()
    {
        $this->db->cache_delete_all();

        $user_id = $this->session->userdata('id');
        $follow_id = $this->input->get('target');
        if ( 'on' == $this->input->get('switch') )
            $this->db->insert('follow', array('id'=>null, 'login_id'=>$user_id, 'honor'=>$follow_id));
        else
            $this->db->delete('follow', array('login_id'=>$user_id, 'honor'=>$follow_id));

        return TRUE;
    }

    public function otoggle()
    {
        $this->db->cache_delete_all();

        $user_id = $this->session->userdata('id');
        $org_id = $this->input->get('target');
        if ( 'join' == $this->input->get('switch') )
            $this->db->insert('project_belong', array('id'=>null, 'login_id'=>$user_id, 'group_id'=>$org_id));
        else
            $this->db->delete('project_belong', array('login_id'=>$user_id, 'group_id'=>$org_id));

        return TRUE;
    }


    // Group rename
    public function grename()
    {
        $this->db->cache_delete_all();

        if ( $this->session->userdata('login') )
        {
            $this->db->where('leader', $this->session->userdata('id'));
            $this->db->where('id', $this->input->get('num'));
            $this->db->update('project_master', array(
                'pj_name' => $this->input->get('name')
            ));
        }
        return TRUE;
    }
    
    // Group Delete
    public function gdelete()
    {
        $this->db->cache_delete_all();

        if ( $this->session->userdata('login') )
        {
            $this->db->where('leader', $this->session->userdata('id'));
            $this->db->where('id', $this->input->get('num'));
            $this->db->delete('project_master', array(
                'pj_name' => $this->input->get('name')
            ));
        }
        return TRUE;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
