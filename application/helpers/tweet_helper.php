<?php
/*
 * Created on 2012/01/30
 *
 * @author
 * Yuya Tanaka
 */

/*
 * @var tweet_to_html
 * usage:
 *  model Record_model->load_vital();
 *
 */
function tweet_to_html($tweet)
{
    $tweet = auto_link($tweet, 'both', TRUE);
    $tweet = nl2br($tweet);
    
    return $tweet;
}


function rand_data()
{
    // make uniqe ID
    return md5(uniqid("", 1));
}


function get_icon($hash)
{
    if ( '' == $hash || null == $hash ) {
        return site_url('/') . 'uddata/icon/dummy'.rand(1,14).'.jpg';
    }
    else {
        return site_url('/') . 'uddata/icon/' . $hash;
    }
}

function user_veridation($user, $list)
{
    // check user_login_id
    $chkeck_id = 0;
    foreach ( $list as $f )
    {   
        if ( $f['login_id'] === $user ) {
            $check_id = $f['id'];
        }
    }
    return $check_id;
}


function isPjJoin($list, $target_id)
{
    foreach ( $list as $l )
    {
   	    if ( $l['id'] == $target_id ) { return TRUE; }
    }
    return FALSE;
}


function isFollow($list, $target_user)
{
    foreach ( $list as $l ) 
    {
        if ( $target_user == $l ) return TRUE;

    }
    return FALSE;
}

function formSelected($mtd, $pjnum = '')
{
    $active = 'class="active"';
    $slctd = array();
    $slctd['top'] = ( 'top' == $mtd || 'login' == $mtd) ? $active : ''; 
    $slctd['all'] = ( 'all' == $mtd ) ? $active : '';
    $slctd['reply']  = ( 'reply' == $mtd ) ? $active : '';
    $slctd['org']    = ( 'organize' == $mtd)  ? $active : ''; 
    $slctd['prj'][0] = ( 'project' == $mtd )  ? 'active' : '';
    $slctd['prj'][1] = ( 'project' == $mtd )  ? $pjnum : ''; 

    return $slctd;
}


function tweetSelected($mtd, $pjnum = '')
{
    $active = 'selected';
    $slctd = array();
    $slctd['top'] = ( 'top' == $mtd || 'login' == $mtd) ? $active : ''; 
    $slctd['all'] = ( 'all' == $mtd ) ? $active : '';
    $slctd['reply']  = ( 'reply' == $mtd ) ? $active : '';
    $slctd['org']    = ( 'organize' == $mtd)  ? $active : ''; 
    $slctd['prj'][0] = ( 'project' == $mtd )  ? 'active' : '';
    $slctd['prj'][1] = ( 'project' == $mtd )  ? $pjnum : ''; 

    return $slctd;
}


function tabSelected($mtd, $pjnum = '')
{
    $active = ' class="active"';
    $slctd = array();
    $slctd['top'] = ( 'top' == $mtd || 'login' == $mtd) ? $active : ''; 
    $slctd['all'] = ( 'all' == $mtd ) ? $active : '';
    $slctd['reply']  = ( 'reply' == $mtd ) ? $active : '';
    $slctd['org']    = ( 'organize' == $mtd)  ? $active : ''; 
    $slctd['prj'][0] = ( 'project' == $mtd )  ? 'active' : '';
    $slctd['prj'][1] = ( 'project' == $mtd )  ? $pjnum : ''; 
    $slctd['slt']    = ( 'usr' == $mtd ) ? $active : '';

    return $slctd;
}


function streaching($pass, $salt)
{
    $pass = md5($pass);
    for ( $i = 0; $i < 1000; $i++ ) {
        $pass = md5($pass . $salt . $pass);
    }
    return $pass;
}

function outputImgTag($data, $post_date, $imgDir)
{
    $img_data = unserialize($data);
    if ( $img_data['is_image'] ) {
        $tag = '<p><a target="_blank" href="'.site_url('/').$imgDir.date('/Y/m/', strtotime($post_date)).$img_data['pass'].'"><img src="'.site_url('/').$imgDir.date('/Y/m/', strtotime($post_date)).$img_data['pass'].'" /></a></p>';
    }
    else {
        $tag = '<p><a target="_blank" href="'.site_url('/').$imgDir.date('/Y/m/', strtotime($post_date)).$img_data['pass'].'">'.$img_data['name'].'</a>';
    }

    return ($tag);
}


function amazon()
{
    echo <<< AMAZON
    <iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=wenorama-22&o=9&p=30&l=bn1&mode=books-jp&browse=202188011&fc1=000000&lt1=_blank&lc1=3366FF&bg1=FFFFFF&f=ifr" marginwidth="0" marginheight="0" width="350" height="600" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>

AMAZON;

}


