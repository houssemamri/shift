<section class="faq-page">
    
    <div class="container-fluid">    
        <div class="faq-page-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <div class="row">
                <div class="col-12">
                    <h2>
                        <?php echo $this->lang->line('how_can_we_help_you'); ?>
                    </h2>
                </div>
                <div class="col-xl-4 offset-xl-4 col-lg-10 offset-lg-1 col-10 offset-1">
                    <div class="custom-search-input">
                        <?php echo form_open('user/faq-page', array('class' => 'search-articles-form', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="icon-magnifier"></i>
                            </div>
                            <input type="text" class="search-articles form-control" placeholder="<?php echo $this->lang->line('search_the_knowledge_base'); ?>" />
                            <button type="button" class="cancel-search-for-articles">
                                <i class="icon-close"></i>
                            </button>
                            <div class="search-results">
                                <ul class="list-unstyled result-bucket">
                                </ul>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card-deck mb-3 row text-center">
                <?php
                if ( $categories ) {

                    foreach ($categories as $category) {

                        if ( $category->parent > 0 ) {
                            continue;
                        }
                        
                        echo '<div class="col-md-4 col-sm-12 col-12">'
                            . '<div class="card mb-4 shadow-sm">'
                                . '<div class="card-body">'
                                    . '<a href="' . site_url('user/faq-categories/' . $category->category_id) . '">' . $category->name . '</a>'
                                . '</div>'
                            . '</div>'
                        . '</div>';
                        
                    }

                }
                ?>
            </div>

        </div>
    </div>
</section>

<button type="button" class="btn btn-primary btn-help-open-ticket" data-toggle="modal" data-target="#tickets-popup">
    <i class="icon-question"></i>
    <?php echo $this->lang->line('help'); ?>
</button>

<!-- Modal -->
<div class="modal fade" id="tickets-popup" tabindex="-1" role="dialog" aria-labelledby="accounts-manager-popup" aria-hidden="true">
    <div class="modal-dialog file-upload-box modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('user/faq-page', array('class' => 'submit-new-ticket', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="modal-header">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active show" id="nav-new-ticket-tab" data-toggle="tab" href="#nav-new-ticket" role="tab" aria-controls="nav-new-ticket" aria-selected="true">
                               <?php echo $this->lang->line('new_ticket'); ?> 
                            </a>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </nav>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-new-ticket" role="tabpanel" aria-labelledby="nav-new-ticket">
                            <div class="form-group">
                                <input type="text" class="form-control ticket-subject" placeholder="<?php echo $this->lang->line('ticket_subject'); ?>" autocomplete="off" required="required">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control ticket-body" placeholder="<?php echo $this->lang->line('enter_your_question_here'); ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" data-type="main" class="btn btn-primary pull-right">
                        <?php echo $this->lang->line('submit_ticket'); ?>
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>