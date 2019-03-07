<section class="faq-categories">
    <div class="container-fluid">    
        <div class="row">
            <div class="col-xl-2 offset-xl-2">
                <ul class="nav nav-tabs">
                    <?php
                    $subcategories = array();

                    foreach ($categories as $category) {

                        if ( $category->parent > 0 ) {

                            $subcategories[$category->parent][] = $category;

                        }

                    }

                    $category = '';
                    $parent_name = '';

                    foreach ($categories as $cat) {

                        if ( $cat->category_id !== $category_id && $cat->parent !== $category_id && $cat->category_id !== $parent ) {
                            continue;
                        }
                        
                        if ( $cat->parent > 0 ) {
                            continue;
                        }                        

                        $subcats = '';

                        if ( isset($subcategories[$cat->category_id]) ) {

                            $subcats = '<ul class="list-group">';

                            foreach ( $subcategories[$cat->category_id] as $subcat ) {
                                
                                if ( $subcat->category_id === $category_id ) {
                                    
                                    $parent_name = $subcat->name;
                                    
                                }

                                $subcats .= '<li class="nav-item">'
                                                . '<a href="' . site_url('user/faq-categories/' . $subcat->category_id) . '">'
                                                    . $subcat->name
                                                . '</a>'
                                            . '</li>';

                            }

                            $subcats .= '</ul>';

                        }

                        $category = $cat->name;

                        echo '<li>'
                                . '<h3>'
                                    . $cat->name
                                . '</h3>'
                                . $subcats
                            . '</li>';

                    }
                    ?>
                </ul>
            </div>
            <div class="col-xl-6">
                <div class="settings-list">
                    <div class="tab-content">
                        <div class="tab-pane container fade active show" id="main-settings">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo site_url('user/faq-page') ?>">
                                                    <?php echo $this->lang->line('support_center'); ?>
                                                </a>
                                            </li>
                                            <?php
                                            if ( $parent < 1 ) {
                                                ?>
                                                <li class="breadcrumb-item">
                                                    <?php
                                                    echo $category;
                                                    ?>
                                                </li>
                                                <?php
                                            } else {
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo site_url('user/faq-categories/' . $parent) ?>">
                                                    <?php
                                                    echo $category;
                                                    ?>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <?php
                                                echo $parent_name;
                                                ?>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        <?php
                                        if ( $articles ) {
                                            
                                            foreach ( $articles as $article ) {
                                                
                                                echo '<li>'
                                                        . '<a href="' . site_url('user/faq-article/' . $article->article_id) . '">'
                                                            . '<i class="far fa-file-alt"></i> ' . $article->title
                                                        . '</a>'
                                                    . '</li>';
                                                
                                            }
                                            
                                        } else {
                                            
                                            echo '<li>'
                                                    . '<p>'
                                                        . $this->lang->line('no_articles_found')
                                                    . '</p>'
                                                . '</li>';
                                            
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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