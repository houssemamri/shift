<?php
/**
 * Please, ensure you have this string in the file htaccess RewriteCond $1 !^(index\.php|cron\.php|update\.php|adminer\.php|assets|images|js|css|uploads|favicon.png)
 * cron\.php must be present in the string above.
 */
define('cron','1');
include("index.php");
get(base_url().'cron-job');
if(get_option('email_marketing')){
    get(base_url().'send-mail');
}
$CI =& get_instance();
$options = $CI->options->get_all_options();
// Verify if the tool monitoris is enabled
if(@$options['tool_monitoris']) {
    get(base_url().'user/tool/monitoris?action=check');
    get(base_url().'user/tool/monitoris?action=check-del');
    get(base_url().'user/tool/monitoris?action=check-likes');
    get(base_url().'user/tool/monitoris?action=schedel');
}
// Verify if the tool posts planner is enabled
if(@$options['tool_posts-planner']) {
    get(base_url().'user/tool/posts-planner?action=do-planner');
}
// Verify if the tool emails planner is enabled
if(@$options['tool_emails-planner']) {
    get(base_url().'user/tool/emails-planner?action=do-planner');
}
// Verify if the Bots section is enabled
if(@$options['enable_bots_page']) {
    get(base_url().'bot-cron');
}