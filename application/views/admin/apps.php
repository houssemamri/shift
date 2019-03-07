<section>
    <div class="container-fluid apps">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 apps-header">
                            <h3>
                                <i class="fa fa-rocket"></i> <?php echo $this->lang->line('apps'); ?>
                            </h3>
                        </div>
                        <div class="col-lg-12 apps-list">
                        <?php

                        // Verify if apps exists
                        if ( $apps ) {

                            echo '<ul>';

                            foreach ( $apps as $app ) {

                                echo '<li>'
                                        . '<div class="row">'
                                            . '<div class="col-lg-10">'
                                                . '<p>'
                                                    . '<i class="fas fa-cube"></i>'
                                                    . ucwords(str_replace('_', ' ', $app))
                                                . '</p>'
                                            . '</div>'
                                            . '<div class="col-lg-2">'
                                                . '<a href="' . site_url( 'admin/apps/' . $app ) . '" class="btn btn-default"><i class="fas fa-sign-in-alt"></i> ' . $this->lang->line('ma134') . '</a>'
                                            . '</div>'
                                        . '</div>'
                                    . '</li>';

                            }

                            echo '</ul>';

                        } else {
                            
                            echo '<p class="no-results-found">' . $this->lang->line('no_apps_found') . '</p>';

                        }

                        ?>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>