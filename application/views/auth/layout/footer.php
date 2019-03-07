<?php
if ( !get_option('disabled-frontend') ) {
?>
<footer class="text-muted">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <p><a href="<?php echo base_url(); ?>" class="footer-logo"><?php echo $this->config->item('site_name') ?></a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $footer_description = get_option('footer-description');
                        if ( $footer_description ) {
                            echo html_entity_decode( $footer_description );
                        }
                        ?>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if ( get_option('social-facebook-url') ) {
                            ?>
                            <a href="<?php echo get_option('social-facebook-url'); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                            <?php
                        }
                        
                        if ( get_option('social-twitter-url') ) {
                            ?>
                            <a href="<?php echo get_option('social-twitter-url'); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php
                        }
                        
                        if ( get_option('social-instagram-url') ) {
                            ?>
                            <a href="<?php echo get_option('social-instagram-url'); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>                          
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h3><?php echo $this->lang->line('m79'); ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul>
                            <?php if (get_option("report-bug")): ?>
                                <li><a href="<?php echo site_url('report-bug') ?>"><?php echo $this->lang->line('m21'); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo site_url('terms/conditions') ?>"><?php echo $this->lang->line('m22'); ?></a></li>
                            <li><a href="<?php echo site_url('terms/policy') ?>"><?php echo $this->lang->line('m23'); ?></a></li>
                            <li>
                                <a href="<?php echo site_url('terms/cookies') ?>"><?php echo $this->lang->line('m80'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>&nbsp;</h3>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-lg-12">
                        <ul>
                            <?php
                            if ( get_option('enable-contact-us') ) {
                                ?>
                                <li>
                                    <a href="<?php echo site_url('contact-us') ?>"><?php echo $this->lang->line('m60'); ?></a>
                                </li>
                                <?php
                            }
                            if ( get_option('enable-about-us') ) {
                                ?>
                                <li>
                                    <a href="<?php echo site_url('about-us') ?>"><?php echo $this->lang->line('m58'); ?></a>
                                </li> 
                                <?php
                            }
                            if ( get_option('enable-guides') ) {
                                ?>
                                <li>
                                    <a href="<?php echo site_url('guides') ?>"><?php echo $this->lang->line('m81'); ?></a>
                                </li>   
                                <?php
                            }
                            ?>                            
                        </ul>
                    </div>
                </div>                         
            </div>
        </div>
    </div>
</footer>
<?php
}

$privacy_url = get_option('privacy-cookie-url');
if ( $privacy_url ) {
?>
<div class="cookie-window">
    <p>
        <?php echo $this->lang->line('m75'); ?>
        <a href="<?php echo $privacy_url; ?>" target="_blank"><?php echo $this->lang->line('m76'); ?></a>
    </p>
    <p>
        <a class="cookie-button" href="#"><?php echo $this->lang->line('m77'); ?></a>
    </p>            
</div>
<?php
}
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/auth/js/main.js?ver=<?php echo MD_VER; ?>"></script>
<script src="<?php echo base_url(); ?>assets/user/js/gateways.js?ver=<?php echo MD_VER; ?>"></script>
<script language="javascript">
    
    // Encode special characters
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    Main.translation.mm216 = htmlEntities("<?php echo $this->lang->line('mm216'); ?>");
    Main.translation.mm217 = htmlEntities("<?php echo $this->lang->line('mm217'); ?>");
    
</script>
<?php
$get_code = get_option('analytics-code');
if ( $get_code ) {
    echo html_entity_decode( $get_code );
}
?>