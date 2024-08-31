<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            //for staff
            'dashboard'        => ['read' => 'dashboard_read'],
            'product management' => ['read' => 'product_management_read'],
                'product'          => ['read' => 'product_read', 'create' => 'product_create', 'update' => 'product_update', 'delete' => 'product_delete','status'=>'product_status_change', 'export'=>'product_export'],
                'category'         => ['read' => 'category_read', 'create' => 'category_create', 'update' => 'category_update', 'delete' => 'category_delete'],
                'brands'        => ['read'=> 'brand_read', 'create'=>'brand_create', 'update'=>'brand_update', 'delete'=>'brand_delete'],
                'attribute'     => ['read'=>'attribute_read', 'create'=>'attribute_create', 'update'=> 'attribute_update', 'delete'=> 'attribute_delete', 'add value'=>'attribute_value_create', 'update value'=>'attribute_value_update', 'delete value'=>'attribute_value_delete'],
                'manufacturer'  => ['read'=>'manufacturer_read', 'create'=>'manufacturer_create', 'update'=>'manufacturer_update', 'delete'=>'manufacturer_delete'],
                'unit'          => ['read'=>'unit_read', 'create'=>'unit_create', 'update'=>'unit_update', 'delete'=>'unit_delete'],
                'bulk import'   => ['read'=>'bulk_import_read'],
                'bulk export'   => ['read'=>'bulk_export_read'],
            'order management'  => ['read'=>'order_management_read'],
                'customer order' =>['read'=>'customer_order_read'],
                        'customer cart list' => ['read'=>'customer_cart_list_read', 'details'=> 'customer_cart_list_details', 'update'=>'customer_cart_list_update', 'delete'=>'customer_cart_list_delete'],
                        'customer order list' => ['read' => 'customer_order_list_read', 'edit' => 'customer_order_list_edit', 'details' => 'customer_order_list_details', 'read invoice'=> 'customer_order_list_read_invoice',
                            'update' => 'customer_order_list_update', 'delete' => 'customer_order_list_delete', 'cancel'=> 'customer_order_list_cancel', 'claim order' => 'customer_order_list_claim',],
                        'customer order claim'  => ['read' => 'customer_order_claim_read', 'claim details' => 'customer_order_claim_details', 'status change' => 'customer_order_claim_status_change', 'claim reply' => 'customer_order_claim_reply'],
                        'customer product request' => ['read'=> 'customer_order_product_request_read', 'approve'=> 'customer_order_product_request_approve', 'cancel'=> 'customer_order_product_request_cancel', 'add to cart' =>'customer_order_product_request_add_to_cart',],
                'my order'      => ['read' =>  'my_order_read'],
                        'my cart list' => ['read'=>'my_order_cart_list_read', 'details'=> 'my_order_cart_list_details', 'update'=>'my_order_cart_list_update', 'delete'=>'my_order_cart_list_delete'],
                        'my order list' => ['read'=> 'my_order_list_read', 'details'=> 'my_order_list_details', 'update'=>'my_order_list_update', 'delete'=>'my_order_list_delete'],
                        'payment'  => ['payment'=> 'make_payment'],

            'portfolio & inspiration'   => ['read'=>'portfolio_and_inspiration_read'],
                'section category list' => ['read'=>'section_category_read', 'create'=>'section_category_create', 'update'=>'section_category_update', 'delete'=>'section_category_delete'],
                'portfolio inspiration' =>  ['read'=>'portfolio_and_inspiration_read', 'create'=>'portfolio_and_inspiration_create', 'update'=>'portfolio_and_inspiration_update', 'delete'=> 'portfolio_inspiration_delete', 'description'=>'read_portfolio_inspiration_description','create_section'=>'add_portfolio_inspiration_section'],

            'gallery'           =>['read'=>'gallery_read', 'create'=>'gallery_create', 'update'=>'gallery_update','delete'=>'gallery_delete', 'images'=>'read_images', 'add image'=>'create_image'],
            'event management'  =>['read'=>'event_management_read'],
            'event type'        =>['read'=>'event_type_read', 'create'=>'event_type_create', 'update'=>'event_type_update', 'delete'=>'event_type_delete', 'change status'=>'event_type_change_status'],
            'events'            =>['read'=>'event_read', 'create'=>'event_create', 'update'=>'event_update', 'delete'=>'event_delete', 'change status'=>'event_change_status','calender'=>'event_calender_read'],
            'assign user'       =>['assign'=>'assign_user_read'],

            'blog'              =>['read'=>'blog_read'],
                'blog category'      =>['read'=>'blog_category_read', 'create'=>'blog_category_create', 'update'=>'blog_category_update', 'delete'=>'blog_category_delete', 'status change' => 'blog_category_status_change'],
                'blog post'     =>['read'=>'blog_post_read', 'create'=>'blog_post_create', 'update'=>'blog_post_update', 'delete'=>'blog_post_delete', 'details'=>'blog_post_details', 'status change' => 'blog_post_status_change', 'Publish Status Change'=>'blog_post_publish_status_change'],

            'users'             => ['read' => 'user_read', 'create' => 'user_create', 'update' => 'user_update', 'delete' => 'user_delete'],

            'user management'   =>  ['read'=>'user_management_read'],
                'customers management'     => ['read'=>'customers_read', 'delete'=>'customers_delete', 'profile'=>'customers_profile'],
                'manufacturer management'     => ['read'=>'manufacturer_read', 'delete'=>'manufacturer_delete', 'profile'=>'manufacturer_profile'],
                'designer management'   =>  ['read'=>'designer_read', 'delete'=>'designer_delete', 'profile'=>'designer_profile'],
                'employees management'   =>  ['read'=>'employees_read', 'create'=>'employees_create', 'delete'=>'employees_delete', 'profile'=>'employees_profile'],

            'subscribers'       =>['read'=>'subscribers_read', 'status change'=>'subscribers_status_change', 'reply'=>'subscribers_reply', 'delete'=>'subscriber_delete'],
            'designer contact'  =>['read' => 'designer_contact_read', 'reply'=>'designer_contact_reply', 'delete'=>'designer_contact_delete'],
            'marketing'         => ['read' => 'marketing_read'],
                'email campaign'=> ['read'=>'email_campaign_read', 'add campaign' => 'add_email_campaign', 'update'=>'email_campaign_update', 'delete'=>'email_campaign_delete', 'assign user' => 'email_campaign_assign_user', 'status change' => 'email_campaign_status_change'],

            'contact request'   =>['read'=>'contact_request_read', 'status change'=>'contact_request_status_change', 'reply'=>'contact_request_reply', 'delete'=>'contact_request_delete'],
            'roles'             => ['read' =>  'role_read', 'create' => 'role_create', 'update' =>  'role_update', 'delete' =>  'role_delete', 'permission'=>'give_permission'],

            'plan & subscription' => ['read'=> 'plan_subscription_read'],
                'plan' => ['read' => 'plan_read', 'create' => 'plan_create', 'update' => 'plan_update', 'status change' => 'plan_status_change', 'make popular' => 'plan_make_popular'],
                'subscription' => ['read' => 'subscription_read', 'details' => 'subscription_details'],

            'frontend cms'      => ['read'=>'frontend_cms_read'],
                'footer_widget' =>  ['read'=>'footer_widget_read', 'update' =>'footer_widget_update', 'delete' => 'footer_widget_delete'],
                'pages'         => ['read' =>'pages_read', 'update'=>'pages_update'],
                'faqs'          => ['read'=>'faqs_read', 'create'=>'faqs_create', 'update'=>'faqs_update', 'delete'=>'faqs_delete'],
                'slider'        => ['read'=> 'slider_read', 'create'=>'slider_create', 'update'=>'slider_update', 'delete'=>'slider_delete', 'status change' => 'slider_status_change'],

            'system settings'   =>['read'=>'system_settings_read'],
                'general settings'  => ['read' =>  'general_settings_read', 'update' => 'general_settings_update'],
                'file system'       => ['read' => 'file_system_read', 'update' => 'file_system_update'],
                'shop settings'     =>['read'=>'shop_settings_read'],
                    'site info'     =>['read'=>'site_info_read', 'update'=>'site_info_update'],
                    'site logo'     => ['read'=>'site_logo_read', 'update'=>'site_logo_read'],
                    'social links'     => ['read'=>'social_links_logo_read', 'update'=>'social_links_update'],
                    'terms & policies'  => ['read'=>'terms_and_policies_read', 'update'=>'terms_and_policies_update'],
                'global settings'   => ['read' =>  'global_settings_read', 'update' => 'global_settings_update'],
                'payment method'    => ['read' =>  'payment_method_read', 'create' => 'payment_method_create', 'update' => 'payment_method_update', 'delete' => 'payment_method_delete', 'status change' => 'payment_method_status_change'],
                'email settings'    => ['read' =>  'email_settings_read', 'update' => 'email_settings_update', 'test_email' =>'send_test_email', 'create' => 'email_settings_create'],
                'background settings'   => ['read'=>'background_settings_read', 'status change'=>'background_settings_status_change', 'create'=>'background_settings_create', 'update' => 'background_settings_update', 'delete' => 'background_settings_delete'],
                'color themes'  =>['read'=>'color_themes_read', 'create' =>'color_themes_create', 'update'=>'color_themes_update', 'delete'=>'color_themes_delete', 'apply' =>'color_themes_apply'],
                'language'          => ['read' =>  'language_settings_read', 'create' => 'language_settings_create', 'update' =>  'language_settings_update','update terms' =>  'language_settings_update_terms', 'delete' =>  'language_settings_delete', 'status change'=> 'language_settings_status_change'],
                'storage settings'  => ['read' =>  'storage_settings_read', 'update' => 'storage_settings_update'],

        ];

        foreach($attributes as $key => $attribute){
        	$permission               = new Permission();
        	$permission->attribute    = $key;
            $permission->keywords     = $attribute;
        	$permission->save();
        }

        $roles = \App\Models\Role::whereIn('id', [1, 2, 3,5])->get();

        foreach ($roles as $key => $role) {
            if ($role->id == 1) {
                $role->permissions = ["dashboard_read", "product_management_read", "product_read", "product_create", "product_update", "product_delete", "product_status_change", "product_export",
                    "category_read", "category_create", "category_update", "category_delete", "brand_read", "brand_create", "brand_update", "brand_delete", "attribute_read", "attribute_create",
                    "attribute_update", "attribute_delete", "attribute_value_create", "attribute_value_update", "attribute_value_delete", "manufacturer_read", "manufacturer_create", "manufacturer_update", "manufacturer_delete",
                    "unit_read", "unit_create", "unit_update", "unit_delete", "bulk_import_read", "bulk_export_read", "order_management_read", "customer_order_read", "customer_cart_list_read", "customer_cart_list_details",
                    "customer_cart_list_update", "customer_cart_list_delete", "customer_order_list_read", "customer_order_list_edit", "customer_order_list_details", "customer_order_list_read_invoice",
                    "customer_order_list_update", "customer_order_list_delete", "customer_order_list_cancel", "customer_order_list_claim", "customer_order_claim_read", "customer_order_claim_details",
                    "customer_order_claim_status_change", "customer_order_claim_reply", "customer_order_product_request_read", "customer_order_product_request_approve", "customer_order_product_request_cancel",
                    "my_order_read", "my_order_cart_list_read", "my_order_cart_list_details", "my_order_cart_list_update", "my_order_cart_list_delete", "my_order_list_read", "my_order_list_details",
                    "my_order_list_update", "my_order_list_delete", "make_payment", "portfolio_and_inspiration_read", "section_category_read", "section_category_create", "section_category_update",
                    "section_category_delete", "portfolio_and_inspiration_read", "portfolio_and_inspiration_create", "portfolio_and_inspiration_update", "portfolio_inspiration_delete",
                    "read_portfolio_inspiration_description", "add_portfolio_inspiration_section", "gallery_read", "gallery_create", "gallery_update", "gallery_delete", "read_images", "create_image",
                    "blog_read", "blog_category_read", "blog_category_create", "blog_category_update", "blog_category_delete", "blog_category_status_change", "blog_post_read", "blog_post_create",
                    "blog_post_update", "blog_post_delete", "blog_post_details", "blog_post_status_change","blog_post_publish_status_change", "user_read", "user_create", "user_update", "user_delete", "user_management_read",
                    "customers_read", "customers_delete", "customers_profile", "manufacturer_read", "manufacturer_delete", "manufacturer_profile", "designer_read", "designer_delete", "designer_profile",
                    "employees_read", "employees_create", "employees_delete", "employees_profile", "subscribers_read", "subscribers_status_change", "subscribers_reply", "subscriber_delete", "designer_contact_read",
                    "designer_contact_reply", "designer_contact_delete", "marketing_read", "email_campaign_read", "add_email_campaign", "email_campaign_update", "email_campaign_delete", "email_campaign_assign_user",
                    "email_campaign_status_change", "contact_request_read", "contact_request_status_change", "contact_request_reply", "contact_request_delete", "role_read", "role_create", "role_update",
                    "role_delete", "give_permission", "plan_subscription_read", "plan_read", "plan_create", "plan_update", "plan_status_change", "plan_make_popular", "subscription_read", "subscription_details",
                    "frontend_cms_read", "footer_widget_read", "footer_widget_update", "footer_widget_delete", "pages_read", "pages_update", "faqs_read", "faqs_create", "faqs_update", "faqs_delete",
                    "system_settings_read", "general_settings_read", "general_settings_update", "file_system_read", "file_system_update", "shop_settings_read", "site_info_read", "site_info_update",
                    "site_logo_read", "site_logo_read", "social_links_logo_read", "social_links_update", "terms_and_policies_read", "terms_and_policies_update", "global_settings_read", "global_settings_update",
                    "payment_method_read", "payment_method_create", "payment_method_update", "payment_method_delete", "payment_method_status_change","email_settings_read", "email_settings_update",
                    "send_test_email", "email_settings_create", "background_settings_read", "background_settings_status_change", "background_settings_create", "background_settings_update", "background_settings_delete",
                    "color_themes_read", "color_themes_create", "color_themes_update", "color_themes_delete", "color_themes_apply", "language_settings_read", "language_settings_create", "language_settings_update",
                    "language_settings_update_terms", "language_settings_delete", "language_settings_status_change", "storage_settings_read", "storage_settings_update", "slider_read", "slider_update", "slider_delete",
                    "slider_create", "slider_status_change", "event_type_read", "event_type_create", "event_type_update", "event_type_delete", "event_type_change_status", "event_read", "event_create", "event_update",
                    "event_delete", "event_change_status", "event_calender_read", "event_management_read", "assign_user_read"];
            }elseif ($role->id == 2){
                $role->permissions = ["dashboard_read","product_management_read","product_read","product_create","product_update","product_delete","product_status_change","product_export","category_read","category_create","category_update","category_delete","brand_read","brand_create","brand_update","brand_delete","attribute_read","attribute_create","attribute_update","attribute_delete","attribute_value_create","attribute_value_update","attribute_value_delete","manufacturer_read","manufacturer_create","manufacturer_update","manufacturer_delete","unit_read","unit_create","unit_update","unit_delete","bulk_import_read","bulk_export_read","order_management_read","customer_order_read","customer_cart_list_read","customer_cart_list_details","customer_cart_list_update","customer_cart_list_delete","customer_order_list_read","customer_order_list_edit","customer_order_list_details","customer_order_list_read_invoice","customer_order_list_update","customer_order_list_delete","customer_order_list_cancel","customer_order_list_claim","customer_order_claim_read","customer_order_claim_details","customer_order_claim_status_change","customer_order_claim_reply","customer_order_product_request_read","customer_order_product_request_approve","customer_order_product_request_cancel","my_order_read","my_order_cart_list_read","my_order_cart_list_details","my_order_cart_list_update","my_order_cart_list_delete","my_order_list_read","my_order_list_details","my_order_list_update","my_order_list_delete","make_payment","portfolio_and_inspiration_read","section_category_read","section_category_create","section_category_update","section_category_delete","portfolio_and_inspiration_read","portfolio_and_inspiration_create","portfolio_and_inspiration_update","portfolio_inspiration_delete","read_portfolio_inspiration_description","add_portfolio_inspiration_section","gallery_read","gallery_create","gallery_update","gallery_delete","read_images","create_image","blog_read","blog_category_read","blog_category_create","blog_category_update","blog_category_delete","blog_category_status_change","blog_post_read","blog_post_create","blog_post_update","blog_post_delete","blog_post_details","blog_post_status_change","user_read","user_create","user_update","user_delete","user_management_read","customers_read","customers_delete","customers_profile","manufacturer_read","manufacturer_delete","manufacturer_profile","designer_read","designer_delete","designer_profile","employees_read","employees_create","employees_delete","employees_profile","subscribers_read","subscribers_status_change","subscribers_reply","subscriber_delete","designer_contact_read","designer_contact_reply","designer_contact_delete","marketing_read","email_campaign_read","add_email_campaign","email_campaign_update","email_campaign_delete","email_campaign_assign_user","email_campaign_status_change","contact_request_read","contact_request_status_change","contact_request_reply","contact_request_delete","frontend_cms_read","footer_widget_read","footer_widget_update","footer_widget_delete","pages_read","pages_update","faqs_read","faqs_create","faqs_update","faqs_delete","system_settings_read","general_settings_read","general_settings_update","file_system_read","file_system_update","shop_settings_read","site_info_read","site_info_update","site_logo_read","site_logo_read","social_links_logo_read","social_links_update","terms_and_policies_read","terms_and_policies_update","global_settings_read","global_settings_update","payment_method_read","payment_method_create","payment_method_update","payment_method_delete","payment_method_status_change","email_settings_read","email_settings_update","send_test_email","email_settings_create","background_settings_read","background_settings_status_change","background_settings_create","background_settings_update","background_settings_delete","color_themes_read","color_themes_create","color_themes_update","color_themes_delete","color_themes_apply","language_settings_read","language_settings_create","language_settings_update","language_settings_update_terms","language_settings_delete","language_settings_status_change","storage_settings_read","storage_settings_update", "slider_read", "slider_update", "slider_delete","slider_create", "slider_status_change"];
            }elseif ($role->id == 3){
                $role->permissions = ["dashboard_read","product_management_read","product_read","product_create","product_update","product_delete","product_status_change","product_export","category_read","category_create","category_update","category_delete","brand_read","brand_create","brand_update","brand_delete","attribute_read","attribute_create","attribute_update","attribute_delete","attribute_value_create","attribute_value_update","attribute_value_delete","manufacturer_read","manufacturer_create","manufacturer_update","manufacturer_delete","unit_read","unit_create","unit_update","unit_delete","bulk_import_read","bulk_export_read","order_management_read","customer_order_read","customer_cart_list_read","customer_cart_list_details","customer_cart_list_update","customer_cart_list_delete","customer_order_list_read","customer_order_list_edit","customer_order_list_details","customer_order_list_read_invoice","customer_order_list_update","customer_order_list_delete","customer_order_list_cancel","customer_order_list_claim","customer_order_claim_read","customer_order_claim_details","customer_order_claim_status_change","customer_order_claim_reply","customer_order_product_request_read","customer_order_product_request_approve","customer_order_product_request_cancel","my_order_read","my_order_cart_list_read","my_order_cart_list_details","my_order_cart_list_update","my_order_cart_list_delete","my_order_list_read","my_order_list_details","my_order_list_update","my_order_list_delete","make_payment","portfolio_and_inspiration_read","section_category_read","section_category_create","section_category_update","section_category_delete","portfolio_and_inspiration_read","portfolio_and_inspiration_create","portfolio_and_inspiration_update","portfolio_inspiration_delete","read_portfolio_inspiration_description","add_portfolio_inspiration_section","gallery_read","gallery_create","gallery_update","gallery_delete","read_images","create_image","blog_read","blog_category_read","blog_category_create","blog_category_update","blog_category_delete","blog_category_status_change","blog_post_read","blog_post_create","blog_post_update","blog_post_delete","blog_post_details","blog_post_status_change","designer_contact_read","designer_contact_reply","designer_contact_delete","contact_request_read","contact_request_status_change","contact_request_reply","contact_request_delete","frontend_cms_read","footer_widget_read","footer_widget_update","footer_widget_delete","pages_read","pages_update","system_settings_read","shop_settings_read","site_info_read","site_info_update","site_logo_read","site_logo_read","social_links_logo_read","social_links_update","terms_and_policies_read","terms_and_policies_update", "slider_read", "slider_update", "slider_delete", "slider_create", "slider_status_change"];
            }else{
                $role->permissions = ["dashboard_read","product_management_read","product_read","product_create","product_update","product_delete","product_status_change","product_export","category_read","category_create","category_update","category_delete","brand_read","brand_create","brand_update","brand_delete","attribute_read","attribute_create","attribute_update","attribute_delete","attribute_value_create","attribute_value_update","attribute_value_delete","manufacturer_read","manufacturer_create","manufacturer_update","manufacturer_delete","unit_read","unit_create","unit_update","unit_delete","bulk_import_read","bulk_export_read","order_management_read","customer_order_read","customer_cart_list_read","customer_cart_list_details","customer_cart_list_update","customer_cart_list_delete","customer_order_list_read","customer_order_list_edit","customer_order_list_details","customer_order_list_read_invoice","customer_order_list_update","customer_order_list_delete","customer_order_list_cancel","customer_order_list_claim","customer_order_claim_read","customer_order_claim_details","customer_order_claim_status_change","customer_order_claim_reply"];
            }
            $role->save();

        }
    }
}
