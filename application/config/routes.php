<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the 'welcome' class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

// Auth routes
$route['default_controller'] = 'auth/index';
$route['members'] = 'auth/members';
$route['plans'] = 'auth/plans';
$route['login/(:any)'] = 'auth/login/$1';
$route['callback/(:any)'] = 'auth/callback/$1';
$route['auth'] = 'auth/signin';
$route['reset'] = 'auth/passwordreset';
$route['signup/(:num)'] = 'auth/signup/$1';
$route['register'] = 'auth/register';
$route['resend-confirmation'] = 'auth/resend_confirmation';
$route['activate'] = 'auth/activate';
$route['password-reset'] = 'auth/password_reset';
$route['new-password'] = 'auth/new_password';
$route['terms/(:any)'] = 'auth/terms/$1';
$route['guides'] = 'guides/guides';
$route['guides/(:num)'] = 'guides/guides/$1';
$route['about-us'] = 'auth/about_us';
$route['contact-us'] = 'auth/contact_us';
$route['report-bug'] = 'auth/report_bug';
$route['upgrade'] = 'auth/upgrade';
$route['logout'] = 'auth/logout';
$route['cron-job'] = 'cron/run';
$route['oauth2/authorize'] = 'oauth/authorize';

// User routes
$route['user/emails'] = 'marketing/emails';
$route['user/emails/(:any)'] = 'marketing/emails/$1';
$route['user/emails/(:any)/(:num)'] = 'marketing/emails/$1/$2';
$route['user/show-campaigns/(:num)/(:any)'] = 'marketing/show_campaigns/$1/$2';
$route['user/show-lists/(:num)/(:any)'] = 'marketing/show_lists/$1/$2';
$route['user/show-lists-meta/(:num)/(:num)'] = 'marketing/show_lists_meta/$1/$2';
$route['user/show-lists-meta/(:num)/(:num)/(:num)'] = 'marketing/show_lists_meta/$1/$2/$3';
$route['unsubscribe/(:num)/(:any)/(:any)'] = 'marketing/unsubscribe/$1/$2/$3';
$route['user/schedules/(:any)/(:num)/(:num)'] = 'marketing/schedules/$1/$2/$3';
$route['user/schedules/(:any)/(:num)/(:num)/(:num)'] = 'marketing/schedules/$1/$2/$3/$4';
$route['seen/(:num)/(:num)'] = 'marketing/mail/$1/$2';
$route['send-mail'] = 'marketing/send_mail';
$route['user/activities'] = 'userarea/activities';
$route['user/tool/(:any)'] = 'userarea/tool/$1';
$route['user/tools'] = 'userarea/tools';
$route['user/tools/(:any)'] = 'userarea/tools/$1';
$route['user/bots'] = 'bots/bots';
$route['user/bots/(:any)'] = 'bots/bots/$1';
$route['user/bot/(:any)'] = 'bots/bot/$1';
$route['bot-cron'] = 'bots/bot_cron';
$route['user/networks'] = 'userarea/networks';
$route['user/networks/(:any)'] = 'userarea/networks/$1';
$route['user/settings'] = 'userarea/settings';
$route['user/plans'] = 'userarea/plans';
$route['user/success-payment'] = 'userarea/success_payment';
$route['user/upgrade/(:num)'] = 'userarea/upgrade/$1';
$route['user/upgrade/(:num)/(:any)'] = 'userarea/upgrade/$1/$2';
$route['user/notifications'] = 'userarea/notifications';
$route['user/option/(:any)'] = 'userarea/set_option/$1';
$route['user/get-notification/(:num)'] = 'userarea/get_notification/$1';
$route['user/del-notification/(:num)'] = 'userarea/del_notification/$1';
$route['user/delete-account'] = 'userarea/delete_user_account';
$route['user/content-from-url'] = 'userarea/content_from_url';
$route['user/save-token/(:any)/(:any)'] = 'userarea/save_token/$1/$2';
$route['user/change-blog/(:any)/(:any)'] = 'userarea/change_blog/$1/$2';
$route['user/connect/(:any)'] = 'userarea/connect/$1';
$route['user/disconnect/(:num)'] = 'userarea/disconnect/$1';
$route['user/callback/(:any)'] = 'userarea/callback/$1';
$route['user/search-posts/(:any)'] = 'userarea/search_posts/$1';
$route['(:any)'] = 'userarea/short/$1';
$route['user/statistics/(:num)'] = 'userarea/get_statistics/$1';
$route['user/unconfirmed-account'] = 'userarea/unconfirmed_account';
$route['user/bookmark/(:any)'] = 'userarea/bookmark/$1';
$route['user/faq-page'] = 'ticketsarea/faq_page';
$route['user/faq-categories/(:num)'] = 'ticketsarea/faq_categories/$1';
$route['user/faq-article/(:num)'] = 'ticketsarea/faq_article/$1';
$route['user/get-ticket/(:num)'] = 'ticketsarea/ticket/$1';
$route['user/team'] = 'teams/team';
$route['user/insights'] = 'insights/insights_page';
$route['user/insights/(:num)'] = 'insights/insights_page/$1';
$route['user/verify-coupon/(:any)'] = 'coupons/verify_coupon/$1';
$route['user/planner'] = 'planner/display_planner';
$route['user/get-planner-data/(:num)/(:num)'] = 'planner/display_emails_posts/$1/$2';
$route['user/get-email-data/(:num)'] = 'planner/get_email_data/$1/$2';
$route['user/app/(:any)'] = 'userarea/apps/$1';
$route['user/app-ajax/(:any)'] = 'userarea/apps_ajax/$1';
$route['user/ajax/(:any)'] = 'userarea/ajax/$1';
$route['user/print-invoice/(:num)'] = 'invoices/print_invoice/$1';
$route['bots/(:any)'] = 'userarea/bots/$1';

// Admin routes
$route['admin/home'] = 'adminarea/dashboard';
$route['admin/auto-publish'] = 'adminarea/scheduled_posts';
$route['admin/notifications'] = 'adminarea/notifications';
$route['admin/users'] = 'adminarea/users';
$route['admin/apps'] = 'apps/admin_apps';
$route['admin/apps/(:any)'] = 'apps/admin_apps/$1';
$route['admin/tools'] = 'adminarea/tools';
$route['admin/bots'] = 'bots/manage_bots';
$route['admin/networks'] = 'adminarea/networks';
$route['admin/network/(:any)'] = 'adminarea/network/$1';
$route['admin/connect/(:any)'] = 'adminarea/connect/$1';
$route['admin/callback/(:any)'] = 'adminarea/callback/$1';
$route['admin/plans'] = 'plans_manager/admin_plans';
$route['admin/plans/(:num)'] = 'plans_manager/admin_plans/$1';
$route['admin/delete-plan/(:num)'] = 'adminarea/delete_plan/$1';
$route['admin/settings'] = 'adminarea/settings';
$route['admin/appearance'] = 'adminarea/appearance';
$route['admin/contents'] = 'adminarea/contents';
$route['admin/terms-and-policies'] = 'adminarea/terms_policies';
$route['admin/payment/(:any)'] = 'adminarea/payment/$1';
$route['admin/notification'] = 'adminarea/notification';
$route['admin/update'] = 'adminarea/update';
$route['admin/upnow'] = 'adminarea/upnow';
$route['admin/upnow/1'] = 'adminarea/upnow/$1';
$route['admin/get-notifications'] = 'adminarea/get_notifications';
$route['admin/get-notification/(:num)'] = 'adminarea/get_notification/$1';
$route['admin/del-notification/(:num)'] = 'adminarea/del_notification/$1';
$route['admin/delete-user/(:num)'] = 'adminarea/delete_user/$1';
$route['admin/update-user'] = 'adminarea/update_user';
$route['admin/search-users/(:num)/(:any)'] = 'adminarea/search_users/$1/$2';
$route['admin/show-users/(:num)/(:num)'] = 'adminarea/show_users/$1/$2';
$route['admin/show-users/(:num)/(:num)/(:any)'] = 'adminarea/show_users/$1/$2/$3';
$route['admin/user-info/(:num)'] = 'adminarea/user_info/$1';
$route['admin/new-user'] = 'adminarea/new_user';
$route['admin/create-user'] = 'adminarea/create_user';
$route['admin/statistics/(:num)'] = 'adminarea/get_statistics/$1';
$route['admin/option/(:any)'] = 'adminarea/set_option/$1';
$route['admin/option/(:any)/(:any)'] = 'adminarea/set_option/$1/$2';
$route['admin/upmedia'] = 'adminarea/upmedia';
$route['admin/tickets'] = 'ticketsarea/all_tickets';
$route['admin/tickets/(:num)'] = 'ticketsarea/all_tickets/$1';
$route['admin/new-faq-article'] = 'ticketsarea/new_faq_article';
$route['admin/faq-articles/(:num)'] = 'ticketsarea/faq_articles/$1';
$route['admin/get-ticket/(:num)'] = 'ticketsarea/ticket_info/$1';
$route['admin/delete-ticket/(:num)'] = 'ticketsarea/delete_ticket_as_admin/$1';
$route['admin/get-all-tickets/(:any)/(:any)'] = 'ticketsarea/get_all_tickets/$1/$2';
$route['admin/user-activities/(:num)'] = 'statistics/user_activities/$1';
$route['admin/user-data/(:num)/(:num)/(:num)'] = 'statistics/user_data/$1/$2/$3';
$route['admin/coupon-codes'] = 'coupons/codes';
$route['admin/coupon-codes/(:num)'] = 'coupons/get_all_codes/$1';
$route['admin/delete-code/(:any)'] = 'coupons/delete_code/$1';
$route['admin/invoices/(:num)'] = 'invoices/invoices/$1';
$route['admin/get-invoices/(:num)'] = 'invoices/get_invoices/$1';
$route['admin/get-invoice/(:num)'] = 'invoices/get_invoice/$1';
$route['admin/delete-invoice/(:num)'] = 'invoices/delete_invoice/$1';
$route['admin/send-invoice/(:num)'] = 'invoices/send_invoice/$1';
$route['admin/invoice-settings'] = 'invoices/invoice_settings';
$route['admin/get-invoice-settings'] = 'invoices/get_invoice_settings';
$route['admin/guides'] = 'guides/all_guides';
$route['admin/get-guides'] = 'guides/get_guides';
$route['admin/get-guide/(:num)'] = 'guides/get_guide/$1';
$route['admin/del-guide/(:num)'] = 'guides/del_guide/$1';
$route['admin/ajax/(:any)'] = 'adminarea/ajax/$1';

$route['user/show-accounts/(:any)/(:num)'] = 'userarea/show_accounts/$1/$2';
$route['user/show-accounts/(:any)/(:num)/(:any)'] = 'userarea/show_accounts/$1/$2/$3';
$route['user/search-accounts/(:any)/(:any)'] = 'userarea/search_accounts/$1/$2';

// Default
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/* End of file routes.php */
/* Location: ./application/config/routes.php */