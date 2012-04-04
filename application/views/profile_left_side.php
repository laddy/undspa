<!-- profile_left_side.php -->

<div class="container">
<div class="row">

<!-- 上側 -->
<div id="main" class="span7">

<div id="me">
<p><img src="<?=get_icon($users[$target_user]['hash'])?>" width="128" height="128" alt="<?=$users[$target_user]['user_name'];?>" /></p>
<div id="status">
<?
 if ( $this->session->userdata('login') ) {
 if ( $this->session->userdata('id') != $target_user ) :
  if (isFollow($follower_list, $this->session->userdata('id')) )
   echo '<a class="btn pull-right" href="javascript:follow_toggle('.$target_user.',\'off\');">UnFollow</a>';
   else
    echo '<a class="btn btn-primary pull-right" href="javascript:follow_toggle('.$target_user.',\'on\');">Follow</a>';
  endif;
 }
?>

 <h3><?=$users[$target_user]['user_name'];?></h3>
 <h5>@<?=$users[$target_user]['login_id'];?></h5>
 <ul class="spec">
  <li><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/tweet/"><?=$count_data['tweet'];?></a><span>Tweet</span></li>
  <li><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/follow/"><?=$count_data['follow'];?></a><span>Follow</span></li>
  <li><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/follower/"><?=$count_data['follower'];?></a><span>Follower</span></li>
 </ul>
 <br class="clr" />
 <div id="user_info">
  <p class="comment"><?=$target_prof[$target_user]['intro']?></p>
  <a href="<?=$target_prof[$target_user]['url']?>" target="_blank"><i class="icon-flag"></i> <?=$target_prof[$target_user]['url']?></a>
  <p><i class="icon-map-marker"></i> <?=$target_org[0]['belong']?></p>
  </div>
 </div>
 <br class="clr" />
</div>

<ul id="tabs" class="nav nav-tabs">
 <li <?=$tab_select['tweet']?>><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/tweet/">Tweet</a></li>
 <li <?=$tab_select['follow']?>><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/follow/">Follow</a></li>
 <li <?=$tab_select['follower']?>><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/follower/">Follower</a></li>
 <li class="dropdown <?=('' != $tab_select['project']) ? 'active' : '';?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Groups<b class="caret"></b></a>
 <? if ( !empty($belong_pj_target) ) : ?>
  <ul class="dropdown-menu">
  <? foreach ( $belong_pj_target as $pj ) : ?>
   <li><a href="<?=site_url('/')?>usr/<?=$users[$target_user]['login_id']?>/project/<?=$pj['id']?>"><i class="icon-folder-close"></i> 
   <?=($pj['leader'] == $this->session->userdata('id')) ? '管理: ' : '';?><?=$pj['pj_name']?></a></li>
 <? endforeach; ?>
  </ul>
 <? endif; ?>
 </li>
 <? if ( TRUE === $myprof ) : ?>
 <li <?=$tab_select['account']?>><a href="<?=site_url('/');?>usr/<?=$users[$target_user]['login_id']?>/account/">Setting</a></li>
 <? endif; // End setting_menu ?>
</ul>

<!-- /profile_left_side.php -->
