<?php
	$siteSetting = Model_Sitesetting::getValue();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $siteSetting->getServiceName() . ' - ' . $title ?></title>

    <!-- Bootstrap Core CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />

    <!-- MetisMenu CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/metisMenu/dist/metisMenu.min.css" />

    <!-- DataTables CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/datatables/media/css/dataTables.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css">

    <!-- Morris Charts CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/morrisjs/morris.css">
        
    <!-- Custom CSS -->
    <?php echo Asset::css("sb-admin-2.css"); ?>

    <!-- Custom Fonts -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <!-- 左上・右上設定 --> 
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">トグルメニュー</span>
                    
                    <!-- ハンバーガーメニュー -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Uri::base(); ?>console/index">
					<?php
						if (Fuel::$env == Fuel::DEVELOPMENT)
						{
							echo "<span style=\"color:#FF0000;\"> テスト環境";
							if (isset($_SERVER['DEVELOP_NOWDATE']))
							{
								echo "（" . AppDate::nowDate() . "）";
							}
							echo "</span> ";
						}
						echo $siteSetting->getServiceName(); 
					?>
				</a>
            </div><!-- /.navbar-header -->

            <!-- ユーザー設定メニュー -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo Uri::base(); ?>console/profile"><i class="fa fa-gear fa-fw"></i> ユーザー設定</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo Uri::base(); ?>console/logout"><i class="fa fa-sign-out fa-fw"></i> ログアウト</a></li>
                    </ul>
                </li>
            </ul><!-- /.navbar-top-links -->

            <!-- サイドメニュー表示 -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="#"><i class="fa fa-power-off fa-fw"></i> 端末状況<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo Uri::base(); ?>console/index"> 通信履歴一覧</a></li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <?php if (Auth::has_access('access.level2')) { ?>
                        <li>
                            <a href="#"><i class="fa fa-cogs fa-fw"></i> サーバー設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo Uri::base(); ?>console/optionsite"> 全般設定</a></li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <?php if (Auth::has_access('access.level3')) { ?>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> ユーザー設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo Uri::base(); ?>console/userlist">ユーザー一覧</a></li>
                                <li><a href="<?php echo Uri::base(); ?>console/useradd">ユーザー追加</a></li>
                                <li><a href="<?php echo Uri::base(); ?>console/usercsv">ユーザー一括追加</a></li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <?php if (Auth::has_access('access.level3')) { ?>
                        <li>
                            <a href="#"><i class="fa fa-asterisk fa-fw"></i> デバッグ<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo Uri::base(); ?>console/debugrestapi">REST API</a></li>
                            </ul><!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <li>
							<a href="#"><?php echo Asset::img('menu_logo.png', array('style' => 'text-align:center')); ?></a>
                        </li>
                    </ul>
                </div><!-- /.sidebar-collapse -->
            </div><!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header"><?php echo $title; ?></h1>
				</div>
			</div><!-- /.row -->
		
	        <?php echo $content; ?>
		
			<hr />
			<footer>
				<div class="text-center">
					<small><?php echo $siteSetting->getFooter(); ?></small>
				</div>
			</footer>
		</div><!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/morrisjs/morris.min.js"></script>
    <script type="text/javascript">
    $(function() {
        <?php
         if (isset($chart_line_data))
         {
             echo "Morris.Line(" . $chart_line_data . ");";
         }
        ?>
    });
    </script>
    
    <!-- Custom Theme JavaScript -->
    <?php echo Asset::js("sb-admin-2.js"); ?>

</body>
</html>