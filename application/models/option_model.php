<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * BaseOption model
 * load option, user, etc..
 * 2012/01/29 YuyaTanaka
 * 
 */

class Option_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
    }

    /*
     * load options
     * Setting load in DataBase
     * table: option
     */
    function load_option()
    {
        $op = array();
    	// $query = $this->db->get('option');
        $query = $this->db->query('SELECT `var`,`value` FROM `option`');
        foreach ( $query->result_array() as $o )
        {
        	$op[$o['var']] = $o['value'];
        }
        
        return $op;
        
    }

    /*
     * user array create
     */
    function load_users()
    {
        $query = $this->db->query('SELECT `id`,`login_id`,`user_name`,`org`,`hash` FROM `user`');
        $uarray = array();
        foreach ( $query->result_array() as $user )
        {
        	$uarray[$user['id']] = $user;
        }

        return $uarray;
    }

    /*
     * load org list data.
     */
    function load_org()
    {
        $query = $this->db->query('SELECT * FROM `organization`');
        return $query->result_array();
    }
    
    /*
     * load belong project data
     */
    function load_project()
    {
        $query = $this->db->query("SELECT * FROM `project_master`");
        foreach ( $query->result_array() as $p )
        {
            $pj[$p['id']] = $p;
        }
        
        return $pj;
    }

    /*
     * load project name
     */
    function project_name($id)
    {
        $query = $this->db->query("SELECT * FROM `project_master` WHERE `id` = {$id}");
        $temp_query = $query->result_array();

        return $temp_query[0]['pj_name'];

    }

    /*
     * load Join project
     */
    function load_join_pj($login_id)
    {
        if ( null == $login_id ) return array();

        // get belong project list
        $pj_temp = array();
        $query = $this->db->query("SELECT * FROM `project_belong` WHERE `login_id` = {$login_id}");
        foreach ( $query->result_array() as $p )
        {
            $pj_temp[] = $p['group_id'];
        }

        if ( 0 == count($pj_temp) ) return array();
        $pj = array();
        // $query = $this->db->query("SELECT * FROM `project_master` WHERE `id` = {$pj_temp}");
        $this->db->where_in('id', $pj_temp);
        $query = $this->db->get('project_master');
        foreach ( $query->result_array() as $p )
        {
            $pj[$p['id']] = $p;
        }

        return $pj;
    }

    /*
     * count user tweet data
     */
    function count_prof($id)
    {
        $cn = array(
            'tweet'=>0,
            'follow'=>0,
            'follower'=>0
        );

        $this->db->where('login_id', $id);
        $cn['follow'] = $this->db->count_all_results('follow');

        $this->db->where('honor', $id);
        $cn['follower'] = $this->db->count_all_results('follow');

        $this->db->where('login_id', $id);
        $cn['tweet'] = $this->db->count_all_results('stream');

        return $cn;
    }

    /*
     * post_ranking_group();
     * most post tweet ranking.
     */
    function post_most_ranking()
    {
        $query = $this->db->query('SELECT COUNT(*) as `line`,`group_id` FROM `project_belong` GROUP BY `group_id` ORDER BY `line` DESC LIMIT 0, 15');
        return $query->result_array();
    }

    function user_most_ranking()
    {
        $query = $this->db->query('SELECT COUNT(*) as `line`,`group_id` FROM `stream` WHERE `tweet_class` = 3 AND `post_date` BETWEEN \''.date("Y-m-d H:i:s", strtotime("-1 week")).'\' AND \''.date('Y-m-d H:i:s').'\' GROUP BY `group_id` ORDER BY `line` DESC LIMIT 0, 15');
        return $query->result_array();
    }


    /*
     * org_list();
     * get organization lists.
     */
    function org_list()
    {
        $query = $this->db->query('SELECT * FROM `organization`');
        $org = array();
        foreach ( $query->result_array() as $o )
        {
            $org[$o['id']] = $o['belong'];
        }

        return $org;
    }

} // end Class
