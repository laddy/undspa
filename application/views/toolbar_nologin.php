<!-- toolbar_nologin.php -->

<div id="navi" class="navbar navbar-fixed-top">
 <div class="navbar-inner">
  <div class="container">
   <div class="nav-collapse">
    <a class="brand" href="<?=site_url('/');?>">like a Twitter</a>
    <form action="<?=site_url('/');?>auth/" method="post" class="pull-right" id="login">
     <input class="input-small" type="text" placeholder="Username" name="Username">
     <input class="input-small" type="password" placeholder="Password" name="Password">
     <button class="btn btn-primary" type="submit">Log in</button>
    </form>
   </div>
  </div>
 </div>
</div>

<!-- /toolbar_nologin.php -->