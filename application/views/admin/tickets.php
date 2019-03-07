<section>
    <div class="container-fluid tickets">
        <div class="row">
            <div class="col-lg-3 col-lg-offset-1">
                <div class="row">
                    <div class="col-xl-12">
                        <a href="<?php echo site_url('admin/new-faq-article') ?>" class="btn btn-success tickets-new-faq-article">
                            <i class="fas fa-plus-circle"></i>
                            <?php echo $this->lang->line('new_faq_article'); ?>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">  
                        <ul class="nav nav-pills nav-stacked labels-info inbox-divider">
                            <li>
                                <h4>
                                    <?php echo $this->lang->line('tickets'); ?>
                                </h4>
                            </li>
                            <li class="active">
                                <a data-toggle="tab" href="#all-tickets">
                                    <i class="fas fa-clone"></i> <?php echo $this->lang->line('all_tickets'); ?>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#unanswered-tickets">
                                    <i class="far fa-clone"></i> <?php echo $this->lang->line('unanswered'); ?>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#important-tickets">
                                    <i class="icon-star"></i> <?php echo $this->lang->line('important'); ?>
                                </a>
                            </li>
                            <li class=" labels-info inbox-divider">
                                <br>
                                <h4>
                                    <?php echo $this->lang->line('faq'); ?>
                                </h4>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#all-articles">
                                    <i class="fas fa-question-circle"></i> <?php echo $this->lang->line('all_articles'); ?>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#unpublished-articles">
                                    <i class="far fa-question-circle"></i> <?php echo $this->lang->line('unpublished'); ?>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#categories">
                                    <i class="fas fa-grip-vertical"></i> <?php echo $this->lang->line('categories'); ?>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-7">
                <div class="tab-content">
                    <div id="all-tickets" class="tab-pane fade in active">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="tickets-select-all" name="tickets-select-all" type="checkbox">
                                            <label for="tickets-select-all"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option mark-as-important">
                                            <i class="icon-star"></i> <?php echo $this->lang->line('important'); ?>
                                        </a>  
                                    </th>
                                    <th class="text-right">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <ul class="pagination" data-type="all-tickets">
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="unanswered-tickets" class="tab-pane fade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="tickets-select-unanswered" name="tickets-select-unanswered" type="checkbox">
                                            <label for="tickets-select-unanswered"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option mark-as-important">
                                            <i class="icon-star"></i> <?php echo $this->lang->line('important'); ?>
                                        </a>  
                                    </th>
                                    <th class="text-right">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <ul class="pagination" data-type="unanswered-tickets">
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="important-tickets" class="tab-pane fade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="tickets-select-important" name="tickets-select-important" type="checkbox">
                                            <label for="tickets-select-important"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option remove-important-mark">
                                            <i class="icon-close"></i> <?php echo $this->lang->line('remove'); ?>
                                        </a>  
                                    </th>
                                    <th class="text-right">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <ul class="pagination" data-type="important-tickets">
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="all-articles" class="tab-pane fade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="faq-articles-all-articles-select" name="faq-articles-all-articles-select" type="checkbox">
                                            <label for="faq-articles-all-articles-select"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option delete-faq-articles">
                                            <i class="icon-trash"></i> <?php echo $this->lang->line('delete'); ?>
                                        </a> 
                                    </th>
                                    <th class="text-right">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <ul class="pagination" data-type="all-faq-articles">
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="unpublished-articles" class="tab-pane fade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="faq-articles-unpublishhed-articles-select" name="faq-articles-unpublishhed-articles-select" type="checkbox">
                                            <label for="faq-articles-unpublishhed-articles-select"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option delete-faq-articles">
                                            <i class="icon-trash"></i> <?php echo $this->lang->line('delete'); ?>
                                        </a> 
                                    </th>
                                    <th class="text-right">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <ul class="pagination" data-type="unpublished-articles">
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="categories" class="tab-pane fade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="checkbox-option-select">
                                            <input id="faq-select-all-categories" name="faq-select-all-categories" type="checkbox">
                                            <label for="faq-select-all-categories"></label>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <a href="#" class="btn-option delete-categories">
                                            <i class="icon-close"></i> <?php echo $this->lang->line('delete'); ?>
                                        </a>
                                    </th>
                                    <th class="text-right">
                                        <a href="#" class="btn-option" data-toggle="modal" data-target="#new-category">
                                            <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('category'); ?>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="row">
                            <div class="col-lg-12 categories-list">
                                <?php
                                if ( $categories ) {
                                    
                                    echo '<ul class="list-group">';
                                    
                                    $subcategories = array();

                                    foreach ($categories as $category) {

                                        if ( $category->parent > 0 ) {
                                            
                                            $subcategories[$category->parent][] = $category;
                                            
                                        }

                                    }

                                    foreach ($categories as $cat) {
                                        
                                        if ( $cat->parent > 0 ) {
                                            continue;
                                        }
                                        
                                        $subcats = '';
                                        
                                        if ( isset($subcategories[$cat->category_id]) ) {
                                            
                                            $subcats = '<ul class="list-group">';
                                            
                                            foreach ( $subcategories[$cat->category_id] as $subcat ) {

                                                $subcats .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                                . '<div class="row">'
                                                                    . '<div class="col-lg-12">'
                                                                        . '<div class="checkbox-option-select">'
                                                                            . '<input id="faq-category-' . $subcat->category_id . '" name="faq-category-' . $subcat->category_id . '" type="checkbox" data-id="' . $subcat->category_id . '">'
                                                                            . '<label for="faq-category-' . $subcat->category_id . '"></label>'
                                                                        . '</div>'
                                                                            . $subcat->name
                                                                    . '</div>'
                                                                . '</div>'
                                                            . '</li>';
                                                
                                            }
                                            
                                            $subcats .= '</ul>';
                                            
                                        }

                                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                . '<div class="row">'
                                                    . '<div class="col-lg-12">'
                                                        . '<div class="checkbox-option-select">'
                                                            . '<input id="faq-category-' . $cat->category_id . '" name="faq-category-' . $cat->category_id . '" type="checkbox" data-id="' . $cat->category_id . '">'
                                                            . '<label for="faq-category-' . $cat->category_id . '"></label>'
                                                        . '</div>'
                                                        . $cat->name
                                                    . '</div>'
                                                . '</div>'
                                                . $subcats
                                            . '</li>';

                                    }                                    
                                    
                                    echo '</ul>';

                                } else {
                                    
                                    echo '<p>' . $this->lang->line('no_categories_found') . '</p>';
                                    
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>

<!-- Loader -->
<div class="page-loading">
    <div class="loading-animation-area">
        <div class="loading-center-absolute">
            <div class="object object_four"></div>
            <div class="object object_three"></div>
            <div class="object object_two"></div>
            <div class="object object_one"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/tickets', ['class' => 'create-category', 'data-csrf' => $this->security->get_csrf_token_name()]) ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('new_category'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control category-parent">
                            <option value="0"><?php echo $this->lang->line('select_category'); ?></option>
                            <?php
                            if ( $categories ) {
                                
                                foreach ($categories as $category) {
                                    
                                    if ( $category->parent > 0 ) {
                                        continue;
                                    }
                                    
                                    echo '<option value="' . $category->category_id . '">' . $category->name . '</option>';
                                    
                                }
                                
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                        $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
                        foreach ( $languages as $language ) {
                            $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                            echo '<div class="form-group">'
                                    . '<input type="text" class="form-control category-name" data-lang="' . $only_dir . '" placeholder="' . ucfirst($only_dir) . ' ' . $this->lang->line('category_name') . '" required="true">'
                                . '</div>';

                        }
                    ?>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save'); ?></button>
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>