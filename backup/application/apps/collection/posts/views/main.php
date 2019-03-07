<?php
$CI =& get_instance();
?>
<section class="posts-page" data-up="<?php echo (get_option('upload_limit')) ? get_option('upload_limit'):'6'; ?>">  
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <?php
            if ( get_option('app_posts_enable_composer') ) {
            ?>
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-composer" role="tab" aria-controls="nav-composer" aria-selected="true">
                <?php echo $CI->lang->line('composer'); ?>
            </a>
            <?php
            }
            if ( get_option('app_posts_enable_scheduled') ) {
            ?>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#scheduled-posts" role="tab" aria-controls="scheduled-posts" aria-selected="false">
                <?php echo $CI->lang->line('scheduled'); ?>
            </a>
            <?php
            }
            if ( get_option('app_posts_enable_insights') ) {
            ?>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-insights" role="tab" aria-controls="nav-insights" aria-selected="false">
                <?php echo $CI->lang->line('insights'); ?>
            </a>
            <?php
            }
            if ( get_option('app_posts_enable_history') ) {
            ?>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">
                <?php echo $CI->lang->line('history'); ?>
            </a>
            <?php
            }
            if ( get_option('app_posts_rss_feeds') ) {
            ?>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-rss" role="tab" aria-controls="nav-rss" aria-selected="false">
                <?php echo $CI->lang->line('rss'); ?>
            </a>  
            <?php
            }
            ?>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <?php
        if ( get_option('app_posts_enable_composer') ) {
        ?>
        <div class="tab-pane fade show active" id="nav-composer" role="tabpanel" aria-labelledby="nav-composer">
            <?php
            if ( (new MidrubApps\Collection\Posts\Helpers\Rate_limits)->posts_plan_limit($CI->user_id) ) {
                ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="reached-plan-limit">
                            <div class="row">
                                <div class="col-xl-9">
                                    <i class="icon-info"></i>
                                    <?php echo $CI->lang->line( 'reached_maximum_number_posts' ); ?>
                                </div>
                                <div class="col-xl-3 text-right">
                                    <?php 
                                    if ( !$CI->session->userdata( 'member' ) ) {
                                    ?>
                                    <a href="<?php echo site_url('user/plans') ?>" class="btn"><i class="icon-basket"></i> <?php echo $CI->lang->line( 'our_plans' ); ?></a>
                                    <?php 
                                    }
                                    ?>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php echo form_open('user/app/posts', ['class' => 'send-post', 'data-csrf' => $CI->security->get_csrf_token_name()]) ?>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="col-xl-12 post-destionation">
                            <div class="row">
                                <div class="col-xl-12 input-group composer-accounts-search">
                                    <div class="input-group-prepend">
                                        <i class="icon-magnifier"></i>
                                    </div>
                                    <?php if ( get_user_option('settings_display_groups') ): ?>
                                    <input type="text" class="form-control composer-search-for-groups" placeholder="<?php echo $CI->lang->line('search_for_groups'); ?>">
                                    <?php else: ?>
                                    <input type="text" class="form-control composer-search-for-accounts" placeholder="<?php echo $CI->lang->line('search_for_accounts'); ?>">
                                    <?php endif; ?>
                                    <button type="button" class="composer-cancel-search-for-accounts">
                                        <i class="icon-close"></i>
                                    </button>
                                    <?php if ( get_user_option('settings_social_pagination') ): ?>
                                    <button type="button" class="back-button btn-disabled">
                                        <span class="fc-icon fc-icon-left-single-arrow"></span>
                                    </button>
                                    <button type="button" class="next-button<?php if ( $total < 11 ): echo ' btn-disabled'; else: echo '" data-page="2'; endif; ?>">
                                        <span class="fc-icon fc-icon-right-single-arrow"></span>
                                    </button>
                                    <?php endif; ?>
                                    <button type="button" class="composer-manage-members" data-toggle="modal" data-target="#accounts-manager-popup">
                                        <i class="icon-user-follow"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                if ( get_user_option('settings_display_groups') ) {

                                    echo '<div class="col-xl-12 composer-groups-list">'
                                            . '<ul>';

                                    if ( $groups_list ) {

                                        foreach ( $groups_list as $group ) {
                                            ?>
                                            <li>
                                                <a href="#" data-id="<?php echo $group->list_id; ?>">
                                                    <?php echo '<i class="icon-folder-alt"></i>'; ?>
                                                    <?php echo $group->name; ?>
                                                    <i class="icon-check"></i>
                                                </a>
                                            </li>
                                            <?php
                                        }

                                    } else {

                                        if ( get_user_option('settings_display_groups') ) {
                                            echo '<li class="no-groups-found">' . $CI->lang->line('no_groups_found') . '</li>';
                                        } else {
                                            echo '<li class="no-groups-found">' . $CI->lang->line('no_accounts_found') . '</li>';
                                        }

                                    }

                                        echo '</ul>'
                                        . '</div>';

                                } else {

                                    echo '<div class="col-xl-12 composer-accounts-list">'
                                            . '<ul>';

                                    if ( $accounts_list ) {

                                        foreach ( $accounts_list as $account ) {
                                            ?>
                                            <li>
                                                <a href="#" data-id="<?php echo $account['network_id']; ?>" data-net="<?php echo $account['net_id']; ?>" data-network="<?php echo $account['network_name']; ?>" data-category="<?php echo ($account['network_info']->categories)?'true':'value'; ?>">
                                                    <?php echo str_replace(' class', ' style="color: ' . $account['network_info']->color . '" class', $account['network_info']->icon ); ?>
                                                    <?php echo $account['user_name']; ?>
                                                    <span>
                                                        <i class="icon-user"></i> <?php echo ucwords(str_replace('_', ' ', $account['network_name'])); ?>
                                                    </span>
                                                    <i class="icon-check"></i>
                                                </a>
                                            </li>
                                            <?php
                                        }

                                    } else {

                                        echo '<li class="no-accounts-found">' . $CI->lang->line('no_accounts_found') . '</li>';

                                    }

                                        echo '</ul>'
                                        . '</div>';

                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="col-xl-12 post-composer">
                            <div class="row">
                                <div class="col-xl-12 post-body">
                                    <div class="col-xl-12 composer-title">
                                        <input type="text" placeholder="<?php echo $CI->lang->line('enter_post_title'); ?>">
                                    </div>
                                    <div class="row post-composer-editor"> 
                                        <div class="col-xl-12 composer">
                                            <textarea class="new-post" placeholder="<?php echo $CI->lang->line('share_what_new'); ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="row post-composer-buttons">
                                        <div class="col-xl-12">
                                            <button type="button" class="btn" data-toggle="modal" data-target="#file-upload-box">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                            <button type="button" class="btn show-title">
                                                <i class="fas fa-text-width"></i>
                                            </button>   
                                            <button type="button" class="btn" data-toggle="modal" data-target="#saved-posts">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <?php
                                            if ( get_user_option('settings_character_count') ) {
                                                echo '<div class="numchar">0</div>';
                                            }
                                            ?>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-xl-12 post-footer">
                                    <div class="multimedia-gallery">
                                        <ul>
                                        </ul>
                                        <a href="#" class="load-more-medias" data-page="1"><?php echo $CI->lang->line('load_more'); ?></a>
                                        <p class="no-medias-found"><?php echo $CI->lang->line('no_photos_videos_uploaded'); ?></p>
                                    </div>
                                    <div class="multimedia-gallery-selected-medias">
                                        <div class="row">
                                            <div class="col-xl-4 col-4">
                                                <p></p>
                                            </div>
                                            <div class="col-xl-8 col-8 text-right">
                                                <button type="button" class="btn btn-delete-selected-photos">
                                                    <?php echo $CI->lang->line('delete_all'); ?>
                                                </button>   
                                                <button type="button" class="btn btn-add-selected-photos">
                                                    <?php echo $CI->lang->line('add_to_post'); ?>
                                                </button>                                             
                                            </div>                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 buttons-control">
                            <input type="text" class="datetime">
                            <div class="btn-group dropup">
                                <button type="submit" class="btn btn-success"><i class="icon-share-alt"></i> <?php echo $CI->lang->line('share_now'); ?></button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" class="open-midrub-planner"><?php echo $CI->lang->line('schedule'); ?></a></li>
                                    <li><a href="#" class="composer-draft-post"><?php echo $CI->lang->line('draft_it'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="col-xl-12 post-preview">
                            <div class="row">
                                <div class="col-xl-12 post-preview-header">
                                    <h3>
                                        <i class="icon-share-alt"></i> <?php echo $CI->lang->line('post_preview'); ?>
                                    </h3>
                                </div>
                                <div class="col-xl-12 post-preview-placeholder">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-xl-12 post-preview-title">
                                                    <div class="row">
                                                        <div class="col-xl-8"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 post-preview-body">
                                                    <div class="row">
                                                        <div class="col-xl-11"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-11"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-11"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-7"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 post-preview-medias">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 post-preview-footer">
                                                    <ul></ul>
                                                </div>
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
        <?php
        }
        if ( get_option('app_posts_enable_scheduled') ) {
        ?>
        <div class="tab-pane fade" id="scheduled-posts" role="tabpanel" aria-labelledby="scheduled-posts">
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12 p-3">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        if ( get_option('app_posts_enable_insights') ) {
        ?>
        <div class="tab-pane fade" id="nav-insights" role="tabpanel" aria-labelledby="nav-insights">
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12 clean">
                        <ul  class="nav nav-pills">
                            <li class="active">
                                <a href="#insights-posts" class="active show" data-toggle="tab"><?php echo $CI->lang->line('posts'); ?></a>
                            </li>
                            <li>
                                <a href="#insights-accounts" data-toggle="tab"><?php echo $CI->lang->line('accounts'); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="insights-posts">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="row">
                                            <div class="col-xl-12 input-group insights-posts-search">
                                                <div class="input-group-prepend">
                                                    <i class="icon-magnifier"></i>
                                                </div>
                                                <input type="text" class="form-control insights-search-for-posts" placeholder="<?php echo $CI->lang->line('search_for_posts'); ?>">
                                                <button type="button" class="insights-cancel-search-for-posts">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 insights-posts-results">
                                            </div>
                                        </div>
                                        <nav>
                                            <ul class="pagination" data-type="insights-posts">
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="panel no-selected-post panel-primary">
                                                    <div class="panel-no-selected-post">
                                                        <p class="no-post-selected"><?php echo $CI->lang->line('no_post_selected'); ?></p>
                                                    </div>
                                                    <div class="panel-heading insights-post-header" id="accordion">
                                                        <h3>
                                                            <img src="">
                                                            <a href="#" class="insights-post-content-username"></a>
                                                            <span></span>
                                                            <div class="dropdown show">
                                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="icon-arrow-down"></i>
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item insights-post-delete-post" href="#"><?php echo $CI->lang->line('delete_post'); ?></a>
                                                                </div>
                                                            </div>
                                                        </h3>                                                                        
                                                    </div>
                                                    <div class="panel-body insights-post-content">
                                                    </div>
                                                    <div class="panel-footer insights-post-footer">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                </ul>
                                                            </div> 
                                                        </div>    
                                                        <div class="tab-content" id="myTabContent">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading" id="accordion">
                                                        <h3>
                                                            <i class="icon-graph"></i>
                                                            <?php echo $CI->lang->line('post_insights'); ?>
                                                        </h3>                                                                        
                                                    </div>
                                                    <div class="panel-body">
                                                       <canvas id="insights-posts-graph" width="600" height="400"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="insights-accounts">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="row">
                                            <div class="col-xl-10 col-sm-10 col-9 input-group insights-posts-search">
                                                <div class="input-group-prepend">
                                                    <i class="icon-magnifier"></i>
                                                </div>
                                                <input type="text" class="form-control insights-search-for-accounts" placeholder="<?php echo $CI->lang->line('search_for_accounts'); ?>">
                                                <button type="button" class="insights-cancel-search-for-accounts">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="col-xl-2 col-sm-2 col-3">
                                                <button type="button" class="composer-manage-members" data-toggle="modal" data-target="#accounts-manager-popup"><i class="icon-user-follow"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 insights-accounts-results">
                                                <ul class="insights-accounts">
                                                    
                                           </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <nav>                                            
                                                    <ul class="pagination" data-type="insights-accounts">
                                                    </ul>
                                                </nav>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="panel no-selected-post panel-primary">
                                                    <div class="panel-no-selected-post">
                                                        <p class="no-post-selected"><?php echo $CI->lang->line('no_accounts_selected'); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading" id="accordion">
                                                        <h3>
                                                            <i class="icon-graph"></i>
                                                            <?php echo $CI->lang->line('insights'); ?>
                                                        </h3>                                                                        
                                                    </div>
                                                    <div class="panel-body">
                                                       <canvas id="insights-accounts-graph" width="600" height="500"></canvas>
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
            </div>
        </div>
        <?php
        }
        if ( get_option('app_posts_enable_history') ) {
        ?>
        <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history">
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12 clean">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="row">
                                    <div class="col-xl-12 input-group history-posts-search">
                                        <div class="input-group-prepend">
                                            <i class="icon-magnifier"></i>
                                        </div>
                                        <input type="text" class="form-control history-search-for-posts" placeholder="<?php echo $CI->lang->line('search_for_posts'); ?>">
                                        <button type="button" class="history-cancel-search-for-posts">
                                            <i class="icon-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 input-group history-posts-results">                                    
                                    </div>
                                </div>
                                <nav>
                                    <ul class="pagination" data-type="history-posts">
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-xl-5">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="accordion">
                                        <h3>
                                            <i class="icon-info"></i>
                                            <?php echo $CI->lang->line('post_content'); ?>
                                        </h3>                                                                        
                                    </div>
                                    <div class="panel-body history-post-content">
                                        <p class="no-post-selected"><?php echo $CI->lang->line('no_post_selected'); ?></p>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-xl-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading history-post-status" id="accordion">
                                        <h3>
                                            <i class="icon-chart"></i>
                                            <?php echo $CI->lang->line('publish_status'); ?>
                                        </h3>                                                                        
                                    </div>
                                    <div class="panel-body history-profiles-list">
                                        <p class="no-post-selected"><?php echo $CI->lang->line('no_post_selected'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }        
        if ( get_option('app_posts_rss_feeds') ) {
        ?>
        <div class="tab-pane fade" id="nav-rss" role="tabpanel" aria-labelledby="nav-rss">
            <?php
            if ( (new MidrubApps\Collection\Posts\Helpers\Rate_limits)->rss_plan_limit($CI->user_id) ) {
                ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="reached-plan-limit">
                            <div class="row">
                                <div class="col-xl-9">
                                    <i class="icon-info"></i>
                                    <?php echo $CI->lang->line( 'reached_maximum_number_rss_feeds' ); ?>
                                </div>
                                <div class="col-xl-3 text-right">
                                    <?php 
                                    if ( !$CI->session->userdata( 'member' ) ) {
                                    ?>
                                    <a href="<?php echo site_url('user/plans') ?>" class="btn"><i class="icon-basket"></i> <?php echo $CI->lang->line( 'our_plans' ); ?></a>
                                    <?php 
                                    }
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" id="accordion">
                                <div class="checkbox-option-select">
                                    <input id="rss-select-all-feeds" name="rss-select-all-feeds" type="checkbox">
                                    <label for="rss-select-all-feeds"></label>
                                </div>
                                <div class="dropdown show">
                                    <a class="btn btn-secondary btn-md dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-magic-wand"></i> <?php echo $CI->lang->line('actions'); ?>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-action" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" data-id="1" href="#"><i class="fas fa-circle"></i> <?php echo $CI->lang->line('enable'); ?></a>
                                        <a class="dropdown-item" data-id="2" href="#"><i class="far fa-circle"></i> <?php echo $CI->lang->line('disable'); ?></a>
                                        <a class="dropdown-item" data-id="3" href="#"><i class="icon-trash"></i> <?php echo $CI->lang->line('delete'); ?></a>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i class="icon-magnifier"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control search-for-rss-feeds" placeholder="<?php echo $CI->lang->line('search_for_rss_feeds'); ?>" aria-label="search-for-rss-feeds">
                                    <div class="input-group-append">
                                        <button type="button" class="rss-cancel-search-for-feeds">
                                            <i class="icon-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#rss-feeds-new-rss"><i class="icon-feed"></i> <?php echo $CI->lang->line('add_rss_feed'); ?></button>
                            </div>
                            <div class="panel-body">
                                <ul class="rss-all-feeds">
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <nav>
                                    <ul class="pagination" data-type="rss-feeds">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="composer-category-picker" tabindex="-1" role="dialog" aria-labelledby="composer-category-picker" aria-hidden="true">
    <div class="modal-dialog file-upload-box modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $CI->lang->line('mu45'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <select class="form-control" id="selnet">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <div>
                    <button type="button" class="btn btn-success categories-select" data-dismiss="modal"><?php echo $CI->lang->line('mu46'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accounts-manager-popup" tabindex="-1" role="dialog" aria-labelledby="accounts-manager-popup" aria-hidden="true">
    <div class="modal-dialog file-upload-box modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active show" id="nav-accounts-manager-tab" data-toggle="tab" href="#nav-accounts-manager" role="tab" aria-controls="nav-accounts-manager" aria-selected="true">
                           <?php echo $CI->lang->line('accounts'); ?> 
                        </a>
                        <a class="nav-item nav-link" id="nav-groups-manager-tab" data-toggle="tab" href="#nav-groups-manager" role="tab" aria-controls="nav-groups-manager" aria-selected="false">
                            <?php echo $CI->lang->line('groups'); ?> 
                        </a>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </nav>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-accounts-manager" role="tabpanel" aria-labelledby="nav-accounts-manager">
                    </div>
                    <div class="tab-pane fade" id="nav-groups-manager" role="tabpanel" aria-labelledby="nav-groups-manager">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rss-feeds-new-rss" tabindex="-1" role="dialog" aria-labelledby="rss-feeds-new-rss" aria-hidden="true">
    <div class="modal-dialog file-upload-box modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active show" id="nav-accounts-manager-tab" data-toggle="tab" href="#nav-new-rss" role="tab" aria-controls="nav-new-rss" aria-selected="true">
                            <?php echo $CI->lang->line('new_rss'); ?> 
                        </a>
                        <?php  
                        if ( get_option('app_posts_enable_faq') ) {
                            ?>
                            <a class="nav-item nav-link" id="nav-groups-manager-tab" data-toggle="tab" href="#nav-rss-faq" role="tab" aria-controls="nav-rss-faq" aria-selected="false">
                                <?php echo $CI->lang->line('faq'); ?>  
                            </a>
                            <?php  
                        }
                        ?>                        
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </nav>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-new-rss" role="tabpanel" aria-labelledby="nav-new-rss">
                        <?php echo form_open('user/app/posts', ['class' => 'register-new-rss-feed', 'data-csrf' => $CI->security->get_csrf_token_name()]) ?>
                            <div class="row rss-feeds-add-rss-form">
                                <div class="col-xl-7 col-sm-7 col-7">
                                    <div class="input-group rss-feeds-enter-rss">
                                        <div class="input-group-prepend">
                                            <i class="icon-feed"></i>
                                        </div>
                                        <input type="text" class="form-control rss-feeds-enter-rss-url" placeholder="<?php echo $CI->lang->line('enter_rss_url'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-sm-5 col-5">
                                    <button type="submit" class="rss-feeds-save-rss">
                                        <i class="far fa-save"></i>  <?php echo $CI->lang->line('save_rss_feed'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="row rss-feeds-rss-content">
                                <div class="col-xl-12 rss-feeds-rss-content-single">
                                    <h6><?php echo $CI->lang->line('please_enter_rss_feed_url'); ?></h6>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                    <?php  
                    if ( get_option('app_posts_enable_faq') ) {
                        ?>
                        <div class="tab-pane fade" id="nav-rss-faq" role="tabpanel" aria-labelledby="nav-rss-faq">
                            <div class="row clean">
                                <div class="col-xl-12 rss-feeds-faq">
                                    <?php echo $CI->lang->line('add_rss_faq'); ?>
                                </div>
                            </div>
                        </div>
                        <?php  
                    }
                    ?>   
                </div>
            </div>
        </div>
    </div>
</div>

<!--Upload image form !-->
<?php
$attributes = array('class' => 'upim d-none', 'id' => 'upim', 'method' => 'post', 'data-csrf' => $CI->security->get_csrf_token_name() );
echo form_open_multipart('user/app/posts', $attributes);
?>
<input type="hidden" name="type" id="type" value="video">
<input type="file" name="file[]" id="file" accept=".gif,.jpg,.jpeg,.png,.mp4,.avi" multiple>
<?php echo form_close(); ?>