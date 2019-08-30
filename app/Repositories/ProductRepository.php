<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductPublished;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @version March 3, 2019, 3:15 pm UTC
 *
 * @method Product findWithoutFail($id, $columns = ['*'])
 * @method Product find($id, $columns = ['*'])
 * @method Product first($columns = ['*'])
*/
class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status',
        'content' => 'like',
        'contact' => 'like',
        'title' => 'like',
    ];

    protected $mimeToExtension = [
        "image/jpeg" =>  "jpg",
        "image/png" =>  "png",
    ];


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    public function create(array $atts)
    {
        $u = \Auth::user();
        if ($u->tenant()->exists() && !$u->tenant->homeless()) {
            $atts['address_id'] = $u->tenant->building->address_id;
            $atts['district_id'] = $u->tenant->building->district_id;
        }

        if ($atts['visibility'] != Product::VisibilityAll &&
            !isset($atts['address_id']) && !isset($atts['district_id'])) {
            throw new \Exception("Missing address or missing district for new product");
        }

        $model = parent::create($atts);

        if (!$atts['needs_approval']) {
            return $this->setStatus($model->id, Product::StatusPublished);
        }

        return $model;
    }

    public function setStatus(int $id, $status)
    {
        $product = $this->find($id);
        if ($product->status != $status && $status == Product::StatusPublished) {
            $product->published_at = Carbon::now();
            $this->notify($product);
        }

        $product->status = $status;
        $product->save();
        return $product;
    }

    public function notify(Product $product)
    {
        $users = [];
        if ($product->visibility == Product::VisibilityAll) {
            $users = User::all();
        }
        if ($product->visibility == Product::VisibilityDistrict) {
            $users = User::select('users.*')
                ->join('tenants', 'tenants.user_id', '=', 'users.id')
                ->join('buildings', 'buildings.id', '=', 'tenants.building_id')
                ->where('buildings.district_id', $product->district_id)
                ->get();
        }
        if ($product->visibility == Product::VisibilityAddress) {
            $users = User::select('users.*')
                ->join('tenants', 'tenants.user_id', '=', 'users.id')
                ->join('buildings', 'buildings.id', '=', 'tenants.building_id')
                ->where('buildings.address_id', $product->address_id)
                ->get();
        }
        Notification::send($users, new ProductPublished($product));
    }
}
