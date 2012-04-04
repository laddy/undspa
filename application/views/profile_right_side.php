<!-- profile_right_side.php -->

<!-- user unit -->
<? if (!empty($stream)) : ?>
<!-- stream data -->
<h3><?=$stitle;?>：<?=$count_data['tweet']?></h3>
<? foreach ( $stream as $s ) : ?>
<div class="tweet">
 <a href="<?=$users[$target_user]['login_id']?>" title="<?//=$users[$target_user]['user_name']?>" class="icon">
  <img src="<?=get_icon($users[$s['login_id']]['hash'])?>" width="48" height="48" alt="<?=$users[$target_user]['user_name']?>">
 </a>
 <div class="item">
   <div class="name">
    <a href="#"><?=$users[$target_user]['user_name']?></a>
    <span>@<?=$users[$target_user]['login_id']?></span>
   </div>
   <div class="info"><?=substr($s['post_date'], 0, -3);?></div>
 <? // 企画と課の時
  if (null != $s['group_id']) :
   if ( 3 == $s['tweet_class'] )
    echo '<span class="p_name"><i class="icon-folder-close"></i> '.$belong_pj[$s['group_id']]['pj_name']. '</span>';
   else if ( 2 == $s['tweet_class'] )
    echo '<span class="p_name"><i class="icon-map-marker"></i> '.$org_list[$target_user].'</span>';
   endif;
 ?>
 <p><?=tweet_to_html($s['tweet'])?></p>
 </div>
</div>
<? endforeach; ?>

<? else : ?>
<!-- user data -->
<div id="p_head">
<h4><span id="p_title"><?=$stitle;?></span><span id="p_member">参加 <?=$num;?> 名</span><br class="clr" /></h4>
<? if ( 'project' == $this->uri->rsegments[4] && $this->session->userdata('id') == $pj_list[$this->uri->rsegments[5]]['leader'] ) : ?>
<p class="p_edit"><a href="javascript:void(0)" style="display:none;" id="gtitle_save" class="btn btn-small"><i class="icon-ok"></i> 保存</a>
<a href="javascript:void(0)" onclick="return false;" class="btn btn-small" id="edit_group"><i class="icon-pencil"></i> グループ名を編集</a></p>
<p class="p_del"><a href="javascript:void(0)" onclick="return false;" id="close_pj" class="close" title="このグループを闇に葬る">&times;</a></p>
<? endif; ?>

</div>

<? foreach ( $st_list as $st ) : ?>
<div class="tweet">
 <a href="<?=site_url('/')?>usr/<?=$users[$st]['login_id']?>" class="icon">
  <img src="<?=get_icon($users[$st]['hash'])?>" alt="<?=$users[$st]['user_name']?>" width="48" height="48" />
 </a>
 <div class="item">
  <div class="name">
  <? // var_dump($users[$st]); ?>
  <? // var_dump($org_list); ?>
   <a href="<?=site_url('/')?>usr/<?=$users[$st]['login_id']?>"><?=$users[$st]['user_name'];?></a>
   <span class="reply">@<?=$users[$st]['login_id'];?></span>
   <span class="p_name"><i class="icon-map-marker"></i> <?=$org_list[$users[$st]['org']]?></span>
   <span class="p_link"><i class="icon-flag"></i> <?=tweet_to_html($prof_list[$st]['url']);?></span>
  </div>
  <p class="intro"><?=tweet_to_html($prof_list[$st]['intro']);?></p>
</div>
</div>
<? endforeach; ?>
<? endif; ?>

</form>

</div>

<div id="right_bar" class="span5">

<div id="project_list">
<? if ( !empty($belong_pj_target) ) : ?>
<h4><?=$users[$target_user]['user_name'];?>&nbsp;がエンジョイしてるグループ一覧</h4>
<ul class="nav nav-tabs nav-stacked">
<? foreach ( $belong_pj_target as $pj ) : ?>
  <li><a href="<?=site_url('/')?>project/<?=$pj['id']?>"><?=$pj['pj_name']?></a></li>
<? endforeach; ?>
</ul>
<? endif; ?>
</div>

<div id="associates">
 <? amazon(); ?>
</div>

</div>
</div>
</div>
<!-- /profile_right_side.php -->
