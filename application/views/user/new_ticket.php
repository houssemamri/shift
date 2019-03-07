<section class="tickets-page">
    <div class="container-fluid tickets">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                <div class="col-xl-12">
                    <?= form_open_multipart('user/new-ticket') ?>
                    <div class="row">
                        <div class="panel-heading">
                            <h3>
                                <i class="fa fa-life-ring"></i> <?= $this->lang->line('mi2'); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <input type="text" placeholder="<?= $this->lang->line('mi3'); ?>" name="ticket-subject" class="form-control" required="true">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control new-post" rows="5" placeholder="<?= $this->lang->line('mi4'); ?>" name="ticket-body" required="true"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" name="file" class="form-control" accept=".gif,.jpg,.jpeg,.png,.mp4,.avi,webm">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right btn-edit"> <?= $this->lang->line('mi5'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h3>
                                <i class="fa fa-question-circle-o"></i>
                                <?= $this->lang->line('mu8'); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="input-group search">
                                <input type="text" placeholder="<?= $this->lang->line('mi1'); ?>" class="form-control search_post">
                                <span class="input-group-btn search-m">
                                    <button class="btn" type="button"><i class="fa fa-binoculars"></i><i class="fa fa-times" aria-hidden="true"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row questions">
                        <div class="col-xl-12">
                            <div class="mm-single-result">
                                <h3><?= $this->lang->line('mi22'); ?></h3>
                                <p><?= $this->lang->line('mi23'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    if($res) {
        echo '<script language="javascript">window.onload = function() {' . $res . '}</script>';
    }
    ?>
</section>