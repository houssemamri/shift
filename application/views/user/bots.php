<section class="bots-page">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true"><?= $this->lang->line('mu102'); ?></a>
            <a class="nav-item nav-link" data-toggle="tab" href="#nav-favorites" role="tab" aria-controls="nav-favorites" aria-selected="false"><?= $this->lang->line('mu103'); ?></a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all">
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12 p-3">
                        <ul>
                            <?php
                            if ($bots) {
                                $i = 0;
                                foreach ($bots as $bot) {
                                    if (!isset($options['bot_' . $bot['slug']]))
                                        continue;
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                                <button class="btn-tool-icon btn bots-button btn-default btn-xs pull-left" type="button">
                                                    <i class="icon-pin"></i>
                                                </button>
                                                <span class="netaccount"><?= $bot['name']; ?></span>
                                                <p><?= $bot['description']; ?></p>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                <div class="btn-group">
                                                    <a href="<?= site_url('user/bots/' . $bot['slug']) ?>" data-type="main" class="btn btn-default">
                                                        <?= $this->lang->line('mu105'); ?>
                                                    </a>
                                                    <a href="<?= $bot['slug'] ?>" class="btn btn-default save-bookmark<?php if (@in_array($bot['slug'], $favourites)): echo ' saved'; endif; ?>">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    $i++;
                                }
                                if ($i == 0) {
                                    echo '<li>' . $this->lang->line('no_bots_found') . '</li>';
                                }
                            } else {
                                echo '<li>' . $this->lang->line('no_bots_found') . '</li>';
                            }
                            ?>                                              
                        </ul>        
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-favorites" role="tabpanel" aria-labelledby="nav-favorites">
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-12 p-3">
                        <ul>
                            <?php
                            if ($bots) {
                                $i = 0;
                                foreach ($bots as $bot) {
                                    if (!@in_array($bot['slug'], $favourites)): continue;
                                    endif;
                                    $i++;
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                                <button class="btn-tool-icon btn bots-button btn-default btn-xs pull-left" type="button">
                                                    <i class="icon-pin"></i>
                                                </button>
                                                <span class="netaccount"><?= $bot['name']; ?></span>
                                                <p><?= $bot['description']; ?></p>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                <div class="btn-group">
                                                    <a href="<?= site_url('user/bots/' . $bot['slug']) ?>" data-type="main" class="btn btn-default">
                                                        <?= $this->lang->line('mu105'); ?>
                                                    </a>
                                                    <a href="<?= $bot['slug'] ?>" class="btn btn-default save-bookmark<?php if (@in_array($bot['slug'], $favourites)): echo ' saved';
                                                endif; ?>">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                if ($i == 0) {
                                    echo '<li>' . $this->lang->line('no_bots_found') . '</li>';
                                }
                            } else {
                                echo '<li>' . $this->lang->line('no_bots_found') . '</li>';
                            }
                            ?>                                     
                        </ul>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>