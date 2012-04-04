<!-- profile_right_side_account.php -->

<form class="form-horizontal" action="<?=site_url('/')?>auth/account/" method="post" enctype="multipart/form-data" >
 <fieldset>
 <legend>1.Profile Setting</legend>
     
 <div class="control-group">
  <label for="fileInput">プロフィール画像</label>
  <div class="controls">
   <input class="input-file" id="fileInput" name="fileInput" type="file" />
  </div>
 </div>
   
 <div class="control-group">
  <label for="name">名前</label>
  <div class="controls">
   <input class="xlarge" id="name" name="name" value="<?=$this->session->userdata("user_name");?>" size="30" type="text" />
  </div>
 </div>
      
 <div class="control-group">
  <label for="normalSelect">所属部署</label>
  <div class="controls">
   <select name="orgSelect" id="orgSelect">
   <?
   $slct = '';
   foreach ( $org_list as $org ) {
    $slct = ($org['id'] == $this->session->userdata("org_id")) ? 'selected':'';
    echo "<option value=\"{$org['id']}\" {$slct}>{$org['belong']}</option>";
    }
   ?>
   </select>
  </div>
 </div>
 
 <div class="control-group">
  <label for="textarea2">自己紹介</label>
  <div class="controls">
   <textarea class="span5" id="textarea2" name="intro"  rows="3"><?=$prof[$this->session->userdata('id')]['intro']?></textarea>
  </div>
 </div>

 <div class="control-group">
  <label for="url">URL</label>
  <div class="controls">
   <input class="input-xlarge" id="url" name="url" size="30" type="text" value="<?=$prof[$this->session->userdata('id')]['url']?>" />
  </div>
 </div>
</fieldset>
<fieldset>
 <legend>2.Login Setting</legend>

 <div class="control-group">
  <label for="url">ユーザーID</label>
  <div class="controls">
   <input class="input-small" size="30" type="text" name="user_id" value="<?=$this->session->userdata("login_id");?>" disabled="disabled" /> @mx1.wiseman.co.jp
  </div>
 </div>
 
 <div class="control-group">
  <label for="url">パスワード</label>
  <div class="controls">
   <input class="input-small" id="pass1" name="pass1" size="30" type="password" />
   <input class="input-small" id="pass2" name="pass2" size="30" type="password" />
   <p class="help-block">誤登録回避のため、二回入力してください。</p>
  </div>
 </div>
</fieldset>

 <div class="form-actions">
  <input type="submit" class="btn btn-primary" value="Save changes">
 </div>
</form>

</div>

<div id="right_bar" class="span5">

<div id="project_list">
<? if ( !empty($belong_pj) ) : ?>
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
<!-- /profile_right_side_account.php -->
