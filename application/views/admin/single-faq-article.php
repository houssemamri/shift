<section>
    <div class="container-fluid single-faq-article">
        <?php echo form_open('admin/faq-articles/' . $article['article'][0]->article_id, ['class' => 'update-faq-article', 'data-csrf' => $this->security->get_csrf_token_name()]) ?>
            <div class="row">
                <div class="col-lg-7 col-lg-offset-1">
                    <?php

                    $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);

                    $first_dir = str_replace(APPPATH . 'language' . '/', '', $languages[0]);

                    if ( count($languages) > 1 ) {

                        echo '<ul class="nav nav-tabs nav-justified">';

                        $a = 0;

                        foreach ( $languages as $language ) {

                            $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                            $active = '';

                            if ( $a < 1 ) {

                                $active = ' class="active"';
                                $a++;

                            }

                            echo '<li' . $active . '><a data-toggle="tab" href="#' . $only_dir . '">' . ucfirst($only_dir) . '</a></li>';


                        }

                        echo '</ul>';

                    }

                    ?>
                    <div class="tab-content tab-all-editors">
                        <div id="<?php echo $first_dir; ?>" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control input-form msg-title" placeholder="<?php echo $this->lang->line('enter_article_title'); ?>" value="<?php echo @$article['data'][$first_dir]['title']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="summernote" class="summernote-body body-<?php echo $first_dir; ?>" data-dir="body-<?php echo $first_dir; ?>"></div>
                                    <textarea class="msg-body content-body-<?php echo $first_dir; ?> hidden"><?php echo @$article['data'][$first_dir]['body']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php
                        $b = 0;

                        foreach ( $languages as $language ) {

                            $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                            if ( $b < 1 ) {
                                $b++;
                                continue;
                            }

                            echo '<div id="' . $only_dir . '" class="tab-pane fade">'
                                    . '<div class="row">'
                                        . '<div class="col-lg-12">'
                                            . '<input type="text" class="form-control input-form msg-title" placeholder="' . $this->lang->line('enter_article_title') . '" value="' . @$article['data'][$only_dir]['title'] . '">'
                                        . '</div>'
                                    . '</div>'
                                    . '<div class="row">'
                                        . '<div class="col-lg-12">'
                                            . '<div id="summernote" class="summernote-body body-' . $only_dir . '" data-dir="body-' . $only_dir . '"></div>'
                                            . '<textarea class="msg-body content-body-' . $only_dir . ' hidden">' . @$article['data'][$only_dir]['body'] . '</textarea>'
                                        . '</div>'
                                    . '</div>'
                                . '</div>';


                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="article-status">
                                        <option value="1"<?php if ($article['article'][0]->status > 0): echo ' selected'; endif; ?>>
                                            <?php echo $this->lang->line('publish'); ?>
                                        </option>
                                        <option value="0"<?php if ($article['article'][0]->status < 1): echo ' selected'; endif; ?>>
                                            <?php echo $this->lang->line('draft'); ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success save-article" data-id="<?php echo $article['article'][0]->article_id; ?>">
                                        <?php echo $this->lang->line('save'); ?>
                                    </button>
                                </div>                            
                            </div>                        
                            <hr>
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
                                                    
                                                    $checked = '';
                                                    
                                                    if ( in_array($subcat->category_id, $article['categories']) ) {
                                                        $checked = ' checked="checked"';
                                                    }

                                                    $subcats .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                                    . '<div class="row">'
                                                                        . '<div class="col-lg-12">'
                                                                            . '<div class="checkbox-option-select">'
                                                                                . '<input id="faq-category-' . $subcat->category_id . '" name="faq-category-' . $subcat->category_id . '" type="checkbox" data-id="' . $subcat->category_id . '"' . $checked . '>'
                                                                                . '<label for="faq-category-' . $subcat->category_id . '"></label>'
                                                                            . '</div>'
                                                                                . $subcat->name
                                                                        . '</div>'
                                                                    . '</div>'
                                                                . '</li>';

                                                }

                                                $subcats .= '</ul>';

                                            }
                                            
                                            $checked = '';

                                            if ( in_array($cat->category_id, $article['categories']) ) {
                                                $checked = ' checked="checked"';
                                            }

                                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                    . '<div class="row">'
                                                        . '<div class="col-lg-12">'
                                                            . '<div class="checkbox-option-select">'
                                                                . '<input id="faq-category-' . $cat->category_id . '" name="faq-category-' . $cat->category_id . '" type="checkbox" data-id="' . $cat->category_id . '"' . $checked . '>'
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
        <?php echo form_close() ?>
    </div>
</section>