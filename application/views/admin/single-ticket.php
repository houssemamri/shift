<section>
    <div class="container-fluid single-ticket">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-2">
                <ul class="nav nav-tabs">
                    <li>
                        <h3>
                            <?php echo $this->lang->line('last_tickets'); ?>
                        </h3>
                        <ul class="list-group">
                            <?php
                            if ( $tickets ) {
                                
                                foreach ( $tickets as $tick ) {
                                    
                                    ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/tickets/' . $tick->ticket_id) ?>">
                                            <?php echo $tick->subject; ?>
                                        </a>
                                    </li>
                                    <?php
                                    
                                }
                                
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="settings-list">
                    <div class="tab-content">
                        <div class="tab-pane fade in show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo site_url('admin/tickets') ?>">
                                                <?php echo $this->lang->line('all_tickets'); ?>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <?php
                                                echo @$ticket[0]->subject;
                                            ?>
                                        </li> 
                                    </ol>
                                </div>
                                <div class="panel-body">
                                    <div class="article">
                                        <h1 class="title">
                                            <?php
                                            echo @$ticket[0]->subject;
                                            ?>
                                        </h1>
                                        <p>
                                        <?php
                                        echo @$ticket[0]->body;
                                        ?>   
                                        </p>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="ticket_status">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p>
                                                    <?php echo $this->lang->line('status'); ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-danger dropdown-toggle ticket-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?php
                                                        if ( (int)$ticket[0]->status > 0 ) {

                                                            echo $this->lang->line('active');

                                                        } else {

                                                            echo $this->lang->line('closed');

                                                        }
                                                        ?>
                                                    </button>
                                                    <div class="dropdown-menu change-ticket-status">
                                                        <a class="dropdown-item" href="#" data-id="1">
                                                            <?php echo $this->lang->line('active'); ?>
                                                        </a>                                                        
                                                        <a class="dropdown-item" href="#" data-id="0">
                                                            <?php echo $this->lang->line('closed'); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment-form">
                    <div class="comment-form-area">
                        <?php echo form_open('admin/tickets/' . $tick->ticket_id, array('class' => 'submit-ticket-reply', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                            <textarea placeholder="<?php echo $this->lang->line('enter_your_reply_here'); ?>" class="reply-body"></textarea>
                            <input type="hidden" class="reply-ticket-id" value="<?php echo $ticket[0]->ticket_id; ?>"> 
                            <button type="submit" class="btn btn-success green">
                                <i class="fa fa-share"></i>
                                <?php echo $this->lang->line('reply'); ?>
                            </button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div class="replies-list">
                    <div class="ticket-replies">
                        
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>