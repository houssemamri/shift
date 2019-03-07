            </main>
            
        </div>
        
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

        <!-- Optional JavaScript -->
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/user/js/main.js?ver=<?= MD_VER ?>"></script>
        <?php
        if ( isset($app_scripts) ) {
        ?>
        <!-- Custom Scripts -->
        <?php
        echo $app_scripts;
        }
        ?>
        <script language="javascript">
            // Encode special characters
            function htmlEntities(str) {
                return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }

            // Translation characters
            Main.translation = {
                "mm103": htmlEntities("<?= $this->lang->line("mm103"); ?>"),
                "mm104": htmlEntities("<?= $this->lang->line("mm104"); ?>"),
                "mm105": htmlEntities("<?= $this->lang->line("mm105"); ?>"),
                "mm106": htmlEntities("<?= $this->lang->line("mm106"); ?>"),
                "mm107": htmlEntities("<?= $this->lang->line("mm107"); ?>"),
                "mm108": htmlEntities("<?= $this->lang->line("mm108"); ?>"),
                "mm109": htmlEntities("<?= $this->lang->line("mm109"); ?>"),
                "mm110": htmlEntities("<?= $this->lang->line("mm110"); ?>"),
                "mm3": htmlEntities("<?= $this->lang->line("mm3"); ?>"),
                "mm111": htmlEntities("<?= $this->lang->line("mm111"); ?>"),
                "mm112": htmlEntities("<?= $this->lang->line("mm112"); ?>"),
                "mm113": htmlEntities("<?= $this->lang->line("mm113"); ?>"),
                "mm114": htmlEntities("<?= $this->lang->line("mm114"); ?>"),
                "mm115": htmlEntities("<?= $this->lang->line("mm115"); ?>"),
                "mm116": htmlEntities("<?= $this->lang->line("mm116"); ?>"),
                "mm117": htmlEntities("<?= $this->lang->line("mm117"); ?>"),
                "mm118": htmlEntities("<?= $this->lang->line("mm118"); ?>"),
                "mm120": htmlEntities("<?= $this->lang->line("mm120"); ?>"),
                "mm121": htmlEntities("<?= $this->lang->line("mm121"); ?>"),
                "mm122": htmlEntities("<?= $this->lang->line("mm122"); ?>"),
                "mm123": htmlEntities("<?= $this->lang->line("mm123"); ?>"),
                "mm124": htmlEntities("<?= $this->lang->line("mm124"); ?>"),
                "mm125": htmlEntities("<?= $this->lang->line("mm125"); ?>"),
                "mm126": htmlEntities("<?= $this->lang->line("mm126"); ?>"),
                "mm127": htmlEntities("<?= $this->lang->line("mm127"); ?>"),
                "mm128": htmlEntities("<?= $this->lang->line("mm128"); ?>"),
                "mm129": htmlEntities("<?= $this->lang->line("mm129"); ?>"),
                "mm130": htmlEntities("<?= $this->lang->line("mm130"); ?>"),
                "mm131": htmlEntities("<?= $this->lang->line("mm131"); ?>"),
                "mm132": htmlEntities("<?= $this->lang->line("mm132"); ?>"),
                "mm133": htmlEntities("<?= $this->lang->line("mm133"); ?>"),
                "mm134": htmlEntities("<?= $this->lang->line("mm134"); ?>"),
                "mm135": htmlEntities("<?= $this->lang->line("mm135"); ?>"),
                "mm136": htmlEntities("<?= $this->lang->line("mm136"); ?>"),
                "mm137": htmlEntities("<?= $this->lang->line("mm137"); ?>"),
                "mm138": htmlEntities("<?= $this->lang->line("mm138"); ?>"),
                "mm139": htmlEntities("<?= $this->lang->line("mm139"); ?>"),
                "mm146": htmlEntities("<?= $this->lang->line("mm146"); ?>"),
                "mm147": htmlEntities("<?= $this->lang->line("mm147"); ?>"),
                "mm148": htmlEntities("<?= $this->lang->line("mm148"); ?>"),
                "mm149": htmlEntities("<?= $this->lang->line("mm149"); ?>"),
                "mm150": htmlEntities("<?= $this->lang->line("mm150"); ?>"),
                "mm151": htmlEntities("<?= $this->lang->line("mm151"); ?>"),
                "mm152": htmlEntities("<?= $this->lang->line("mm152"); ?>"),
                "mm153": htmlEntities("<?= $this->lang->line("mm153"); ?>"),
                "mm154": htmlEntities("<?= $this->lang->line("mm154"); ?>"),
                "mm155": htmlEntities("<?= $this->lang->line("mm155"); ?>"),
                "mm156": htmlEntities("<?= $this->lang->line("mm156"); ?>"),
                "mm157": htmlEntities("<?= $this->lang->line("mm157"); ?>"),
                "mm158": htmlEntities("<?= $this->lang->line("mm158"); ?>"),
                "mm159": htmlEntities("<?= $this->lang->line("mm159"); ?>"),
                "mm160": htmlEntities("<?= $this->lang->line("mm160"); ?>"),
                "mm161": htmlEntities("<?= $this->lang->line("mm161"); ?>"),
                "mm162": htmlEntities("<?= $this->lang->line("mm162"); ?>"),
                "mm163": htmlEntities("<?= $this->lang->line("mm163"); ?>"),
                "mm164": htmlEntities("<?= $this->lang->line("mm164"); ?>"),
                "mm179": htmlEntities("<?= $this->lang->line("mm179"); ?>"),
                "mm180": htmlEntities("<?= $this->lang->line("mm180"); ?>"),
                "mu193": htmlEntities("<?= $this->lang->line("mu193"); ?>"),
                "mu194": htmlEntities("<?= $this->lang->line("mu194"); ?>"),
                "mu195": htmlEntities("<?= $this->lang->line("mu195"); ?>"),
                "mu196": htmlEntities("<?= $this->lang->line("mu196"); ?>"),
                "mu197": htmlEntities("<?= $this->lang->line("mu197"); ?>"),
                "mu198": htmlEntities("<?= $this->lang->line("mu198"); ?>"),
                "mu199": htmlEntities("<?= $this->lang->line("mu199"); ?>"),
                "mu200": htmlEntities("<?= $this->lang->line("mu200"); ?>"),
                "mu201": htmlEntities("<?= $this->lang->line("mu201"); ?>"),
                "mu202": htmlEntities("<?= $this->lang->line("mu202"); ?>"),
                "mu203": htmlEntities("<?= $this->lang->line("mu203"); ?>"),
                "mu204": htmlEntities("<?= $this->lang->line("mu204"); ?>"),
                "mu205": htmlEntities("<?= $this->lang->line("mu205"); ?>"),
                "mm190": htmlEntities("<?= $this->lang->line("mm190"); ?>"),
                "mu42": htmlEntities("<?= $this->lang->line("mu42"); ?>"),
                "mu206": htmlEntities("<?= $this->lang->line("mu206"); ?>"),
                "mm191": htmlEntities("<?= $this->lang->line("mm191"); ?>"),
                "mm193": htmlEntities("<?= $this->lang->line("mm193"); ?>"),
                "mm194": htmlEntities("<?= $this->lang->line("mm194"); ?>"),
                "mm195": htmlEntities("<?= $this->lang->line("mm195"); ?>"),
                "mm196": htmlEntities("<?= $this->lang->line("mm196"); ?>"),
                "mm201":htmlEntities("<?= $this->lang->line("mm201"); ?>"),
                "mu3": htmlEntities("<?= $this->lang->line("mu3"); ?>")
            };
        </script>
        <?php if ( $this->router->fetch_method() === 'apps' || $this->router->fetch_method() === 'emails'): ?>
        <script language="javascript">
            Main.translation.mu327 = htmlEntities("<?= $this->lang->line('mu327'); ?>");
            Main.translation.mu328 = htmlEntities("<?= $this->lang->line('mu328'); ?>");
            Main.translation.mu329 = htmlEntities("<?= $this->lang->line('mu329'); ?>");
            Main.translation.mu330 = htmlEntities("<?= $this->lang->line('mu330'); ?>");
            Main.translation.mu331 = htmlEntities("<?= $this->lang->line('mu331'); ?>");
            Main.translation.mu332 = htmlEntities("<?= $this->lang->line('mu332'); ?>");
            Main.translation.mu333 = htmlEntities("<?= $this->lang->line('mu333'); ?>");
            Main.translation.mu334 = htmlEntities("<?= $this->lang->line('mu334'); ?>");
            Main.translation.mu335 = htmlEntities("<?= $this->lang->line('mu335'); ?>");
            Main.translation.mu336 = htmlEntities("<?= $this->lang->line('mu336'); ?>");
            Main.translation.mu337 = htmlEntities("<?= $this->lang->line('mu337'); ?>");
            Main.translation.mu338 = htmlEntities("<?= $this->lang->line('mu338'); ?>");
            Main.translation.mu339 = htmlEntities("<?= $this->lang->line('mu339'); ?>");
            Main.translation.mu340 = htmlEntities("<?= $this->lang->line('mu340'); ?>");
            Main.translation.mu341 = htmlEntities("<?= $this->lang->line('mu341'); ?>");
            Main.translation.mu342 = htmlEntities("<?= $this->lang->line('mu342'); ?>");
            Main.translation.mu343 = htmlEntities("<?= $this->lang->line('mu343'); ?>");
            Main.translation.mu344 = htmlEntities("<?= $this->lang->line('mu344'); ?>");
            Main.translation.mu345 = htmlEntities("<?= $this->lang->line('mu345'); ?>");
            Main.translation.videos_arent_supported = htmlEntities("<?= $this->lang->line('videos_arent_supported'); ?>");
            Main.translation.mm2 = htmlEntities("<?= $this->lang->line('mm2'); ?>");
            Main.translation.scheduled_template_deleted_successfully = htmlEntities("<?= $this->lang->line('scheduled_template_deleted_successfully'); ?>");
        </script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'notifications'): ?>
        <script src="<?= base_url(); ?>assets/user/js/notifications.js?ver=<?= MD_VER ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'upgrade'): ?>
        <script src="<?= base_url(); ?>assets/user/js/gateways.js?ver=<?= MD_VER ?>"></script>
        <script language="javascript">
            Main.translation.mm216 = htmlEntities("<?= $this->lang->line('mm216'); ?>");
            Main.translation.mm217 = htmlEntities("<?= $this->lang->line('mm217'); ?>");
        </script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'emails'): ?>
        <script src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?= base_url(); ?>assets/user/js/emails.js?ver=<?= MD_VER ?>"></script>
        <script src="<?= base_url(); ?>assets/js/raphael-min.js"></script> 
        <script src="<?= base_url(); ?>assets/js/morris-0.4.1.min.js"></script>
        <script language="javascript">
            Main.translation.mu285 = htmlEntities("<?= $this->lang->line('mu285'); ?>");
            Main.translation.mu286 = htmlEntities("<?= $this->lang->line('mu286'); ?>");
            Main.translation.mu295 = htmlEntities("<?= $this->lang->line('mu295'); ?>");
        </script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'settings'): ?>
        <script src="<?= base_url(); ?>assets/user/js/settings.js?ver=<?= MD_VER ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'team'): ?>
        <script src="<?= base_url(); ?>assets/user/js/team.js?ver=<?= MD_VER ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'activities'): ?>
        <script src="<?= base_url(); ?>assets/user/js/activities.js?ver=<?= MD_VER ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'tools' || $this->router->fetch_method() === 'bots'): ?>
        <script src="<?= base_url(); ?>assets/user/js/tools.js?ver=<?= MD_VER ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() === 'tools' || $this->router->fetch_method() === 'bots' || $this->router->fetch_method() === 'RSS_feeds'): ?>
        <script src="<?= base_url(); ?>assets/user/js/bootstrap-datetimepicker.js"></script>
        <?php endif; ?>
        <?php if ( $this->router->fetch_method() === 'faq_page' || $this->router->fetch_method() === 'faq_categories' || $this->router->fetch_method() === 'faq_article' || $this->router->fetch_method() === 'ticket' ) { ?>
        <script src="<?php echo base_url(); ?>assets/user/js/faq.js?ver=<?php echo MD_VER ?>"></script>
        <?php } ?>
    </body>
</html>