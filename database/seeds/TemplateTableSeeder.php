<?php

use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

/**
 * Class TemplateTableSeeder
 */
class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templateCategories = TemplateCategory::where('parent_id', '>', 0)->with('parentCategory')->get();

        foreach ($templateCategories as $key => $templateCategory) {
            $parentCategory = $templateCategory->parentCategory;
            $template = new Template();
            $template->category_id = $templateCategory->id;
            $template->name = sprintf('%s - %s', ucfirst($parentCategory->name), $templateCategory->name);
            $template->subject = $templateCategory->subject;
            $template->body = $templateCategory->body;

            $template->default = true;
            $template->save();
        }
    }
}
