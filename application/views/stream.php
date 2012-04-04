<!-- stream.php -->
<? foreach ( $stream as $s ) : ?>

<div class="tweet">
<a href="<?=base_url('/')?>usr/<?=$users[$s['login_id']]['login_id']?>" title="<?=$users[$s['login_id']]['user_name']?>" class="icon">
<img src="<?=get_icon($users[$s['login_id']]['hash'])?>" width="48" height="48" alt="<?=$users[$s['login_id']]['user_name']?>">
</a>
<div class="item">
<div class="name">
<a href="<?=base_url('/')?>usr/<?=$users[$s['login_id']]['login_id']?>"><?=$users[$s['login_id']]['user_name']?></a>
<a href="javascript:void(0);" title="投稿者名宛にツイート"><span class="reply">@<?=$users[$s['login_id']]['login_id']?></span></a>
</div>
<div class="info"><?=substr($s['post_date'], 0, -3);?></div>
<?
if (null != $s['group_id']) :
    if ( 3 == $s['tweet_class'] )
        echo '<span class="p_name"><i class="icon-folder-close"></i> '.$pj_list[$s['group_id']]['pj_name']. '</span>';
    else if ( 2 == $s['tweet_class'] )
        echo '<span class="p_name"><i class="icon-map-marker"></i> '.$org_name. '</span>';
endif;
?>
<p><?=tweet_to_html($s['tweet'])?></p>
</div>
</div>

<? endforeach; ?>
<!-- /stream.php -->

