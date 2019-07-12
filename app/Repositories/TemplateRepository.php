<?php

namespace App\Repositories;

use App\Models\CleanifyRequest;
use App\Models\Comment;
use App\Models\PasswordReset;
use App\Models\Post;
use App\Models\Product;
use App\Models\RealEstate;
use App\Models\ServiceRequest;
use App\Models\Template;
use App\Models\Tenant;
use App\Models\User;
use Config;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TemplateRepository
 * @package App\Repositories
 */
class TemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'description' => 'like',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Template::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attributes);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    /**
     * @param $templateName
     * @return mixed
     */
    public function getByCategoryName($templateName)
    {
        $template = (new Template)->with('category')->whereHas('category', function ($q) use ($templateName) {
            $q->where('name', $templateName);
        })->first();

        return $template;
    }

    /**
     * @param User $user
     * @param User $subject
     * @return array
     */
    public function getUserNewAdminTemplate(User $user, User $subject): array
    {
        $template = $this->getByCategoryName('new_admin');

        $context = [
            'user' => $user,
            'subject' => $subject,
        ];
        $tags = $this->getTags($template->category->tag_map, $context);
        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param array $tagMap
     * @param array $context
     * @return array
     */
    public function getTags(array $tagMap, array $context): array
    {
        $user = $context['user'] ?? null;
        $pwReset = $context['pwReset'] ?? null;
        $subject = $context['subject'] ?? null;
        $tenant = $context['tenant'] ?? null;
        $post = $context['post'] ?? null;
        $product = $context['product'] ?? null;

        $request = $context['request'] ?? null;
        $originalRequest = $context['originalRequest'] ?? null;

        $comment = $context['comment'] ?? null;
        $form = $context['form'] ?? null;

        $tags = [];
        foreach ($tagMap as $tag => $val) {
            $valMap = explode('.', $val);

            if (count($valMap) == 4) {
                if ($valMap[0] == 'constant') {
                    $val = self::getContextValue(${$valMap[1]}->{$valMap[2]}, $valMap[3]);
                    $val = __('common.' . $val);
                    $tags[$tag] = $val;
                    continue;
                }

                $val = self::getContextValue(${$valMap[0]}->{$valMap[1]}->{$valMap[2]}, $valMap[3]);

                $tags[$tag] = $val;
                continue;
            }

            if (count($valMap) == 3) {
                if ($valMap[0] == 'constant') {
                    $val = self::getContextValue(${$valMap[1]}, $valMap[2]);
                    $val = __('common.' . $val);
                    $tags[$tag] = $val;
                    continue;
                }

                $val = self::getContextValue(${$valMap[0]}->{$valMap[1]}, $valMap[2]);

                $tags[$tag] = $val;
                continue;
            }

            if (count($valMap) == 2) {
                $val = self::getContextValue(${$valMap[0]}, $valMap[1]);
                $tags[$tag] = $val;
                continue;
            }

            if ($tag == 'autologinUrl' && $user) {
                $linkText = __('See post');
                $val = $this->button($user->autologinUrl, $linkText);
            }

            if ($tag == 'passwordResetUrl' && $pwReset) {
                $linkHref = url(sprintf('/reset-password?email=%s&token=%s', $user->email, $pwReset->token));
                $linkText = __('Reset password');
                $val = $this->button($linkHref, $linkText);
            }

            if ($tag == 'tenantCredentials' && $tenant) {
                $linkHref = env('APP_URL') . \Storage::url($tenant->pdfXFileName());
                $linkText = __('Download Credentials');
                $val = $this->button($linkHref, $linkText);
            }

            $tags[$tag] = $val;
        }

        return $tags;
    }

    /**
     * @param $url
     * @param $text
     * @return string
     */
    private function button($url, $text)
    {
        $linkClass = 'button button-primary';
        $linkStyle = 'font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3490DC; border-top: 10px solid #3490DC; border-right: 18px solid #3490DC; border-bottom: 10px solid #3490DC; border-left: 18px solid #3490DC;';

        return sprintf('<a class="%s" style="%s" href="%s">%s</a>', $linkClass, $linkStyle, $url, $text);
    }

    /**
     * @param $context
     * @param $field
     * @return string
     */
    private static function getContextValue($context, $field)
    {
        if (!$context) {
            return '';
        }

        if (is_array($context)) {
            return $context[$field] ?? '';
        }

        return $context->$field ?? '';
    }

    /**
     * @param Template $template
     * @param $tagMap
     * @param $lang
     * @return array
     */
    public function getParsedTemplate($template, $tagMap, $lang = ''): array
    {
        if (!$template) {
            return [
                'subject' => '',
                'body' => '',
            ];
        }

        $languages = Config::get('app.locales');
        $userLanguage = in_array($lang, array_keys($languages)) ? $lang : Config::get('app.locale');

        $subject = $template->subject;
        $body = $template->body;

        $translations = $template->translations()->where('language', $userLanguage)->get();
        foreach ($translations as $translation) {
            if ($translation->name == "subject") {
                $subject = $translation->value;
            }

            if ($translation->name == "body") {
                $body = $translation->value;
            }
        }

        foreach ($tagMap as $tag => $value) {
            $subject = str_replace('{{' . $tag . '}}', $value, $subject);
        }

        foreach ($tagMap as $tag => $value) {
            $body = str_replace('{{' . $tag . '}}', $value, $body);
        }

        $rl = (new RealEstate())->first();

        return [
            'subject' => $subject,
            'body' => $body,
            'settings' => $rl,
        ];
    }

    /**
     * @param User $user
     * @param PasswordReset|null $pwReset
     * @return array
     */
    public function getUserResetPasswordTemplate(User $user, PasswordReset $pwReset): array
    {
        $template = $this->getByCategoryName('reset_password');

        $context = [
            'user' => $user,
            'pwReset' => $pwReset,
        ];
        $tags = $this->getTags($template->category->tag_map, $context);
        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserResetPasswordSuccessTemplate(User $user): array
    {
        $template = $this->getByCategoryName('reset_password_success');

        $context = [
            'user' => $user,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);
        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param Post $post
     * @param User $user
     * @return array
     */
    public function getNewPostParsedTemplate(Post $post, User $user): array
    {
        $template = $this->getByCategoryName('new_post');

        $context = [
            'user' => $user,
            'post' => $post,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);
        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param Tenant $tenant
     * @return array
     */
    public function getTenantCredentialsParsedTemplate(Tenant $tenant): array
    {
        $template = $this->getByCategoryName('tenant_credentials');

        $context = [
            'tenant' => $tenant,
            'user' => $tenant->user,
        ];
        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $tenant->user->settings->language);
    }

    /**
     * @param Post $post
     * @param User $user
     * @return array
     */
    public function getPinnedPostParsedTemplate(Post $post, User $user): array
    {
        $template = $this->getByCategoryName('pinned_post');

        $context = [
            'user' => $user,
            'post' => $post,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $user->settings->language);
    }

    /**
     * @param Post $post
     * @param User $user
     * @param Comment $comment
     * @return array
     */
    public function getPostCommentedParsedTemplate(Post $post, User $user, Comment $comment): array
    {
        $template = $this->getByCategoryName('post_commented');

        $context = [
            'user' => $user,
            'post' => $post,
            'comment' => $comment,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $post->user->settings->language);
    }

    /**
     * @param Post $post
     * @param User $user
     * @return array
     */
    public function getPostLikedParsedTemplate(Post $post, User $user): array
    {
        $template = $this->getByCategoryName('post_liked');

        $context = [
            'user' => $user,
            'post' => $post,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $post->user->settings->language);
    }

    /**
     * @param Product $product
     * @param User $user
     * @return array
     */
    public function getProductLikedParsedTemplate(Product $product, User $user): array
    {
        $template = $this->getByCategoryName('product_liked');

        $context = [
            'user' => $user,
            'product' => $product,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $product->user->settings->language);
    }

    /**
     * @param Product $product
     * @param User $user
     * @param Comment $comment
     * @return array
     */
    public function getProductCommentedParsedTemplate(Product $product, User $user, Comment $comment): array
    {
        $template = $this->getByCategoryName('product_commented');

        $context = [
            'user' => $user,
            'product' => $product,
            'comment' => $comment,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags, $product->user->settings->language);
    }

    /**
     * @param ServiceRequest $request
     * @param User $user
     * @param User $subject
     * @return array
     */
    public function getNewRequestParsedTemplate(ServiceRequest $request, User $user, User $subject): array
    {
        $template = $this->getByCategoryName('new_request');

        $context = [
            'user' => $user,
            'subject' => $subject,
            'request' => $request,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param CleanifyRequest $creq
     * @return array
     */
    public function getCleanifyParsedTemplate(CleanifyRequest $creq): array
    {
        $template = $this->getByCategoryName('cleanify_request_email');

        $context = [
            'form' => $creq->form
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        return $this->getParsedTemplate($template, $tags);
    }

    /**
     * @param $id
     * @param ServiceRequest $request
     * @param User $user
     * @return string
     */
    public function getCommunicationTemplate($id, ServiceRequest $request, User $user): string
    {
        $template = $this->with(['category'])->find($id);

        $context = [
            'user' => $user,
            'request' => $request,
        ];

        $tags = $this->getTags($template->category->tag_map, $context);

        $response = $this->getParsedTemplate($template, $tags);

        return $response['subject'];
    }
}
