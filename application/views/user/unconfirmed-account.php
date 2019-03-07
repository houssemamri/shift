<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->lang->line('mu106'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/auth/img/logo.png" />
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.min.css"/>
        <style>
            .resend-confirmation
            {
                margin-bottom:25px;
            }
        </style>
    </head>
    <body>
        <div class="container-narrow">
            <div class="col-lg-12">
                <?= $this->lang->line('mu107'); ?>
                <a class="btn btn-large btn-success resend-confirmation" data-url="<?= base_url(); ?>" href="javascript:void(0)"><?= $this->lang->line('mu108'); ?></a>
                <?= form_open('login') ?>
                <?= form_close() ?>
            </div>
            <div class="col-lg-12 msg-space">

            </div>
        </div>
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
        <script src="<?= base_url(); ?>assets/auth/js/auth.js"></script>
    </body>
</html>