<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    const ps = [
        // User
        ['list-user', 'List Users', 'list all users'],
        ['view-user', 'View Users', 'view users'],
        ['add-user', 'Add User', 'add user'],
        ['edit-user', 'Edit User', 'edit existing user'],
        ['delete-user', 'Delete User', 'delete existing user'],
        ['edit-user_setting', 'Edit user setting', 'edit user setting'],
        ['view-user_setting', 'View user setting', 'view user setting'],
        // Tenant
        ['list-tenant', 'List Tenants', 'list tenants'],
        ['view-tenant', 'View Tenant', 'view tenant'],
        ['add-tenant', 'Add Tenant', 'add tenant'],
        ['edit-tenant', 'Edit Tenant', 'edit existing tenant'],
        ['delete-tenant', 'Delete Tenant', 'delete existing tenant'],
        ['send_credentials-tenant', 'Send credentials', 'Send tenant credentials'],
        ['download_credentials-tenant', 'Download credentials', 'Download tenant credentials'],
        // Comment
        ['add-comment', 'Add Comment', 'add comment'],
        ['edit-comment', 'Edit Comment', 'edit existing comment'],
        // Post
        ['list-post', 'List Posts', 'list all posts'],
        ['view-post', 'View Post', 'view post'],
        ['add-post', 'Add Post', 'add post'],
        ['edit-post', 'Edit Post', 'edit existing post'],
        ['delete-post', 'Delete Post', 'delete existing post'],
        ['publish-post', 'Publish Post', 'publish post'],
        ['pin-post', 'Pin Post', 'pin post'],
        ['assign-post', 'Assign Post', 'assign post'],
        ['list_views-post', 'List views of Post', 'list views of post'],
        // Product
        ['list-product', 'List Products', 'list all products'],
        ['view-product', 'View Product', 'view product'],
        ['add-product', 'Add Product', 'add product'],
        ['edit-product', 'Edit Product', 'edit existing product'],
        ['delete-product', 'Delete Product', 'delete existing product'],
        ['publish-product', 'Publish Product', 'publish product'],
        // Provider
        ['list-provider', 'List service provider', 'list all service providers'],
        ['add-provider', 'Add service provider', 'add service provider'],
        ['view-provider', 'View service provider', 'view service provider'],
        ['edit-provider', 'Edit service provider', 'edit service provider'],
        ['delete-provider', 'Delete service provider', 'delete service provider'],
        ['notify-provider', 'Notify service provider', 'Notify provider, property managers and admins'],
        ['assign-provider', 'Assign quarter and building to provider', 'Assign quarter and building to provider'],
        // Request
        ['list-request', 'List ServiceRequests', 'list all ServiceRequests'],
        ['add-request', 'Add ServiceRequests', 'add serviceRequest'],
        ['edit-request', 'Edit ServiceRequests', 'edit existing serviceRequest'],
        ['delete-request', 'Delete ServiceRequests', 'delete existing serviceRequest'],
        ['assign-request', 'Assign property manager or admin to the request', 'Assign property manager or admin to the request'],
        // Audit
        ['list-audit', 'List Audit', 'list all audits'],
        // Building
        ['list-building', 'List Buildings', 'list Buildings'],
        ['view-building', 'View Building', 'view buildings'],
        ['add-building', 'Add Building', 'add buildings'],
        ['edit-building', 'Edit Building', 'edit existing buildings'],
        ['delete-building', 'Delete Building', 'delete existing building'],
        ['assign-building', 'Assign managers to building', 'Assign managers to building'],
        // Address
        ['list-address', 'List Address', 'list address'],
        ['view-address', 'View Address', 'view address'],
        ['add-address', 'Add Address', 'add address'],
        ['edit-address', 'Edit Address', 'edit existing address'],
        ['delete-address', 'Delete Address', 'delete existing address'],
        // Unit
        ['list-unit', 'List unit', 'list unit'],
        ['view-unit', 'View unit', 'view unit'],
        ['add-unit', 'Add unit', 'add unit'],
        ['edit-unit', 'Edit unit', 'edit existing unit'],
        ['delete-unit', 'Delete unit', 'delete existing unit'],
        // Property manager
        ['list-property_manager', 'List property manager', 'list property manager'],
        ['view-property_manager', 'View property manager', 'view property manager'],
        ['add-property_manager', 'Add property manager', 'add property manager'],
        ['edit-property_manager', 'Edit property manager', 'edit existing property manager'],
        ['delete-property_manager', 'Delete property manager', 'delete existing property manager'],
        ['assign-property_manager', 'Assign quarter and building to property manager', 'Assign quarter and building to property manager'],
        // Quarter
        ['list-quarter', 'List quarter', 'list quarter'],
        ['view-quarter', 'View quarter', 'view quarter'],
        ['add-quarter', 'Add quarter', 'add quarter'],
        ['edit-quarter', 'Edit quarter', 'edit existing quarter'],
        ['delete-quarter', 'Delete quarter', 'delete existing quarter'],
        // Real estate
        ['view-real_estate', 'View real estate', 'view real estate'],
        ['edit-real_estate', 'Edit real estate', 'edit existing real estate'],
        // Template
        ['list-template', 'List template', 'list template'],
        ['view-template', 'View template', 'view template'],
        ['add-template', 'Add template', 'add template'],
        ['edit-template', 'Edit template', 'edit existing template'],
        ['delete-template', 'Delete template', 'delete existing template'],
        // Service request categories
        ['list-service_request_category', 'List service_request_category', 'list service_request_category'],
        ['view-service_request_category', 'View service_request_category', 'view service_request_category'],
        ['add-service_request_category', 'Add service_request_category', 'add service_request_category'],
        ['edit-service_request_category', 'Edit service_request_category', 'edit existing service_request_category'],
        ['delete-service_request_category', 'Delete service_request_category', 'delete existing service_request_category'],
        // Cleanify requests
        ['list-cleanify_request', 'List cleanify requests', 'list cleanify requests'],
        ['add-cleanify_request', 'Add cleanify requests', 'add cleanify requests'],

        //statistics
        ['view-tenants_statistics', 'View tenants statistics', 'view tenants statistics'],
        ['view-requests_statistics', 'View requests statistics', 'view requests statistics'],
        ['view-buildings_statistics', 'View buildings statistics', 'view buildings statistics'],
        ['view-all_statistics', 'View all statistics', 'view all statistics'],
        ['view-pie_chart_statistics', 'View pie chart statistics', 'view pie chart statistics'],
        ['view-donut_chart_statistics', 'View donut chart statistics', 'view donut chart statistics'],
        ['view-heat_map_statistics', 'View heat map statistics', 'view heat map statistics'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::ps as $p) {
            (new Permission([
                'name' => $p[0],
                'display_name' => $p[1],
                'description' => $p[2],
            ]))->save();
        }
    }
}
