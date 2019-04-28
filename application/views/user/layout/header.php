<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->config->item('site_name') ?> | <?php echo isset($title)?$title:ucwords(str_replace('_',' ',$this->router->fetch_method())); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?php
        $favicon = get_option('favicon');
        if ($favicon): echo $favicon;
        else: echo '/assets/img/favicon.png';
        endif;
        ?>" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">

        <!-- Simple Line Icons -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

        <!-- Midrub CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/style.css?ver=<?php echo MD_VER; ?>" media="all"/>
		    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/admin/css/style1.css" media="all">

        <!-- Wizard CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/smart_wizard.css?ver=<?php echo MD_VER; ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/smart_wizard_theme_arrows.css?ver=<?php echo MD_VER; ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/smart_wizard_theme_dots.css?ver=<?php echo MD_VER; ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/smart_wizard_theme_circles.css?ver=<?php echo MD_VER; ?>" media="all"/>

        <?php
        if ( isset($app_styles) ) {
            ?>
            <!-- Custom Styles -->
            <?php
            echo $app_styles;
        } else {
            echo user_custom_header();
        }

        if (file_exists( FCPATH . 'assets/user/styles/css/custom.css' ) ) {

            echo "\n"
                . "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url() . "assets/user/styles/css/custom.css?ver=" . MD_VER . "\" media=\"all\"/>"
            ."\n";
        }
        ?>
		<!-- Optional JavaScript -->
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>

    </head>
    <body>
        <div class="container-fluid">
