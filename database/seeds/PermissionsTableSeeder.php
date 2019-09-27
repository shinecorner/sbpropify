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
        ['delete-comment', 'Delete Comment', 'delete existing comment'],
        // Pinboard
        ['list-pinboard', 'List Pinboard', 'list all pinboard'],
        ['view-pinboard', 'View Pinboard', 'view pinboard'],
        ['add-pinboard', 'Add Pinboard', 'add pinboard'],
        ['edit-pinboard', 'Edit Pinboard', 'edit existing pinboard'],
        ['delete-pinboard', 'Delete Pinboard', 'delete existing pinboard'],
        ['(un)publish-pinboard', 'Publish Pinboard', 'publish pinboard'],
        ['pin-pinboard', 'Pin Pinboard', 'pin pinboard'],
        ['assign-pinboard', 'Assign Pinboard', 'assign pinboard'],
        ['list_views-pinboard', 'List views of Pinboard', 'list views of pinboard'],
        // Product
        ['list-product', 'List Products', 'list all products'],
        ['view-product', 'View Product', 'view product'],
        ['add-product', 'Add Product', 'add product'],
        ['edit-product', 'Edit Product', 'edit existing product'],
        ['delete-product', 'Delete Product', 'delete existing product'],
        ['(un)publish-product', 'Publish Product', 'publish product'],
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
        ['assign-unit', 'Assigned related to unit', 'assigned related to unit'],
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
        ['assign-quarter', 'Assign property manager, user quarter', 'Assign property manager, user quarter'],
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
        // Tag
        ['list-tag', 'List tag', 'list tag'],
        ['view-tag', 'View tag', 'view tag'],
        ['add-tag', 'Add tag', 'add tag'],
        ['edit-tag', 'Edit tag', 'edit existing tag'],
        ['delete-tag', 'Delete tag', 'delete existing tag'],
        // Translation
        ['list-translation', 'List translation', 'list translation'],
        ['view-translation', 'View translation', 'view translation'],
        ['add-translation', 'Add translation', 'add translation'],
        ['edit-translation', 'Edit translation', 'edit existing translation'],
        ['delete-translation', 'Delete translation', 'delete existing translation'],
        // download
        ['download_pdf-request', 'Download pdf request', 'download pdf request'],
        // internal notice
        ['list-internal_notice', 'List Internal notices', 'list Internal notices'],
        ['view-internal_notice', 'View Internal notice', 'view internal notices'],
        ['add-internal_notice', 'Add Internal notice', 'add internal notices'],
        ['edit-internal_notice', 'Edit Internal notice', 'edit existing internal noticess'],
        ['delete-internal_notice', 'Delete Internal notice', 'delete existing internal notices'],
        //media upload
        ['add_media_upload-quarter', 'Add media upload quarter', 'add media upload quarter'],
        ['delete_media_upload-quarter', 'Add media upload quarter', 'add media upload quarter'],
        ['add_media_upload-building', 'Add media upload building', 'add media upload building'],
        ['delete_media_upload-building', 'Add media upload building', 'add media upload building'],
        ['add_media_upload-pinboard', 'Add media upload pinboard', 'add media upload pinboard'],
        ['delete_media_upload-pinboard', 'Add media upload pinboard', 'add media upload pinboard'],
        ['add_media_upload-product', 'Add media upload product', 'add media upload product'],
        ['delete_media_upload-product', 'Add media upload product', 'add media upload product'],
        ['add_media_upload-tenant', 'Add media upload tenant', 'add media upload tenant'],
        ['delete_media_upload-tenant', 'Add media upload tenant', 'add media upload tenant'],
        ['add_media_upload-request', 'Add media upload request', 'add media upload request'],
        ['delete_media_upload-request', 'Add media upload request', 'add media upload request'],
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
