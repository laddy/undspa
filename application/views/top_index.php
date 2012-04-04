<!-- top_index.php -->

<div id="content" class="container">
 <div class="row">
  <div id="main" class="span7">

   <div id="main_head">
    <h3 class="pull-left"><?=$category_title?></h3>
     <? if ( 'project' == $this->uri->rsegments[2] ) : ?>
      <? if ( isPjJoin($belong_pj, $this->uri->rsegments[3]) ) : ?>
       <a href="javascript:join_pj_toggle(<?=$this->uri->rsegments[3]?>, 'withdraw');" class="btn btn-small">グループから脱退</a>
      <? else : ?>
       <a href="javascript:join_pj_toggle(<?=$this->uri->rsegments[3]?>, 'join');" class="btn btn-small btn-primary">グループに参加</a>
      <? endif; ?>
     <? endif; ?>
   </div>

<!-- tweet area window Start -->
<? if ( 'project' != $this->uri->rsegments[2] || @(isPjJoin($belong_pj, $this->uri->rsegments[3]))) : ?>
<form id="add_post" action="<?=site_url('/')?>tweet/write/" method="post" class="form-horizontal" enctype="multipart/form-data">
 <textarea name="tweet" class="input-xlarge span7" id="tweetarea" rows="1" placeholder="Tweetする"></textarea>
  <div id="post_submit" style="display:none;">
   <span class="add-on">
   </span>
   <input type="file" name="upfile" id="pic_upload">
   <i id="form_picture" class="icon-picture"> </i>
   <select id="stackedSelect" name="range" class="span4">
    <optgroup label="Tweetの範囲">
     <option value="open" <?=$tslctd['top']?>>普通のTweet</option>
     <!-- <option value="follow">フォロワーのみ</option> -->
     <option value="org" <?=$tslctd['org']?>><?=$org_name?>向けのTweet</option>
    </optgroup>
    <? 
     if ( !empty($belong_pj) ) :　// output joined pj list
    ?>
    <optgroup label="Groupの指定">
    <?
      foreach ( $belong_pj as $p ) {
      $slct = ( 'active' == $tslctd['prj'][0] && $tslctd['prj'][1] == $p['id'] ) ? 'selected' : ''; 
       echo "<option value=\"project-{$p['id']}\" {$slct}>{$p['pj_name']}</option>\n";
      }
    ?>
    </optgroup>
    <? endif; ?>
   </select>
   <input type="submit" class="btn btn-primary" value="Tweet">
  </div>
 </form>
<? endif; ?>
<!-- tweet area window End -->


<hr class="clr" />


<!-- start straem -->
<? foreach ( $stream as $s ) : ?>
<div class="tweet">
 <a href="<?=site_url('/').'usr/'.$users[$s['login_id']]['login_id']?>" title="<?=$users[$s['login_id']]['user_name']?>" class="icon">
<img src="<?=get_icon($users[$s['login_id']]['hash'])?>" width="48" height="48" alt="<?=$users[$s['login_id']]['user_name']?>">
</a>
 <div class="item">
  <div class="name">
   <a href="<?=site_url('/').'usr/'.$users[$s['login_id']]['login_id']?>"><?=$users[$s['login_id']]['user_name']?></a>
   <a href="javascript:void(0);" title="投稿者名宛にツイート"><span class="reply">@<?=$users[$s['login_id']]['login_id']?></span></a>
  </div>
<div class="info"><?=substr($s['post_date'], 0, -3);?></div>
<? // 企画と課の時
 if (null != $s['group_id']) : 
   if ( 3 == $s['tweet_class'] )
    echo '<span class="p_name"><i class="icon-folder-close"></i> '.$pj_list[$s['group_id']]['pj_name']. '</span>';
   else if ( 2 == $s['tweet_class'] )
    echo '<span class="p_name"><i class="icon-map-marker"></i> '.$org_name. '</span>';
   endif;
  ?>
<p><?=tweet_to_html($s['tweet'])?></p>
<?=('' != $s['img_pass']) ? outputImgTag($s['img_pass'], $s['post_date'], $this->config->item('img_pass')) : '';?>
 </div>
</div>
<? endforeach; ?>
<!-- end stream -->

<div id="load"><a href="javascript:void(0);" class="btn">次の20件を読み込み</a></div>

</div>

<!-- right pain -->
<div id="right_bar" class="span5">

 <div id="me">
  <p><img src="<?=get_icon($users[$this->session->userdata('id')]['hash'])?>" width="48" height="48" alt="<?=$this->session->userdata('user_name')?>"></p>
  <div id="status">
  <h3><a href="<?=site_url('/').'usr/'.$users[$this->session->userdata('id')]['login_id']?>"><?=$this->session->userdata('user_name');?></a></h3>
  <h5>@<?=$this->session->userdata('login_id');?></h5>
  <ul class="spec">
   <li><a href="<?=site_url('/').'usr/'.$users[$this->session->userdata('id')]['login_id']?>/tweet/"><?=$count_data['tweet']?></a><span>Tweet</span></li>
   <li><a href="<?=site_url('/').'usr/'.$users[$this->session->userdata('id')]['login_id']?>/follow/"><?=$count_data['follow']?></a><span>Follow</span></li>
   <li><a href="<?=site_url('/').'usr/'.$users[$this->session->userdata('id')]['login_id']?>/follower/"><?=$count_data['follower']?></a><span>Follower</span></li>
  </ul>
  <br class="clr" />
  </div>
  <hr />
 </div>

<div id="project_list">
 <? if ( !empty($belong_pj) ) : ?>
 <h4>エンジョイしてるグループ一覧</h4>
 <ul class="nav nav-tabs nav-stacked">
 <? foreach ( $belong_pj as $pj ) : ?>
  <li><a href="<?=site_url('/')?>project/<?=$pj['id']?>"><?=$pj['pj_name']?></a></li>
 <? endforeach; ?>
 </ul>
 <? endif; ?>
 <form onsubmit="return false;" id="add_group">
  <input type="text" class="span4 pull-left" id="pj_form" placeholder="追加グループ名入力" />
  <span class="btn  btn-primary" style="display:none;" id="pj_create">Add Group</span>
 </form>
</div>

<div id="associates">
 <? amazon(); ?>
</div>

</div>
</div>
</div>

<!-- /top_index.php -->
