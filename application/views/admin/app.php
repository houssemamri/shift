<section>
    <div class="container-fluid app">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="col-lg-2">
                        <ul class="nav nav-tabs tabs-left">
                            <?php
                            if ( $options ) {
                                
                                foreach ( $options as $key => $value ) {
                                    ?>
                                    <li<?php if ($key === key($options)): ?> class="active"<?php endif; ?>><a href="#<?php echo $key; ?>" data-toggle="tab"><?php echo $value['tab']; ?></a></li>
                                    <?php
                                }
                                
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="tab-content">
                            <?php
                            if ( $options ) {
                                
                                foreach ( $options as $key => $value ) {
                                    ?>
                                    <div class="tab-pane<?php if ($key === key($options)): ?>  active<?php endif; ?>" id="<?php echo $key; ?>">
                                        <?php echo $value['options']; ?>
                                    </div>
                                    <?php
                                }
                                
                            }
                            ?>                            
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<?php
echo form_open('user/posts', array('class' => 'app-options d-none', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name()));
echo form_close();
?>