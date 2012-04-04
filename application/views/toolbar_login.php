<!-- toolbar_login.php -->

<div id="navi" class="navbar navbar-fixed-top">
 <div class="navbar-inner">
  <div class="container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="i-bar"></span> <span class="i-bar"></span><span class="i-bar"></span> </a>
   <div class="nav-collapse">
    <ul class="nav pills">
     <li <?=$tabslct['top']?>><a href="<?=site_url('/')?>login/">Home</a></li>
     <li <?=$tabslct['reply']?>><a href="<?=site_url('/')?>reply/">@You</a></li>
     <li <?=$tabslct['org']?>><a href="<?=site_url('/')?>organize/">Section</a></li>
     <li class="dropdown <?=$tabslct['prj'][0]?>" id="menu1"><a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">Groups<b class="caret"></b></a>
      <ul class="dropdown-menu">
      <?
       if ( !empty($pj_list) )
        foreach ( $pj_list as $p )
         echo '<li><a href="' . site_url('/').'project/'.$p['id'].'"><i class="icon-folder-close"></i> '.$p['pj_name'].'</a></li>';
      ?>
      </ul>
     </li>
     <li <?=$tabslct['all']?>><a href="<?=site_url('/')?>all/">All</a></li>
    </ul>
    <form class="form-search pull-left" action="<?=site_url('/')?>login/" method="get">
     <input type="text" class="input-medium search-query" name="search" value="<?=$search;?>" placeholder="Search" />
    </form>
    <ul class="nav pull-right">
     <li id="fat-menu" class="dropdown <?=(""==$tabslct['slt'])?'':'active';?>">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">設定<b class="caret"></b></a>
      <ul class="dropdown-menu">
       <li><a href="<?=site_url('/').'usr/'.$this->session->userdata('login_id');?>/tweet/"><i class="icon-star"></i> 自分のツイートを確認</a></li>
       <li class="divider"></li>
       <li><a href="<?=site_url('/').'usr/'.$this->session->userdata('login_id');?>/follow/"><i class="icon-ok"></i> フォロー管理</a></li>
       <li><a href="<?=site_url('/').'usr/'.$this->session->userdata('login_id');?>/follower/"><i class="icon-eye-open"></i> フォロアーの確認</a></li>
       <? if ( (0 < @count($belong_pj)) ) : $temp = array_shift($belong_pj); ?>
       <li><a href="<?=site_url('/').'usr/'.$this->session->userdata('login_id');?>/project/<?=$temp['id']?>"><i class="icon-folder-close"></i> グループ管理</a></li>
       <? endif; ?>
       <li class="divider"></li>
       <li><a href="<?=site_url('/').'usr/'.$this->session->userdata('login_id');?>/account/"><i class="icon-user"></i> アカウント設定</a></li>
       <li class="divider"></li>
       <li><a href="<?=site_url('/');?>auth/logout/"><i class="icon-ban-circle"></i> ログアウト</a></li>
      </ul>
     </li>
    </ul>
   </div>
  </div>
 </div>
</div>

<!-- /toolbar_login.php -->
