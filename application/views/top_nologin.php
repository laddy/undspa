<!-- top_nologin.php -->

<div id="no_login" class="container">

<div id="intro">
 <div id="main">
  <p id="regist"><a href="<?=site_url('/');?>regist/" class="btn btn-primary btn-xxlarge">新規登録はこちら（1分で登録完了）</a></p>
  <p id="getchrome"><a href="http://www.google.co.jp/chrome/" class="btn btn-primary btn-xxlarge">まずは Google Chlome をダウンロード（5分で完了）</a>
 </div>
 <div class="row">
  <div class="span4">
   <div class="point">
    <h4>気軽に参加できる安心の社内SNS風</h4>
    <p>社内限定のSNSなので、どんな人が使ってるか大体把握できます。</p>
   </div>
  </div>
  <div class="span4">
   <div class="point">
    <h4>Twitterっぽい機能満載でなんとなく使える</h4>
    <p>使い方が…という人は、<a href="http://twinavi.jp/guide/section/twitter/step0" target="_blank">Twitterの使い方</a>を確認すれば大体わかる。</p>
   </div>
  </div>
  <div class="span4">
   <div class="point">
    <h4>色々な趣味趣向の人でつながれます。</h4>
    <p>共通の話題を投稿できるグループ機能で、気軽に情報共有できます。</p>
   </div>
  </div>
 </div>
</div>

 <div class="row">
  <div id="main" class="span7">

   <div id="main_head">
    <h3>最新のTweet20件  <small>公開されている投稿が表示されています</small></h3>
   </div>
   <hr />

<!-- start straem -->
<? foreach ( $stream as $s ) : ?>
<div class="tweet"><a href="javascript:void(0);" class="icon"><img src="<?=get_icon($users[$s['login_id']]['hash'])?>" width="48" height="48" alt="" /></a>
 <div class="item">
  <div class="name">
   <a href="javascript:void(0);"><?=$users[$s['login_id']]['user_name']?></a>
   <a href="javascript:void(0);"><span>@<?=$users[$s['login_id']]['login_id']?></span></a>
  </div>
  <div class="info"><?=substr($s['post_date'], 0, -3);?></div>
  <p><?=tweet_to_html($s['tweet'])?></p>
   <?=('' != $s['img_pass']) ? outputImgTag($s['img_pass'], $s['post_date'], $this->config->item('img_pass')) : '';?> 
 </div>
</div>
<? endforeach; ?>

<!-- end stream -->

</div>

<!-- right pain -->
<div class="span5" id="right_bar">
<h3>発言が多いグループ</h3>
<ul class="nav nav-tabs nav-stacked">
<? foreach ( $pop as $p ) : ?>
<li><a href="javascript:void(0);"><?=$pj_list[$p['group_id']]['pj_name']?></a></li>
<? endforeach; ?>
</ul>

<h3>参加者が多いグループ</h3>
<ul class="nav nav-tabs nav-stacked">
<? foreach ( $upop as $p ) : ?>
  <li><a href="javascript:void(0);"><?=$pj_list[$p['group_id']]['pj_name']?></a></li>
<? endforeach; ?>
</ul>

</div>
<!-- /right pain -->

 </div>
</div>

<!-- /top_nologin.php -->
