<!-- footer.php -->

<!--<footer><p>&copy;<?=$op['copyright']?> <?=date('Y')?></p></footer>-->

<script type="text/javascript" src="<?=site_url('/');?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=site_url('/');?>js/bootstrap.js"></script>
<!-- <script type="text/javascript" src="<?=site_url('/');?>js/undspa.js?<?=date('U')?>"></script>
-->

<script type="text/javascript">

$(document).ready(function(){

$('#navi .dropdown-toggle').dropdown()
$('#main .alert').alert()

});

// ファイル添付
$('#add_post input:file').change(function () {
  $("#form_picture").removeClass("icon-picture");
  $("#form_picture").addClass("icon-ok-circle");
  $("#add_post .add-on").html("画像添付中");
});


// user follow
function follow_toggle(num, sw)
{
    $(".btn").unbind('click');
    $.get( '<?=site_url('/')?>tweet/ftoggle/', { 'target': num, 'switch': sw },
        function(data){
            if ( sw == 'on' )
                alert('フォロー完了');
            else
                alert('フォロー解除');

            location.reload();
        }
    );
    return false;
}

// project join or release
function join_pj_toggle(num, sw)
{
    $.get( '<?=site_url('/')?>tweet/otoggle/', { 'target': num, 'switch': sw },
    function(data){
        if ( sw == 'join' ) { alert('参加しました'); }
        else { alert('脱退しました'); }
        location.reload();
    });
    return false;
}

$("#tweetarea").live('focus', function() {
  $("#tweetarea").attr('rows', 3);
  $("#post_submit").show();
});
$("#add_post").live('blur', function() {
  // $("#tweetarea").attr('rows', 1);
  // $("#post").hide();
});

// replay click
$(".reply").live('click', function() {
  $("#tweetarea").val($("#tweetarea").val() + $(this).html()+' ' );
  $("#tweetarea").focus();
});

// project form 
$("#pj_form").live('focus', function() {
  $("#pj_create").show();
});

$("#pj_form").live('blur', function() {
  // $("#pj_create").hide();
});

// create projejct
$("#pj_create").click(function (){
    $.post('<?=site_url('/')?>top/createpj/', { 'pj_name': $("#pj_form").val() },
    function(data) {
        alert('"'+$("#pj_form").val()+' 作成しました');
        location.reload();
    });
    return false;
});

// close project button
$("#close_pj").mouseover(function() { $(this).addClass('btn-danger'); });
$("#close_pj").mouseout(function() { $(this).removeClass('btn-danger'); });
$("#close_pj").click(function() {
  if(window.confirm('プロジェクトを解散します\n 解散後のデータは表示されなくなります。'))
  {
    $.get('<?=site_url('/')?>tweet/gdelete/', { 'num' : <?=!empty($this->uri->rsegments[5]) ? $this->uri->rsegments[5] : '0'?>},
      function(data) { location.replace('<?=site_url('/')?>login/'); }
    );
  }
});

// project rename button
$("#edit_group").click(function() {
  var gtitle = $("#p_title").html(); 
  $("#edit_group").hide();
  $("#gtitle_save").show();
  $("#p_title").empty();
  $("#p_title").prepend('<input id="edit_gtitle" class="span5" value="'+gtitle+'">'); 
});

$("#gtitle_save").live("click", function() {
  $.get('<?=site_url('/')?>tweet/grename/',
  {
    'name': $("#edit_gtitle").val(),
    'num' : <?=!empty($this->uri->rsegments[5]) ? $this->uri->rsegments[5] : '0'?>
  },
  function(data) {
    $("#p_title").html($("#edit_gtitle").val());
    $("#gtitle_save").hide();
    $("#edit_gtitle").remove();
    $("#edit_group").show();
  });

});

$("#regist_form").submit(function (){
  var error = false;
  $("#regist_username").removeClass("error");
  $("#regist_org").removeClass("error");
  $("#regist_id").removeClass("error");
  $("#regist_pass").removeClass("error");

  $("#error_alert").html("");
  if ( $("#name").val() == "" ) {
    $("#regist_username").addClass("error");
    $("#error_alert").append("・名前が入力されていません<br />");
    error = true;
  }
  if ( $("#org_select").val() == "none" ) {
    $("#regist_org").addClass("error");
    $("#error_alert").append("・所属が入力されていません<br />");
    error = true;
  }
  if ( $("#login_id").val() == "" ) {
    $("#regist_id").addClass("error");
    $("#error_alert").append("・IDが入力されていません<br />");
    error = true;
  }
  if ( $("#pass1").val() == "" || $("#pass2").val() == "" ) {
    $("#regist_pass").addClass("error");
    if ( $("#pass1").val() != $("#pass2").val() ) {
      $("#error_alert").append("・入力されたパスワードが異なります<br />");
    }
    else {
      $("#error_alert").append("・パスワードが入力されていません");
    }
    error = true;
  }

  if ( error == true ) {
    $("#error_alert").show();

    return false;
  }


  // check user id
  $.get( '<?=site_url('/')?>auth/idcheck/', { 'target': $("#login_id").val() },
    function(data){
  });

    if ( data == "true" ) {
      alert(data);
      return true;
    }
    else {
      alert(data);
      return false;
    }



});

// load next 20
var load_next = 20;
var method = '<?=$this->uri->rsegments[2]; ?>'
var pj = "<?= !empty($this->uri->rsegments[3]) ? $this->uri->rsegments[3] : '0'; ?>";

var method = '<?=$this->uri->rsegments[2]; ?>'
$("#load a").click(function () {
  $.get('<?=site_url('/')?>tweet/loadnext/', { 'next': load_next , 'type': method, 'pj': pj},
  function(data) {
    $("#load").before(data);
  });
  load_next += 20;
});


// load auto tweet check
// 一定時間おきに実行 now_maxとold_maxが0以外の時にアラートを出す
$(function() {
    var timer = 5000;
    var count_target = '<?=$this->uri->rsegments[2]?>';
    var now_max = '';

    $.get('<?=base_url('/')?>tweet/maxtweet/', { 'tweet' : count_target <?=!empty($this->uri->rsegments[3]) && preg_match("/^[0-9]+$/",$this->uri->rsegments[3]) ? ", 'pj' : ".$this->uri->rsegments[3] : '';?>},
        function(data) {
            now_max = data;
        });

    setInterval(function() {
        $.get('<?=base_url('/')?>tweet/maxtweet/', { 'tweet' : count_target <?=!empty($this->uri->rsegments[3]) && preg_match("/^[0-9]+$/", $this->uri->rsegments[3]) ? ", 'pj' : ".$this->uri->rsegments[3] : '';?>},
        function(data) {
            if ( data !== now_max )
            {
                $("#post_avable").remove();
                $('#add_post').after('<div id="post_avable" class="alert alert-info alert-block"><h4 class="alert-heading">新規発言が' + (parseInt(data) - parseInt(now_max)) + 'あります。</h4></div>');
            }
        });
    }, timer);
});
$("#post_avable").live('click', function(){
    location.reload();
});


</script>

</body>
</html>
