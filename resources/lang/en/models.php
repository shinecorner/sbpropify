<?php
return [
    'user' => 
    [ 
      'administrator' => 'Administrators',
      'super_admin' => 'Super admins',
      'add_admin' => 'Add Administrator',
      'edit_admin' => 'Edit Administrator',
      'add_super_admin' => 'Add Super admin',
      'edit_super_admin' => 'Edit Super admin',
      'edit_action' => 'Edit',
      'delete' => 'Delete',
      'name' => 'Name',
      'phone' => 'Phone',
      'date' => 'Date',
      'email' => 'Email',
      'id' => 'ID',
      'add' => 'Add User',
      'save' => 'Save',
      'saved' => 'User saved successfully',
      'deleted' => 'User deleted',
      'edit' => 'Edit User',
      'not_found' => 'User not found',
      'profile_image' => 'Profile image',
      'profile_text' => 'Profile text',
      'avatar_uploaded' => 'Avatar uploaded',
      'logo_uploaded' => 'Logo uploaded',
      'logo' => 'Logo',
      'address' => 'Address',
      'blank_pdf' => 'Blank pdf',
      'notificationSaved' => 'Notificatin setting saved',
      'realEstateSaved' => 'Real Estate settings saved',
      'serviceRequestCategorySaved' => 'Service request category saved',
      'serviceRequestCategoryDeleted' => 'Service request category deleted',
      'setting_saved' => "user setting saved",
      'setting_deleted' => "user setting deleted",
      'password_reset_request_sent' => "Password Reset Request send successfully", 
      'errors' => [
        'not_found' => "User not found",
        'setting_not_found' => "user setting not found",
        'image_upload' => "User image upload error :",
        'incorrect_password' => "User password incorrect",
        'email_missing' => "email is missing",
        'email_already_exists' => "This [:email] email already exist, Select other email",
        'email_not_exists' => "This [:email] email not exist",
        'password_reset_token_invalid' => "This password reset token is invalid."
      ],
      'validation' => 
      [
        'name' => 
        [
          'required' => 'Name is required',
        ],
        'role' => 
        [
          'required' => 'Role is required',
        ],
      ],
    ],
    'tenant' => 
    [
      'view' => 'View',
      'view_title' => 'View tenant',
      'edit_title' => 'Edit Tenant',
      'download_credentials' => 'Download credentials',
      'send_credentials' => 'Send credentials',
      'credentials_sent' => 'Credentials sent',
      'credentials_send_fail' => 'Credentials file not found. Try updating the tenant password to regenerate it',
      'credentials_download_failed' => 'Credentials file not found. Try updating the tenant password to regenerate it',
      'add' => 'Add Tenant',
      'save' => 'Save',
      'saved' => 'Tenant saved',
      'deleted' => 'Tenant deleted',
      'status_changed' => 'Status changed',
      'password_reset' => 'Tenant password reset successfully',
      'update' => 'Update',
      'name' => 'Name',
      'first_name' => 'First name',
      'last_name' => 'Last name',
      'birth_date' => 'Birth date',
      'language' => 'Language',
      'mobile_phone' => 'Mobile phone',
      'work_phone' => 'Work phone',
      'email' => 'Email',
      'personal_phone' => 'Personal phone',
      'private_phone' => 'Personal phone',
      'created_date' => 'Created Date',
      'created_at' => 'Date',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'id' => 'ID',
      'details' => 'Details',
      'contract' => 'Contract',
      'posts' => 'Posts',
      'products' => 'Products',
      'requests' => 'Requests',
      'company' => 'Company name',
      'no_building' => 'No building',
      'media' => 
      [
        'deleted' => 'Document/Photo Deleted',
        'uploaded' => 'Document/Photo Uploaded',
      ],
      'building' => 
      [
        'name' => 'Building',
      ],
      'unit' => 
      [
        'name' => 'Unit',
      ],
      'search_building' => 'Search building',
      'search_unit' => 'Search unit',
      'search' => 'Search',
      'confirmDelete' => 
      [
        'title' => 'This will permanently delete the tenant.',
        'text' => 'Are you sure?',
      ],
      'validation' => 
      [
        'first_name' => 
        [
          'required' => 'First name is required',
        ],
        'last_name' => 
        [
          'required' => 'Last name is required',
        ],
        'birth_date' => 
        [
          'required' => 'Birth date is required',
        ],
        'building' => 
        [
          'required' => 'Building is required',
        ],
        'unit' => 
        [
          'required' => 'Unit is required',
        ],
        'title' => 
        [
          'required' => 'Title is required',
        ],
        'language' => 
        [
          'required' => 'Language is required',
        ]
      ],
      'errors' => [
        'not_found' => "Tenant not found",
        'incorrect_email' => "Incorrect email address",
        'create' => "Tenant create error: ",
        'update' => "Tenant update error: ",	
        'deleted' => "Tenant Delete error: ",
        'not_allowed_change_status' => 'You are not allowed to change status.',
      ],      
      'building_card' => 'Assign unit',
      'personal_details_card' => 'Personal details',
      'account_info_card' => 'User login',
      'contact_info_card' => 'Contact details',
      'personal_data' => 'Personal data',
      'my_documents' => 'My documents',
      'my_contract' => 'My contract',
      'contact_persons' => 'My contacts',
      'no_contacts' => 'No contacts available',
      'rent_end' => 'Rent end',
      'rent_start' => 'Rent start',
      'rent_contract' => 'Rent contract',
      'contact' => 
      [
        'category' => 'Category',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
      ],
      'titles' => 
      [
        'mr' => 'Mr.',
        'mrs' => 'Mrs.',
        'company' => 'Company',
      ],
      'status' => 
      [
        'label' => 'Status',
        'active' => 'Active',
        'not_active' => 'Not active',
      ],
      'confirmChange' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
    ],
    'building' => 
    [
      'title' => 'Buildings',
      'edit_title' => 'Edit Building',
      'add' => 'Add Building',
      'name' => 'Name',
      'cancel' => 'Cancel',
      'created_at' => 'Date',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'deleted' => 'Building deleted successfully',
      'units' => 'Units',
      'save' => 'Save',
      'saved' => 'Building saved',
      'floors' => 'Floors',
      'basement' => 'Basement',
      'attic' => 'Attic',
      'description' => 'Description',
      'floor_nr' => 'Number of floors',
      'label' => 'Label',
      'address' => 'Address',
      'address_search' => 'Please enter address',
      'not_found' => 'Building not found',
      'house_rules' => 'House rules',
      'operating_instructions' => 'Operating instructions',
      'other' =>  'Other',
      'files' => 'Files',
      'add_files' => 'Add files',
      'add_companies' => 'Add companies',
      'companies' => 'Services companies',
      'no_services' => 'No services added',
      'details' => 'Details',
      'select_media_category' => 'Selected media category',
      'district' => 'District',
      'tenants' => 'Tenants',
      'managers' => 'Managers',
      'requests' => 'Requests',
      'house_nr' => 'House Nr.',
      'assign' => 'Assign',
      'assign_managers' => 'Assign managers',
      'unassign_manager' => 'Unassign',
      'managers_assigned' => 'Managers assigned',
      'occupied_units' => 'Ocuppied units',
      'free_units' => 'Free units',
      'manager' => 
      [
        'unassigned' => 'Manager unassigned',
      ],
      'document' => 
      [
        'uploaded' => 'Document uploaded',
        'deleted' => 'Document deleted',
      ],
      'service' => 
      [
        'deleted' => 'Service removed from this building',
      ],
      'confirmDelete' => 
      [
        'title' => 'This will permanently delete the building.',
        'text' => 'Are you sure?',
      ],
      'validation' => 
      [
        'name' => 
        [
          'required' => 'Name is required',
        ],
        'floor_nr' => 
        [
          'required' => 'Floor number is required',
        ],
        'description' => 
        [
          'required' => 'Description is required',
        ],
        'label' => 
        [
          'required' => 'Label is required',
        ],
        'address_id' => 
        [
          'required' => 'Address is required',
        ],
      ],
      'errors' => [
        'not_found' => "Building not found",
        'manager_not_found' => "Property manager not found",
        'deleted' => "Building deleted error: ",
        'manager_assigned' => "Property Managers assign to Building error: ",
        'provider_deleted' => "Service Provider deleted error: ",
      ],
      'requestStatuses' => 
      [
        'total' => 'Total requests',
        'received' => 'Received requests',
        'assigned' => 'Assigned requests',
        'in_processing' => 'In processing requests',
        'reactivated' => 'Reactivated requests',
        'done' => 'Done requests',
        'archived' => 'Archived requests',
        'solved' => 'Solved requests',
        'pending' => 'Pending requests'
      ],
      'placeholders' => 
      [
        'search' => 'Search',
      ],
      'delete_building_modal' => 
      [
        'title' => 'Delete Building(s)',
        'description_unit' => 'Units are assigned to the selected property. If you want to delete the units as well, please activate the option below.',
        'description_request' => 'Requests are assigned to the selected property. If you also want to delete request as well, please activate the option below.',
        'description_both' => 'Units and requests are assigned to the selected property. If you also want to delete them, please activate the options below.',
        'delete_units' => 'Delete Unit(s)',
        'dont_delete_units' => 'Don\'t Delete Unit(s)',
        'delete_requests' => 'Delete Request(s)',
        'dont_delete_requests' => 'Don\'t Delete Request(s)',
      ],
      'assigned_buildings' => 'Assigned buildings'
    ],
    'unit' => 
    [
      'title' => 'Units',
      'not_found' => 'Unit not found',
      'add' => 'Add Unit',
      'tenantType' => [
        'attached' => 'Tenant attached successfully',
        'detached' => 'Tenant detached successfully'
      ],
      'name' => 'Unit number',
      'created_at' => 'Date',
      'edit' => 'Edit Unit',
      'delete' => 'Remove',
      'deleted' => 'Unit deleted',
      'save' => 'Save',
      'saved' => 'Unit saved',
      'floor' => 'Floor',
      'sq_meter' => 'Sq Meter',
      'room_no' => 'Number of rooms',
      'monthly_rent' => 'Monthly rent',
      'building_search' => 'Please enter a building name and select it',
      'building' => 'Building',
      'description' => 'Description',
      'basement' => 'Basement',
      'attic' => 'Attic',
      'requests' => 'Requests',
      'tenant' => 'Tenant',
      'empty_requests' => 'No requests',
      'assigned_tenant' => 'Assigned tenant',
      'assign' => 'Assign',
      'tenant_assigned' => 'Tenant assigned',
      'tenant_unassigned' => 'Tenant unassigned',
      'type' => 
      [
        'label' => 'Type',
        'apartment' => 'Apartment',
        'business' => 'Business',
      ],
      'confirmDelete' => 
      [
        'title' => 'This will permanently delete the unit.',
        'text' => 'Are you sure?',
      ],
      'validation' => 
      [
        'name' => 
        [
          'required' => 'Name is required',
        ],
        'building' => 
        [
          'required' => 'Building is required',
        ],
        'monthly_rent' => 
        [
          'required' => 'Monthly rent is required',
        ],
        'floor' => 
        [
          'required' => 'Floor is required',
        ],
        'room_no' => 
        [
          'required' => 'Room number is required',
        ],
        'description' => 
        [
          'required' => 'Description is required',
        ],
        'tenant' => 
        [
          'required' => 'Tenant is required',
        ]
      ],
      'errors' => [
        'not_found' => "Unit not found",        
        'create' => "Unit create error: ",
        'update' => "Unit update error: ",
        'tenant_assign' => "Tenant assign error: ",
        'tenant_not_assign' => "Tenant not assigned to this unit",
        'tenant_not_found' => "Tenant not found",
      ],
      'placeholders' => 
      [
        'search' => 'Search',
        'select' => 'Select',
      ],
    ],
    'address' => 
    [
      'add' => 'Add address',
      'created_at' => 'Date',
      'name' => 'Address',
      'edit' => 'Edit',
      'delete' => 'Remove',
      'save' => 'Save',
      'city' => 'City',
      'country' => 'Country',
      'street' => 'Street',
      'street_nr' => 'Street Nr.',
      'zip' => 'Zip',
      'not_found' => 'Address not found',
      'saved' => 'Address saved',
      'confirmDelete' => 
      [
        'title' => 'This will permanently delete the address.',
        'text' => 'Are you sure?',
      ],
      'state' => 
      [
        'label' => 'State',
      ],
      'validation' => 
      [
        'state' => 
        [
          'required' => 'State is required',
        ],
        'city' => 
        [
          'required' => 'City is required',
        ],
        'street' => 
        [
          'required' => 'Street is required',
        ],
        'street_nr' => 
        [
          'required' => 'Street number is required',
        ],
        'zip' => 
        [
          'required' => 'Zip is required',
        ],
      ],
    ],
    'post' => 
    [
      'title' => 'News',
      'title_label' => 'Title',
      'content' => 'Content',
      'preview' => 'Preview',
      'add' => 'Add Post',
      'add_pinned' => 'Add pinned post',
      'save' => 'Save',
      'saved' => 'News saved',
      'view_incresead' => "Views increased successfully",
      'updated' => 'News updated',
      'deleted' => 'News deleted',
      'edit' => 'Edit',
      'edit_title' => 'Edit Post',
      'show' => 'Details',
      'user' => 'User',
      'delete' => 'Delete',
      'likes' => 'Likes',
      'views' => 'Views',
      'tenants' => 'Tenants',
      'details' => 'Post Details',
      'published_at' => 'Published',
      'publish' => 'Publish',
      'unpublish' => 'Unpublish',
      'buildings' => 'Buildings',
      'pinned' => 'Pinned',
      'notify_email' => 'Notify email',
      'pinned_to' => 'Pinned to',
      'comments' => 'Comments',
      'images' => 'Images',
      'details_title' => 'Details',
      'placeholders' => 
      [
        'buildings' => 'Choose buildings',
        'search' => 'Search',
        'search_provider' => 'Search provider',
      ],
      'media' => 
      [
        'deleted' => 'Document/Photo Deleted',
        'uploaded' => 'Document/Photo Uploaded',
      ],
      'type' => 
      [
        'label' => 'Type',
        'article' => 'Article',
        'new_neighbour' => 'New neighbour',
        'pinned' => 'Pinned',
      ],
      'errors' => [
        'not_found' => "Post not found",        
        'district_not_found' => "District not found",
        'building_not_found' => "Building not found",
        'provider_not_found' => "Service provider not found"
      ],      
      'status' => 
      [
        'label' => 'Status',
        'new' => 'New',
        'published' => 'Published',
        'unpublished' => 'Unpublished',
        'not_approved' => 'Not approved',
      ],
      'visibility' => 
      [
        'label' => 'Visibility',
        'address' => 'Address',
        'district' => 'District',
        'all' => 'All',
      ],
      'confirmChange' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'assignment' => 'Assignment',
      'assignType' => 'Type',
      'unassign' => 'Unassign',
      'assign' => 'Assign',
      'attached' => 
      [
        'building' => 'Building assigned',
        'district' => 'District assigned',
        'provider' => 'Provider assigned',
      ],
      'detached' => 
      [
        'building' => 'Buiding unassigned',
        'district' => 'District unassigned',
        'provider' => 'Provider unassigned',
      ],
      'buildingAlreadyAssigned' => 'Building is already inside on a district',
      'confirmUnassign' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'execution_interval' => 
      [
        'label' => 'Execution interval',
        'end' => 'Execution End',
        'start' => 'Execution Start',
        'separator' => 'To',
      ],
      'category' => 
      [
        'label' => 'Category',
        'general' => 'General',
        'maintenance' => 'Maintenance',
        'electricity' => 'Electricity',
        'heating' => 'Heating',
        'sanitary' => 'Sanitary',
      ],
    ],
    'service' => 
    [
      'title' => 'Services',
      'add_title' => 'Add Service',
      'edit_title' => 'Edit Service',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'saved' => 'Service saved',
      'deleted' => 'Service deleted',
      'category' => 'Category',
      'electrician' => 'Electrician',
      'heating_company' => 'Heating company',
      'lift' => 'Lift',
      'sanitary' => 'Sanitary',
      'key_service' => 'Key service',
      'caretaker' => 'Caretaker',
      'real_estate_service' => 'Real estate service',
      'name' => 'Name',
      'requests' => 'Requests',
      'contact_details' => 'Contact details',
      'user_credentials' => 'User credentials',
      'company_details' => 'Company details',
      'assignType' => 'Type',
      'unassign' => 'Unassign',
      'assign' => 'Assign',
      'attached' => 
      [
        'building' => 'Building assigned',
        'district' => 'District assigned',
      ],
      'detached' => 
      [
        'building' => 'Buiding unassigned',
        'district' => 'District unassigned',
      ],
      'buildingAlreadyAssigned' => 'Building is already inside on a district',
      'confirmUnassign' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'placeholders' => 
      [
        'search' => 'Search',
        'category' => 'Select category',
      ],
      'errors' => [
        'not_found' => "Service Provider not found",
        'create' => "Service Provider create error: ",
        'update' => "Service Provider updated error: ",	
        'deleted' => "Service Provider deleted error: ",
        'district_not_found' => "District not found",
        'building_not_found' => "Building not found",
        'building_already_assign' => "Building already assigned through district",
      ],
    ],
    'district' => 
    [
      'title' => 'Districts',
      'name' => 'Name',
      'description' => 'Description',
      "edit" => "Edit District",
      'add' => 'Add District',
      'save' => 'Save',
      'saved' => 'District saved',
      'edit_action' => 'Edit',
      'delete' => 'Delete',
      'deleted' => 'District deleted',
      'cancel' => 'Cancel',
      'required' => 'This field is required',
      'details' => 'Details',
      'buildings' => 'Buildings',
      'errors' => [
        'not_found' => "District not found",
      ],
    ],
    'realEstate' => 
    [
      'title' => 'Settings real estate',
      'details' => 'Details',
      'settings' => 'Settings',
      'iframe' => 'Iframe',
      'theme' => 'Theme',
      'requests' => 'Requests',
      'login_variation' => 'Login variation',
      'login_variation_slider' => 'Do you want to show slider?',
      'district_enable' => 'District',
      'marketplace_approval_enable' => 'Enable Market',
      'news_approval_enable' => 'News approval',
      'comment_update_timeout' => 'Comment update timeout',
      'closed' => 'Closed',
      'saved' => 'Real estate saved',
      'schedule' => 'Schedule',
      'endTime' => 'End time',
      'startTime' => 'Start time',
      'to' => 'To',
      'categories' => 'Categories',
      'templates' => 'Templates',
      'contact_enable' => 'Enable \'My contacts\'',
      'cleanify_email' => 'Cleanify email',
      'mail_encryption' => 'Encryption',
      'primary_color' => 'Primary color',
      'accent_color' => 'Accent color',
      'iframe_enable' => 'Iframe enable',
      'iframe_url' =>
      [
        'label' => 'Iframe URL',
        'validation' => 'Iframe URL should be a valid URL',
      ],
      "mail_from_name" =>
      [
        "label" => "From Name",
        "validation" => "Enter from Name"
      ],
      "mail_from_address" => [
        "label" => "From address",
        "required" => "Enter from email address",
        "email" => "Please enter a valid Email"
      ],
      "mail_host" => [
        "label" => "Host",
        "validation" => "Enter email host"
      ],
      "mail_port" => [
        "label" => "Port",
        "validation" => "Enter email port"
      ],
      "mail_username" => [
        "label" => "Username",
        "validation" => "Enter email username"
      ],
      "mail_password" => [
        "label" => "Password",
        "validation" => "Enter email password"
      ],
      'errors' => [
        'not_found' => "Real Estate not found",
        'update' => "Real Estate update error: ",
      ],
    ],
    'request' => 
    [
      'audits' => 'Audits',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'deleted' => 'Request deleted',      
      'title' => 'Requests',
      'created' => 'Created',
      'saved' => 'Request saved',
      'prop_title' => 'Title',
      'description' => 'Description',
      'category' => 'Category',
      'address' => 'Address',
      'edit_title' => 'Edit Request',
      'add_title' => 'Add Request',
      'tenant' => 'Tenant',
      'due_date' => 'Due date',
      'closed_date' => 'Closed date',
      'service' => 'Service',
      'created_by' => 'Created by',
      'is_public' => 'Public',
      'comments' => 'Comments',
      'assigned_to' => 'Assigned to',
      'assign_providers' => 'Assign providers',
      'assign_managers' => 'Assign managers',
      'unassign' => 'Unassign',
      'notify' => 'Notify',
      'public_legend' => 'Set this option to make the request visible to all tenant neighbours',
      'conversation' => 'Conversation',
      'conversation_created' => "Conversation comment created",
      'internal_notice_saved' => "Internal Notice saved",
      'internal_notice_updated' => "Internal Notice updated",
      'internal_notice_deleted' => "Internal Notice deleted",
      'open_conversation' => 'Open',
      'other_recipients' => 'Other recipients',
      'recipients' => 'Recipients',
      'assign' => 'Assign',
      'images' => 'Images',
      'no_images_message' => 'No files uploaded',
      'request_details' => 'Request details',
      'internal_notices' => 'Internal notices',
      'status_changed' => 'Status changed',
      'priority_changed' => 'Priority changed',
      'media' => 
      [
        'added' => 'Document added',
        'removed' => 'Document removed',
        'deleted' => 'Document deleted',
        'delete' => 'Delete',
      ],
      'priority' => 
      [
        'label' => 'Priority',
        'urgent' => 'Urgent',
        'low' => 'Low',
        'normal' => 'Normal',
      ],
      'defect_location' => 
      [
        'label' => 'Defect location',
        'apartment' => 'Apartment',
        'building' => 'Building',
        'environment' => 'Environment',
      ],
      'qualification' => 
      [
        'label' => 'Qualification',
        'none' => 'None',
        'optical' => 'Optical',
        'sia' => 'Sia',
        '2_year_warranty' => '2 Year Warranty',
        'cost_consequences' => 'Cost consequences',
      ],
      'status' => 
      [
        'label' => 'Status',
        'received' => 'Received',
        'in_processing' => 'In processing',
        'assigned' => 'Assigned',
        'done' => 'Done',
        'reactivated' => 'Reactivated',
        'archived' => 'Archived',
      ],
      'category_options' => 
      [
          'disturbance' => 'Disturbance',
          'defect' => 'Defect',
          'order_documents' => 'Order documents',
          'order_a_payment_slip' => 'Order a payment slip',
          'questions_about_the_tenancy' => 'Questions about the tenancy',
          'other' => 'Other',
          'environment' => 'Environment',
          'house' => 'House',
          'apartment' => 'Apartment',
      ],
      'placeholders' => 
      [
        'category' => 'Select category',
        'priority' => 'Select priority',
        'defect_location' => 'Select defect location',
        'qualification' => 'Select qualification',
        'status' => 'Select status',
        'due_date' => 'Pick due date',
        'tenant' => 'Search for a tenant',
        'service' => 'Search for a service',
        'propertyManagers' => 'Search for managers',
        'search' => 'Search',
        'visibility' => 'Select visibility',
      ],
      'confirmChange' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'confirmUnassign' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'mail' => 
      [
        'body' => 'Body',
        'subject' => 'Subject',
        'to' => 'To',
        'title' => 'Notify service',
        'notify' => 'Send Email',
        'bodyPlaceholder' => 'Please write your message here',
        'provider' => 'Provider',
        'manager' => 'Manager',
        'cancel' => 'Cancel',
        'send' => 'Send',
        'cc' => 'CC',
        'bcc' => 'BCC',
        'success' => 'Notification mail sent successfully',
        'validation' => 
        [
          'required' => 'This field is required',
          'email' => 'This field should be a valid email',
        ],
        'fail_cc' => 'CC/BCC/TO fields must be valid emails',
      ],
      'attached' => 
      [
        'services' => 'Provider attached successfully',
        'managers' => 'Manager attached successfully',
        'user' => 'User assigned successfully',
      ],
      'detached' => 
      [
        'service' => 'Provider detached successfully',
        'manager' => 'Manager detached successfully',
        'user' => 'User unassigned successfully',
      ],
      'userType' => 
      [
        'label' => 'Type',
        'provider' => 'Service',
        'user' => 'Manager',
      ],
      'visibility' => 
      [
        'label' => 'Visibility',
        'tenant' => 'Private',
        'district' => 'District',
        'building' => 'Building',
      ],
      'errors' => [
        'not_found' => 'Service Request not found',
        'not_allowed_change_status' => 'You are not allowed to change status.',
        'provider_not_found' => 'Service Provider not found',
        'user_not_found' => 'User not found',
        'conversation_not_found' => "Conversation not found",
        'statistics_error' => "Request statistics error: ",
        'internal_notice_not_found' => "Internal Notice not found",
      ],
      'requestID' => 'Request ID',
      'requestCategory' => 'Request Category',
      'actions' => 'Actions',
    ],
    'requestCategory' => 
    [
      'title' => 'Request categories',
      'add' => 'Add category',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'name' => 'Name',
      'cancel' => 'Cancel',
      'required' => 'This field is required',
      'parent' => 'Parent category',
      'errors' => [
        'not_found' => "Service Request Category not found",
        'parent_not_found' => "Parent Service Request Category not found",
        'multiple_level_not_found' => "Multiple level nested categories are not allowed",
        'used_by_request' => "Service Request Category it is used by a Service Request"
      ]
    ],
    'propertyManager' => 
    [
      'title' => 'Property managers',
      'add' => 'Add Property Manager',
      'save' => 'Save',
      'saved' => 'Property manager saved',
      'deleted' => 'Property manager deleted',
      'edit' => 'Edit',
      'edit_title' => 'Edit Property Manager',
      'delete' => 'Delete',
      'firstName' => 'First name',
      'lastName' => 'Last name',
      'name' => 'Name',
      'profession' => 'Profession',
      'slogan' => 'Slogan',
      'linkedin_url' => 'Linkedin URL',
      'xing_url' => 'Xing URL',
      'email' => 'Email',
      'password' => 'Password',
      'confirm_password' => 'Confirm password',
      'phone' => 'Phone',
      'building_card' => 'Assign buildings',
      'details_card' => 'Details',
      'no_buildings' => 'There are no buildings assigned',
      'add_buildings' => 'Add buildings',
      'buildings_search' => 'Search for buildings',
      'districts' => 'Districts',
      'requests' => 'Requests',
      'assign' => 'Assign',
      'unassign' => 'Unassign',
      'delete_with_reassign_modal' => 
      [
        'title' => 'Delete & reassign buildings',
        'description' => 'The selected property manager is linked to properties. You can assign the properties to another person. To do this, select a property manager from the list.',
        'search_title' => 'Search Property Manager',
      ],
      'delete_without_reassign' => 'Delete',
      'profile_card' => 'User Profile',
      'social_card' => 'Social Media',
      'titles' => 
      [
        'mr' => 'Mr.',
        'mrs' => 'Mrs.',
      ],
      'assignType' => 'Type',
      'placeholders' => 
      [
        'search' => 'Search',
      ],
      'attached' => 
      [
        'building' => 'Building assigned',
        'district' => 'District assigned',
      ],
      'detached' => 
      [
        'building' => 'Buiding unassigned',
        'district' => 'District unassigned',
      ],
      'buildingAlreadyAssigned' => 'Building is already inside on a district',
      'confirmUnassign' => 
      [
        'title' => 'Are you sure you want to continue?',
        'warning' => 'Warning',
        'confirmBtnText' => 'Ok',
        'cancelBtnText' => 'Cancel',
      ],
      'errors' => [
        'not_found' => "Property Manager not found",
        'create' => "Property Manager create error: ",
        'update' => "Property Manager updated error: ",	
        'district_not_found' => "District not found",
        'building_not_found' => "Building not found",
        'building_already_assign' => "Building already assigned through district",
        'building_assign_deleted_property_manager' => "You cannot assign buildings to an deleted Property Manager",
      ],
    ],
    'product' => 
    [
      'title' => 'Products',
      'add' => 'Add Product',
      'edit_title' => 'Edit Product',
      'edit' => 'Edit',
      'delete_action' => 'Delete',
      'show' => 'Details',
      'details' => 'Product details',
      'delete' => 'Delete product',
      'content' => 'Content',
      'product_title' => 'Title',
      'published_at' => 'Published',
      'publish' => 'Publish',
      'unpublish' => 'Unpublish',
      'likes' => 'Likes',
      'save' => 'Save',
      'saved' => 'Product saved',
      'deleted' => 'Product deleted',
      'comments' => 'Comments',
      'user' => 'User',
      'contact' => 'Contact',
      'price' => 'Price',
      'comment_created' => "Comment successfully created",
      'media' => 
      [
        'deleted' => 'Document/Photo Deleted',
        'uploaded' => 'Document/Photo Uploaded',
      ],
      'errors' => [
        'not_found' => "Product not found",        
      ],
      'type' => 
      [
        'label' => 'Type',
        'sell' => 'Sell',
        'lend' => 'Lend',
        'service' => 'Service',
        'giveaway' => 'Give away',
      ],
      'status' => 
      [
        'label' => 'Status',
        'published' => 'Published',
        'unpublished' => 'Unpublished',
      ],
      'visibility' => 
      [
        'label' => 'Visibility',
        'address' => 'Address',
        'district' => 'District',
        'all' => 'All',
      ],
    ],
    'template' => 
    [
      'name' => 'Name',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'saved' => 'Template saved',
      'deleted' => 'Template deleted',
      'add' => 'Add',
      'title' => 'Templates',
      'subject' => 'Subject',
      'body' => 'Body',
      'category' => 'Category',
      'tags' => 'Tags',
      'placeholders' => 
      [
        'category' => 'Choose category',
      ],
      'errors' => [
        'not_found' => "Template not found",
      ]
    ],
    'cleanify' => 
    [
      'pageTitle' => 'Cleanify request',
      'title' => 'Title',
      'lastName' => 'Last name',
      'firstName' => 'First name',
      'address' => 'Address',
      'city' => 'City',
      'zip' => 'Zip',
      'email' => 'Email',
      'phone' => 'Phone',
      'save' => 'Send request',
      'success' => 'Cleanify request sent successfully',
      'terms_and_conditions' => 'Accept Terms & Conditions',
      'terms_text' => 'Terms text here, long text',
    ],
];