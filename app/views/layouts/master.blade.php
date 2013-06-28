<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@section('title') 
{{ Variable::get('sitename') }}@show</title>
    @section('vendor-styles')
      {{ HTML::style('vendor/bootstrap/css/bootstrap.css') }}
      {{ HTML::style('vendor/bootplus/css/bootplus.css') }}
      {{ HTML::style('vendor/font-awesome/css/font-awesome.min.css') }}
      <!--[if IE 7]>
        {{ HTML::style('vendor/font-awesome/css/font-awesome-ie7.min.css') }}
      <![endif]-->
    @show
    @section('styles')
      {{ HTML::style('css/style.css') }}
    @show
    <!--[if lt IE 9]>
      <?php echo HTML::script('vendor/html5shiv/html5shiv-printshiv.js'); ?>
    <![endif]-->
  </head>
  <body>
    <div class="page-wrap">
      <div class="navbar navbar-static-top navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <div class="nav-collapse collapse">
              <?php echo link_to('/', '山海经', array('class' => 'brand')); ?>
              <form class="navbar-search">
                <input type="text" class="search-query" placeholder="Search">
              </form>
              <div class="pull-right">
                <ul class="nav">
                  <?php if (Sentry::check()): $_num_noti = count($notifications); ?>

                  <li class="dropdown notification num{{ $_num_noti }}">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="icon-bell"></i> <span>{{ $_num_noti }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php if ($_num_noti > 0): ?>
                        <?php foreach ($notifications as $noti): ?>
                          <li><?php echo link_to('notification/' . $noti->id, $noti->msg); ?></li>
                        <?php endforeach; ?>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-ok"></i> Mark all as read</a></li>
                      <?php endif; ?>
                      <li><a href="#"><i class="icon-eye-open"></i> View all notifications</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="<?php echo url('user/'.Sentry::getUser()->username); ?>">
                      <img src="<?php echo Sentry::getUser()->getAvatar(20); ?>" alt="" />
                      {{{ Sentry::getUser()->username }}}
                    </a>
                  </li>
                  <li><?php echo link_to('account/logout', 'Logout'); ?></li>
                  <?php else: ?>
                  <li><?php echo link_to('account/login', 'Login'); ?></li>
                  <li><?php echo link_to('account/register', 'Register'); ?></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container page-content">
        @yield('content')
      </div>
      <div class="page-wrap-push"></div>
    </div>
    <footer class="footer">
      <div class="container">
        <p>Shanhaijing is a opensource forum appliaction.</p>
        <p>The source code is hosted on <a href="https://github.com/harryxu/shanhaijing" target="_blank">github</a>.</p>
        <p>Sponsored by <a href="http://bigecko.com" target="_blank">bigecko.com</a></p>
      </div>
    </footer>

    @section('scripts')
      <?php echo HTML::script('vendor/jquery/jquery-1.10.1.min.js'); ?>
      <?php echo HTML::script('vendor/bootstrap/js/bootstrap.min.js'); ?>
      <?php echo HTML::script('vendor/parsleyjs/parsley.js'); ?>
    @show
  </body>
</html>
