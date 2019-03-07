<section class="tool-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12 clean">
                            <div class="panel-heading">
                                <h3><i class="fa fa-wrench"></i>
                                    <?php
                                    if (property_exists($info, 'full_name')) {

                                        echo $info->full_name;
                                    }
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ( property_exists($page, 'content') ) {
                        
                        echo $page->content;
                        
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="addrep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <?php echo form_open('#', array('class' => 'add-reply')); ?>
                <div class="row">
                    <div class="col-md-12">
                        <textarea placeholder="<?php echo $this->lang->line('mt57'); ?>" class="msg"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button class="pull-right btn" type="submit"><?php echo $this->lang->line('mt51'); ?></button>
                    </div>
                </div>
            <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-delete-post" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <?php echo form_open('#', array('class' => 'set-date')); ?>
                <div class="input-group">
                    <input type="text" class="form-control schedule-deletion time-schedule" placeholder="<?php echo $this->lang->line('mt58'); ?>" required>
                    <span class="input-group-btn">
                      <button class="btn btn-success btn-circle" type="submit"><?php echo ucfirst($this->lang->line('mm114')); ?></button>
                    </span>                        
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="modal fade bs-repost-post" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <?php echo form_open('#', array('class' => 'shed-date')); ?>
                <div class="input-group">
                    <input type="text" class="form-control schedule-rep time-schedule" placeholder="<?php echo $this->lang->line('mt58'); ?>" required>
                    <span class="input-group-btn">
                      <button class="btn btn-success btn-circle" type="submit"><?php echo $this->lang->line('mt59'); ?></button>
                    </span>                        
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php
if ( property_exists($page, 'modals') ) {
    echo $page->modals;
}
?>