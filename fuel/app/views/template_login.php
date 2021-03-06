<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ログイン</title>

    <!-- Bootstrap Core CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />

    <!-- MetisMenu CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo Uri::base(); ?>assets/bower_components/metisMenu/dist/metisMenu.min.css" />

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
    <!-- Page Content -->
    <?php echo $content; ?>
	
	<footer>
		<div class="text-center">
			<small><?php echo Model_Sitesetting::getValue()->getFooter(); ?></small>
		</div>
	</footer>

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script type="text/javascript" src="<?php echo Uri::base(); ?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <?php echo Asset::js("sb-admin-2.js"); ?>

</body>
</html>