<section class="emails-page">
    <?= $res; ?>
</section>
<div id="image_upload" class="modal fade temp-text-edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo $this->lang->line('file_upload'); ?> <span>( <span class="user-total-storage"> <?php echo calculate_size(get_user_option('user_storage', $this->user_id)); ?> </span> / <?php echo calculate_size( $this->plans->get_plan_features($this->user_id, 'storage') ); ?>)</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="drag-and-drop-files">
                            <div>
                                <i class="icon-cloud-upload"></i><br>
                                <?php echo $this->lang->line('drag_drop_files'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="multimedia-gallery-quick-schedule">
                    <ul></ul>
                    <a href="#" class="multimedia-gallery-quick-schedule-load-more-medias" data-page="1" style="display: flow-root;"><?php echo $this->lang->line('load_more'); ?></a>
                    <p class="no-medias-found" style="display: none;"><?php echo $this->lang->line('no_photos_videos_uploaded'); ?></p>
                </div>
                <div class="multimedia-gallery-selected-medias">
                    <div class="row">
                        <div class="col-xl-4">
                            <p></p>
                        </div>
                        <div class="col-xl-8 text-right">
                            <button type="button" class="btn btn-delete-selected-photos">
                                <?php echo $this->lang->line('delete'); ?>
                            </button>   
                            <button type="button" class="btn btn-add-selected-photos">
                                <?php echo $this->lang->line('add_in_template'); ?>
                            </button>                                             
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup_lists_edit" class="modal fade temp-text-edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu252'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 clean media-gallery media-gallery-images" data-type="image">
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $this->lang->line('mu181'); ?></button>
            </div>
        </div>
    </div>
</div>        
<div id="popup_table" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu254'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-list-options">
                    <ul>
                        <li><span class="pull-left"><?= $this->lang->line('mu255'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="tab-rows tabmon" min="1" max="5"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu256'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="tab-columns tabmon" min="1" max="5"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu257'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="first-column tabmon" min="0" max="100"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu258'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="second-column tabmon" min="0" max="100"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu259'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="third-column tabmon" min="0" max="100"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu260'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="fourth-column tabmon" min="0" max="100"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu261'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="tab-cellpadding tabmon" min="1" max="15"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu262'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="tab-border tabmon" min="1" max="15"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu263'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color tab-border-color tabmon" value=""></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu225'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color tab-background-color tabmon" value="#FFFFFF"></div></li>
                        <li><span class="pull-left dtabi"><?= $this->lang->line('mu264'); ?></span><div class="checkbox-option pull-right"><input id="delete-table-from-template" name="delete-table-from-template" class="setopt" type="checkbox"><label for="delete-table-from-template"></label></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup_line" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu279'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 clean table-list-options">
                    <ul>
                        <li><span class="pull-left"><?= $this->lang->line('mu265'); ?>(px)</span><div class="btn-group btn-group-info pull-right"><input type="number" class="line-height linmon" min="1" max="5"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu266'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color lin-background-color linmon" value="#FFFFFF"></div></li>
                        <li><span class="pull-left dtabi"><?= $this->lang->line('mu267'); ?></span><div class="checkbox-option pull-right"><input id="delete-line-from-template" name="delete-line-from-template" class="setopt" type="checkbox"><label for="delete-line-from-template"></label></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup_space" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu268'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 clean table-list-options" data-type="image">
                    <ul>
                        <li><span class="pull-left"><?= $this->lang->line('mu269'); ?>(px)</span><div class="btn-group btn-group-info pull-right"><input type="number" class="space-height" min="1" max="1000"></div></li>
                        <li><span class="pull-left dtabi"><?= $this->lang->line('mu270'); ?></span><div class="checkbox-option pull-right"><input id="delete-space-from-template" name="delete-space-from-template" class="setopt" type="checkbox"><label for="delete-space-from-template"></label></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup_header_edit" class="modal fade temp-text-edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu271'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="edit-header-textarea"></textarea>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xl-8">
                        <table>
                            <tr>
                                <td>
                                    <input type="color" class="pull-right type-color change-tem-header-color" value="#FFFFFF">
                                </td>
                                <td>
                                    <button type="button" class="align-tem-text-to-left"><i class="fa fa-align-left"></i></button>
                                </td> 
                                <td>
                                    <button type="button" class="align-tem-text-to-center"><i class="fa fa-align-center"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="align-tem-text-to-right"><i class="fa fa-align-right"></i></button>
                                </td> 
                                <td>
                                    <button type="button" class="align-tem-text-to-justify"><i class="fa fa-align-justify"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="bold-tem-text"><i class="fa fa-bold"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="italic-tem-text"><i class="fa fa-italic"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="underline-tem-text"><i class="fa fa-underline"></i></button>
                                </td>                                  
                            </tr>
                        </table>
                    </div>
                    <div class="col-xl-4 text-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $this->lang->line('mu181'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popup_html_edit" class="modal fade temp-text-edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu272'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="edit-header-textarea"></textarea>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $this->lang->line('mu181'); ?></button>
            </div>
        </div>
    </div>
</div>
<div id="popup_paragraph_edit" class="modal fade temp-text-edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu253'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="edit-paragraph-textarea"></textarea>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xl-8">
                        <table>
                            <tr>
                                <td>
                                    <input type="color" class="pull-right type-color change-tem-text-color" value="#FFFFFF">
                                </td>
                                <td>
                                    <button type="button" class="align-tem-text-to-left"><i class="fa fa-align-left"></i></button>
                                </td> 
                                <td>
                                    <button type="button" class="align-tem-text-to-center"><i class="fa fa-align-center"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="align-tem-text-to-right"><i class="fa fa-align-right"></i></button>
                                </td> 
                                <td>
                                    <button type="button" class="align-tem-text-to-justify"><i class="fa fa-align-justify"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="bold-tem-text"><i class="fa fa-bold"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="italic-tem-text"><i class="fa fa-italic"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="underline-tem-text"><i class="fa fa-underline"></i></button>
                                </td>                                 
                                <td>
                                    <button type="button" class="indent-tem-text"><i class="fa fa-indent"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="outdent-tem-text"><i class="fa fa-outdent"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="enter-a-link-template-item"><i class="fa fa-link"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="remove-a-link-template-item"><i class="fas fa-unlink"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="increase-item-tem-text-size"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <button type="button" class="decrease-item-tem-text-size"><i class="fa fa-minus"></i></button>
                                </td>                                    
                            </tr>
                        </table>
                    </div>
                    <div class="col-xl-4 text-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $this->lang->line('mu181'); ?></button>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
<div id="popup_button_edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu275'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="media-gallery table-list-options">
                    <ul>
                        <li><span class="pull-left"><?= $this->lang->line('mu276'); ?></span><div class="btn-group btn-group-info pull-right"><input type="text" class="tab-button-text tabut" min="1" max="5"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu262'); ?></span><div class="btn-group btn-group-info pull-right"><input type="number" class="tab-border-button tabut" min="1" max="15"></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu263'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color tab-border-button-color tabut" value=""></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu277'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color tab-border-text-color tabut" value=""></div></li>
                        <li><span class="pull-left"><?= $this->lang->line('mu225'); ?></span><div class="btn-group btn-group-info pull-right"><input type="color" class="pull-right type-color tab-border-background-color tabut" value="#FFFFFF"></div></li>
                        <li><span class="pull-left dtabi"><?= $this->lang->line('mu278'); ?></span><div class="checkbox-option pull-right"><input id="delete-button-from-template" name="delete-button-from-template" class="setopt" type="checkbox"><label for="delete-button-from-template"></label></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="newCampaign" class="modal fade" role="dialog">
    <?= form_open('user/emails', array('class' => 'create-campaign', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu149'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="campaign-name" placeholder="<?= $this->lang->line('mu150'); ?>" name="campaign" required="required">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="campaign-description" rows="5" placeholder="<?= $this->lang->line('mu151'); ?>" name="description"></textarea>
                </div>
                <div class="show-msg">
                </div>                    
            </div>
            <div class="modal-footer">
                <button type="submit" data-type="main" class="btn btn-primary pull-right"><?= $this->lang->line('mu152'); ?></button>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<div id="newList" class="modal fade" role="dialog">
    <?= form_open('user/emails', array('class' => 'create-list', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= $this->lang->line('mu153'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="list-name" placeholder="<?= $this->lang->line('mu154'); ?>" name="list" required="required">
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="5" id="list-description" placeholder="<?= $this->lang->line('mu155'); ?>" name="description"></textarea>
                </div>
                <div class="show-msg">
                </div>  
            </div>
            <div class="modal-footer">
                <button type="submit" data-type="main" class="btn btn-success pull-right"><?= $this->lang->line('mu156'); ?></button>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<?php
$scheduler_time = '<select class="midrub-calendar-time-hour">';
$scheduler_time .= "\n";
    $scheduler_time .= '<option value="01">01</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="02">02</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="03">03</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="04">04</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="05">05</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="06">06</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="07">07</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="08" selected>08</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="09">09</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="10">10</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="11">11</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="12">12</option>';
    $scheduler_time .= "\n";
if ( get_user_option('24_hour_format') ) {
    $scheduler_time .= '<option value="13">13</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="14">14</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="15">15</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="16">16</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="17">17</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="18">18</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="19">19</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="20">20</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="21">21</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="22">22</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="23">23</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="00">00</option>';
    $scheduler_time .= "\n";
}
$scheduler_time .= '</select>';
$scheduler_time .= "\n";
$scheduler_time .= '<select class = "midrub-calendar-time-minutes">';
$scheduler_time .= "\n";
    $scheduler_time .= '<option value="00">00</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="10">10</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="20">20</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="30">30</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="40">40</option>';
    $scheduler_time .= "\n";
    $scheduler_time .= '<option value="50">50</option>';
    $scheduler_time .= "\n";
$scheduler_time .= '</select>';
$scheduler_time .= "\n";

if ( !get_user_option('24_hour_format') ) {
    $scheduler_time .= '<select class = "midrub-calendar-time-period">';
    $scheduler_time .= "\n";
        $scheduler_time .= '<option value="AM">AM</option>';
        $scheduler_time .= "\n";
        $scheduler_time .= '<option value="PM">PM</option>';
        $scheduler_time .= "\n";
    $scheduler_time .= '</select>';
    $scheduler_time .= "\n";
}
?>
<div class="midrub-planner">
    <div class="row">
        <div class="col-xl-12">
            <table class="midrub-calendar iso">
                <thead>
                    <tr>
                        <th class="text-center"><a href="#" class="go-back"><i class="icon-arrow-left"></i></a></th>
                        <th colspan="5" class="text-center year-month"></th>
                        <th class="text-center"><a href="#" class="go-next"><i class="icon-arrow-right"></i></a></th>
                        </tr>
                    </thead>
                <tbody class="calendar-dates"></tbody>
                </table>
            </div>
        </div>
    <div class="row">
        <div class="col-xl-12 text-center">
            <?php echo $scheduler_time; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 text-center">'
            <button type="button" class="btn composer-schedule-post"><?php echo $this->lang->line('mu169'); ?> </button>
        </div>
    </div>
</div>