<?php
/*
 * view/regist.php
 * @YuyaTanaka
 * Created on 2012/01/30
 * 
 * regist user form view.
 */
?>
<!-- regist.php -->

<div class="container">

<div class="row">
<div id="main" class="span7">

<form class="form-horizontal" id="regist_form" action="<?=site_url('/')?>regist/" method="post">
<fieldset>
<legend>アカウント登録</legend>
<!--
  <legend>1.Profile Setting</legend>
-->
<? /*
<div class="control-group">
 <label class="control-label" for="fileInput">プロフィール画像</label>
 <div class="controls">
  <input class="input-file" id="fileInput" name="faceImage" type="file" />
 </div>
</div>
 */ ?>

<div class="alert alert-block alert-error" style="display:none;" id="error_alert"></div>

<div class="control-group" id="regist_username">
<label class="control-label" for="name">名前</label>
<div class="controls">
<input type="text" name="user_name" class="input-large" id="name" placeholder="湯沢かずみ">
<!-- <p class="help-block">ややこしくなるので他の人の名前を入力するのはやめましょう。</p> -->
</div>
</div>

<div class="control-group" id="regist_org">
<label class="control-label" for="normalSelect">所属部署</label>
<div class="controls">
<select name="org" id="org_select">
<option value="none">所属を選択してください</option>
<?
foreach ( $org_list as $org )
	echo '<option value="' . $org['id'] .'">' . $org['belong'] . '</option>';
?>
      </select>
      </div>
     </div>
<!--
     <div class="control-group">
      <label class="control-label" for="textarea2">自己紹介</label>
      <div class="controls">
       <textarea class="span5" id="textarea2" name="intro" rows="3"></textarea>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="url">サイトURL</label>
      <div class="controls">
       <input class="input-xlarge" id="url" name="url" type="text" />
      </div>
     </div>

 </fieldset>

 <fieldset>
  <legend>2.Login Setting</legend>
-->

   <div class="control-group" id="regist_id">
    <label class="control-label" for="login_id">ID</label>
    <div class="controls">
     <input type="text" class="input-small" id="login_id" name="login_id" placeholder="KYuzawa"> @mx1.wiseman.co.jp
    </div>
   </div>

   <div class="control-group" id="regist_pass">
    <label class="control-label" for="pass">パスワード</label>
    <div class="controls">
     <input class="input-small" id="pass1" name="pass1" type="password"  placeholder="password" />
     <input class="input-small" id="pass2" name="pass2" type="password"  placeholder="password" />
     <p class="help-block">誤登録回避のため、二回入力してください。</p>
    </div>
   </div>
 </fieldset> 

 <div class="form-actions">
  <input type="submit" class="btn btn-primary" value="Make Account">
 </div>

</form>

</div>

<!-- right pain -->
<div class="span5" id="right_bar">
<div id="associates">
<? amazon(); ?>
</div>
</div>
</div>

</div>

<!-- /regist.php -->
