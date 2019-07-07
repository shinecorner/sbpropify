<?php

use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

class TemplateCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createParentCategories();
        $this->createUserCategories();
        $this->createTenantCategories();
        $this->createPostCategories();
        $this->createProductCategories();
        $this->createRequestCategories();
        $this->createManagerCategories();
        $this->createServiceProviderCategories();
        $this->createCleanifyRequestCategories();
    }

    private function createParentCategories()
    {
        $templates = [
            [
                'parent_id' => null,
                'name' => 'user',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'tenant',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'post',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'product',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'request',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'manager',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'service_provider',
                'description' => '',
            ],
            [
                'parent_id' => null,
                'name' => 'cleanify_request',
                'description' => '',
            ],
        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createUserCategories()
    {
        $templates = [
            [
                'parent_id' => 1,
                'name' => 'new_admin',
                'description' => 'User create admin notification',
                'tag_map' => [
                    'name' => 'user.name',
                    'email' => 'user.email',
                    'phone' => 'user.phone',
                    'title' => 'constant.user.title',

                    'subjectName' => 'subject.name',
                    'subjectEmail' => 'subject.email',
                    'subjectPhone' => 'subject.phone',
                    'subjectTitle' => 'constant.subject.title',
                ],
                'subject' => 'New admin created',
                'body' => <<<HTML
<p>Hello {{name}}</p>
<p>A new admin account was created:</p>
<p>User {{name}}</p>
<p>Email {{email}}</p>
HTML
            ],
            [
                'parent_id' => 1,
                'name' => 'reset_password',
                'description' => 'User reset password email',
                'tag_map' => [
                    'name' => 'user.name',
                    'email' => 'user.email',
                    'phone' => 'user.phone',
                    'title' => 'constant.user.title',
                    'passwordResetUrl' => 'passwordResetUrl',
                ],
                'subject' => 'Password reset request for your account',
                'body' => <<<HTML
<p>Hello {{title}} {{name}}</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p>Reset Password {{passwordResetUrl}}</p><p>If you did not request a password reset, no further action is required.</p>
HTML
            ],
            [
                'parent_id' => 1,
                'name' => 'reset_password_success',
                'description' => 'Password changed successfully',
                'tag_map' => [
                    'name' => 'user.name',
                    'email' => 'user.email',
                    'phone' => 'user.phone',
                    'title' => 'constant.user.title',
                ],
                'subject' => 'Password changed successfully',
                'body' => <<<HTML
<p>You changed your password successfully.</p>
<p>If you did change password, no further action is required.</p>
<p>If you did not change password, protect your account.</p>
HTML
            ],
        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createTenantCategories()
    {
        $templates = [
            [
                'parent_id' => 2,
                'name' => 'tenant_credentials',
                'description' => 'Email sent to tenant, containing the PDF with the credentials and tenancy details.',
                'tag_map' => [
                    'name' => 'user.name',
                    'birthDate' => 'tenant.birthDate',
                    'mobilePhone' => 'tenant.mobile_phone',
                    'privatePhone' => 'tenant.private_phone',
                    'email' => 'tenant.email',
                    'phone' => 'tenant.phone',
                    'title' => 'constant.tenant.title',
                    'tenantCredentials' => 'tenantCredentials',
                ],
                'subject' => 'Password changed successfully',
                'body' => <<<HTML
<p>Hello {{title}} {{name}}</p>
<p>Your account was created.</p>
<p>Here is an pdf with credentials.</p>
HTML
            ],
        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createPostCategories()
    {
        $templates = [
            [
                'parent_id' => 3,
                'name' => 'pinned_post',
                'description' => 'Email sent to tenants when admin publishes a pinned post',
                'tag_map' => [
                    'salutation' => 'user.title',
                    'name' => 'user.name',
                    'title' => 'post.title',
                    'content' => 'post.content',
                    'type' => 'post.type',
                ],
                'subject' => 'New Pined post: {{title}}',
                'body' => <<<HTML
<p>Hello {{salutation}} {{name}},</p>
<p>Title {{title}}.</p>
<p>{{content}}.</p>
HTML
            ],
            [
                'parent_id' => 3,
                'name' => 'new_post',
                'description' => 'Email sent to admins when tenant creates a new post',
                'tag_map' => [
                    'salutation' => 'user.title',
                    'name' => 'user.name',
                    'subjectSalutation' => 'subject.title',
                    'subjectName' => 'subject.name',
                    'content' => 'post.content',
                    'type' => 'post.type',
                ],
                'subject' => 'New Tenant post: {{title}}',
                'body' => <<<HTML
<p>Hello {{salutation}} {{name}},</p>
<p>Tenant {{subjectSalutation}} {{subjectName}} added a new post</p>
<p>{{content}}.</p>
HTML
            ],
        ];
        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createProductCategories()
    {
        $templates = [

        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createRequestCategories()
    {
        $templates = [
            [
                'parent_id' => 5,
                'name' => 'new_request',
                'description' => 'Email sent to property managers when tenant creates a new request.',
                'tag_map' => [
                    'salutation' => 'user.title',
                    'name' => 'user.name',
                    'subjectSalutation' => 'subject.title',
                    'subjectName' => 'subject.name',
                    'title' => 'request.title',
                    'description' => 'request.description',
                    'category' => 'request.category.name',
                    'unit' => 'request.unit.name',
                    'building' => 'request.unit.building.name',
                ],
                'subject' => 'New Tenant request: {{title}}',
                'body' => <<<HTML
<p>Hello {{salutation}} {{name}},</p>
<p>Tenant {{subjectSalutation}} {{subjectName}} created a new request</p>
<p>Unit: {{category}}.</p>
<p>Category: {{category}}.</p>
<p>Title: {{title}}.</p>
<p>{{description}}.</p>
HTML
            ],
            [
                'parent_id' => 5,
                'name' => 'request_assigment',
                'description' => 'Email sent to property assignment, service providers after assignment to a request.',
                'tag_map' => [
                    'salutation' => 'user.title',
                    'name' => 'user.name',
                    'subjectSalutation' => 'subject.title',
                    'subjectName' => 'subject.name',
                    'title' => 'request.title',
                    'description' => 'request.description',
                    'category' => 'request.category.name',
                ],
                'subject' => 'New assignment to request: {{title}}',
                'body' => <<<HTML
<p>Hello {{salutation}} {{name}},</p>
<p>You have been assigned to an new request {{title}</p>
<p>Category: {{category}}.</p>
<p>Title: {{title}}.</p>
<p>{{description}}.</p>
HTML
            ],
        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createManagerCategories()
    {
        $templates = [

        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createServiceProviderCategories()
    {
        $templates = [

        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }

    private function createCleanifyRequestCategories()
    {
        $templates = [
            [
                'parent_id' => 8,
                'name' => 'cleanify_request_email',
                'description' => 'Email sent to Cleanify when the tenant makes a request.',
                'tag_map' => [
                    'salutation' => 'form.title',
                    'firstName' => 'form.first_name',
                    'lastName' => 'form.last_name',
                    'address' => 'form.address',
                    'zip' => 'form.zip',
                    'city' => 'form.city',
                    'email' => 'form.email',
                    'phone' => 'form.phone',
                ],
                'subject' => 'New Cleanify request from: {{salutation}} {{firstName}} {{lastName}}',
                'body' => <<<HTML
<p>New Cleanify request,</p>
<p>Name : {{salutation}} {{firstName}} {{lastName}}.</p>
<p>Phone : {{phone}}.</p>
<p>Email : {{email}}.</p>
<p>Address:</p>
<p>{{address}}, {{city}} {{zip}}.</p>
HTML
            ],
        ];

        foreach ($templates as $template) {
            (new TemplateCategory())->create($template);
        }
    }
}
