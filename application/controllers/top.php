<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
// scope
// bit map for distribution scope;

1 = everywhere;
2 = group only;
3 = project;
4 = direct
null = default

*/
class Top extends CI_Controller {
    public $viewData = array();

    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler($this->config->item('profiles'));

        // load first data
        $this->viewData['op'] = $this->Option_model->load_option();
        $this->viewData['users'] = $this->Option_model->load_users();
        $this->viewData['pj_list'] = $this->Option_model->load_project();

        // login user data
        if ( $this->session->userdata('login') )
        {
            $this->viewData['user_name'] = $this->session->userdata('user_name');
            $this->viewData['belong_pj'] = $this->Option_model->load_join_pj($this->session->userdata('id'));
            $this->viewData['count_data'] = $this->Option_model->count_prof($this->session->userdata('id'));

            $this->viewData['join_pj'] = FALSE;
            $this->viewData['search'] = '';

            $pjnum = ($this->uri->segment(2)) ? $this->uri->segment(2) : '';
            $this->viewData['tslctd'] = tweetSelected($this->uri->segment(1,0), $pjnum);
            $this->viewData['tabslct'] = tabSelected($this->uri->segment(1,0), $pjnum);
        }

    }



   /**
    * Index Page for this controller.
    * @var top()
    * no longin page
    */
   public function index()
   {
        // load all open stream
        if ( !($this->session->userdata('login')) ) {
            $this->viewData['stream'] = $this->Get_tweet_model->get_open_tweet();
        }
        else if ( $this->session->userdata('login') ){
        	redirect('/login/', 'location');
            exit();
        }

        $this->viewData['pop'] = $this->Option_model->user_most_ranking();
        $this->viewData['upop']  = $this->Option_model->post_most_ranking();


        //$this->session->sess_destroy();
        // var_dump($this->session->all_userdata());
        //echo $this->session->userdata('user_name');

        // load view
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_nologin');
        $this->load->view('top_nologin');
        $this->load->view('footer');
   }

    /*
     * @var login
     * after login page.
     */
    public function login()
    {
        // login check.
        if ( !($this->session->userdata('login')) ) { redirect('/'); }

        if ( $this->input->get() ) {
            $this->viewData['stream'] = $this->Get_tweet_model->get_search_tweet($this->session->userdata('id'), 0, $this->input->get('search'));
            $this->viewData['search'] = $this->input->get('search');
        }
        else {
            $this->viewData['stream'] = $this->Get_tweet_model->get_my_tweet($this->session->userdata('id'), 0);
        }
        $this->viewData['org_name'] = $this->Get_tweet_model->get_orgname($this->session->userdata('org_id'));

        // load view
        $this->viewData['category_title'] = 'Timeline';
        
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_login');
        $this->load->view('top_index');
        $this->load->view('footer');
    }

    /*
     * @var reply
     * display reply tweet.
     */
    public function reply()
    {
        // login check.
        if ( !($this->session->userdata('login')) ) { redirect('/'); }
        
        $this->viewData['stream'] = $this->Get_tweet_model->get_reply_tweet($this->session->userdata('login_id'), 0);

        // load view
        $this->viewData['category_title'] = '@You';
        
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_login');
        $this->load->view('top_index');
        $this->load->view('footer');
    }
    
    /*
     * @var organize
     * display org member tweet.
     */
    public function organize()
    {
        // login check.
        if ( !($this->session->userdata('login')) ) { redirect('/'); }
        
        // get org data
        $this->viewData['stream']   = $this->Get_tweet_model->get_org_tweet($this->session->userdata('org_id'));
        $this->viewData['org_name'] = $this->Get_tweet_model->get_orgname($this->session->userdata('org_id'));

        // load view
        $this->viewData['category_title'] = $this->Get_tweet_model->get_orgname($this->session->userdata('org_id'));
        
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_login');
        $this->load->view('top_index');
        $this->load->view('footer');
    }

    /*
     * @var project
     * display project tweet.
     */
    public function project($pj_id)
    {
        // login check.
        if ( !($this->session->userdata('login')) ) { redirect('/'); }

        // belong project check.
        $this->viewData['join_pj'] = ( empty($pj_id) || empty($this->viewData['belong_pj'][$pj_id]) ) ? FALSE : TRUE;

        // get project data
        $this->viewData['pj_id'] = $pj_id;
        $this->viewData['stream']   = $this->Get_tweet_model->get_project_tweet($pj_id);
        $this->viewData['category_title'] = $this->viewData['pj_list'][$pj_id]['pj_name'];

        // load view
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_login');
        $this->load->view('top_index');
        $this->load->view('footer');
    }

    /*
     * @var all
     * display all open tweet.
     */
    public function all()
    {
        // get open tweet
        $this->viewData['stream'] = $this->Get_tweet_model->get_open_tweet();
        $this->viewData['category_title'] = 'New 15 Tweet';

        // load view
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_login');
        $this->load->view('top_index');
        $this->load->view('footer');

    }

    /*
     * @var profile
     * display profile config user page.
     */
    public function profile($user = null, $action = null)
    {
        // check user name and method action
        if ( null === $user ) { redirect(site_url('/')); }

        // check user_login_id
        $this->viewData['target_user'] = user_veridation($user, $this->viewData['users']);
        if ( !($this->viewData['target_user']) ){ redirect(site_url('/')); }

        $this->viewData['target_prof'] = $this->Get_user_model->get_profile_data($this->viewData['target_user']);
        $this->viewData['target_org'] = $this->Get_user_model->get_org_data($this->viewData['target_user']);

        // check own user id and login
        $this->viewData['myprof'] = ($this->viewData['target_user'] === $this->session->userdata('id')) ? TRUE : FALSE;
        $this->viewData['count_data'] = $this->Option_model->count_prof($this->viewData['target_user']);
        $this->viewData['belong_pj_target'] = $this->Option_model->load_join_pj($this->viewData['target_user']);
            // $this->viewData['follow_list'] = $this->Get_user_model->get_follow_user($this->session->userdata('id'));
            // $this->viewData['follower_list'] = $this->Get_user_model->get_follower_user($this->session->userdata('id'));
        $this->viewData['follow_list'] = $this->Get_user_model->get_follow_user($this->viewData['target_user']);
        $this->viewData['follower_list'] = $this->Get_user_model->get_follower_user($this->viewData['target_user']);

        $this->viewData['search'] = ($this->input->get('')) ? $this->input->get('search') : '';
        $this->viewData['org_list'] = $this->Option_model->org_list();

        $this->viewData['tab_select'] = array(
            'follow'=>'',
            'follower'=>'',
            'project'=>'',
            'account' => '',
            'tweet' => ''
        );
 
        switch($action)
        {
            case 'follow':
                $this->viewData['stitle'] = 'follow';
                $this->viewData['st_list'] = $this->Get_user_model->get_follow_user($this->viewData['target_user']);
                $this->viewData['prof_list'] = $this->Get_user_model->get_profile_data($this->viewData['st_list']);
                $this->viewData['num'] = count($this->viewData['st_list']);
                $this->viewData['tab_select']['follow'] = 'class="active"';

            break;

            case 'follower':
                $this->viewData['stitle'] = 'follower';
                $this->viewData['st_list'] = $this->Get_user_model->get_follower_user($this->viewData['target_user']);
                $this->viewData['prof_list'] = $this->Get_user_model->get_profile_data($this->viewData['st_list']);
                $this->viewData['num'] = count($this->viewData['st_list']);
                $this->viewData['tab_select']['follower'] = 'class="active"';
            break;

            case 'project':
                $this->viewData['stitle'] = $this->Option_model->project_name($this->uri->rsegments[5]);
                $this->viewData['st_list'] = $this->Get_user_model->get_pj_mem($this->uri->rsegments[5]);
                $this->viewData['num'] = count($this->viewData['st_list'])+1;
                $this->viewData['prof_list'] = $this->Get_user_model->get_profile_data($this->viewData['st_list']);
                $this->viewData['tab_select']['project'] = 'class="active"';
            break;

            case 'account':
                // owner check
                if ( $this->session->userdata('id') != $this->viewData['target_user'] )
                {
                    redirect(site_url('/'));
                }

                // load org
                $this->viewData['prof'] = $this->Get_user_model->get_profile_data($this->session->userdata('id'));
                $this->viewData['org_list'] = $this->Option_model->load_org();
                $this->viewData['stitle'] = 'Setting';
                $this->viewData['tab_select']['account'] = 'class="active"';
            break;

            default:
                $this->viewData['stitle'] = 'Tweet';
                if ( $this->session->userdata('login') && $this->session->userdata['id'] == $this->viewData['target_user'] ) {
                    $this->viewData['stream'] = $this->Get_tweet_model->get_own_tweet($this->viewData['target_user'], $this->viewData['myprof'], 0);
                } else {
                    $this->viewData['stream'] = $this->Get_tweet_model->get_own_open_tweet($this->viewData['target_user']);
                }
                unset($action);
                $this->viewData['tab_select']['tweet'] = 'class="active"';
                //redirect(site_url('/').'profile/');
        }

        
        // load view
        $this->load->view('header', $this->viewData);
        ($this->session->userdata['login']) ? $this->load->view('toolbar_login') : $this->load->view('toolbar_nologin');
        $this->load->view('profile_left_side');
        (!empty($action) && 'account' === $action) ? $this->load->view('profile_right_side_account') : $this->load->view('profile_right_side');
        $this->load->view('footer');
    	
    }
    
    /*
     * @var regist
     * registration user.
     */
    public function regist()
    {
        // if login move root pass.
        if ( $this->session->userdata('login') ) { redirect(site_url('/')); }

        if ( $this->input->post() )
        {
            $this->db->where('login_id', $this->input->post('login'));
            $query = $this->db->get('user');
            $data = $this->input->post();

            $saveData = array(
                'id' => null,
                'user_name' => $data['user_name'],
                'org' => $data['org'],
                'login_id' => $data['login_id'],
                'login_pass' => streaching($data['pass1'], $this->config->item('salt_pass')),
                'hash' => 'dummy'.rand(1,14).'.jpg'
            );

            $query = $this->db->get_where('user', array('login_id' => $data['login_id']));
            if ( $query->num_rows() > 0 ) 
            {
                echo "すまん。ユーザ名使われてたわ";
                exit();
            }
            $this->db->insert('user', $saveData);
            $user_id = $this->db->insert_id();

            $saveIntro = array(
                'id' => $user_id,
                'url' => '',//$data['url'],
                'intro' => ''//$data['intro']
            );
            $this->db->insert('user_profile', $saveIntro);

            $this->session->sess_destroy();
            $this->session->sess_create();
            $this->session->set_userdata( array(
                'id' => $user_id,
                'login_id'  => $data['login_id'],
                'user_name' => $data['user_name'],
                'org_id'    => $data['org'],
                'hash'      => '',
                'login'     => TRUE
            ));

            $this->db->insert('stream', array(
                'id' => null,
                'login_id' => $user_id,
                'post_date' => date('Y-m-d H:i:s'),
                'tweet_class' => 1,
                'tweet' => "{$data['user_name']} さんが参加しました。"
            ));

            redirect(site_url('/'));
        }


        $this->viewData['org_list'] = $this->Option_model->load_org();
        $this->load->view('header', $this->viewData);
        $this->load->view('toolbar_nologin');
        $this->load->view('regist');
        $this->load->view('footer');

    }
    
    
    /*
     * @var create_pj
     * create project
     */
    public function createpj()
    {
        $this->db->cache_delete_all();

        if ( $this->input->post() && $this->session->userdata('login') ) {
            $this->db->insert('project_master', array(
                'pj_name' => $this->input->post('pj_name'),
                'leader' => $this->session->userdata('id')
            ));

            $id = $this->db->insert_id();

            $this->db->insert('project_belong', array(
                'group_id' => $id,
                'login_id' => $this->session->userdata('id')
            ));
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
