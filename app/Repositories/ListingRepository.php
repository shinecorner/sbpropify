<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Models\User;
use App\Notifications\ListingPublished;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

/**
 * Class ListingRepository
 * @package App\Repositories
 * @version March 3, 2019, 3:15 pm UTC
 *
 * @method Listing findWithoutFail($id, $columns = ['*'])
 * @method Listing find($id, $columns = ['*'])
 * @method Listing first($columns = ['*'])
*/
class ListingRepository extends BaseRepository
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
        return Listing::class;
    }

    public function create(array $atts)
    {
        $u = \Auth::user();
        if ($u->tenant()->exists() && !$u->tenant->homeless()) {
            $atts['address_id'] = $u->tenant->building->address_id;
            $atts['quarter_id'] = $u->tenant->building->quarter_id;
        }

        if ($atts['visibility'] != Listing::VisibilityAll &&
            !isset($atts['address_id']) && (!isset($atts['quarter_id']))
        ) {
            throw new \Exception("Missing address or missing quarter for new listing");
        }

        $model = parent::create($atts);

        if (!$atts['needs_approval']) {
            return $this->setStatusExisting($model, Listing::StatusPublished);
        }

        return $model;
    }

    /**
     * @param $listing
     * @param $status
     * @return mixed
     */
    public function setStatusExisting($listing, $status)
    {
        if ($listing->status != $status && $status == Listing::StatusPublished) {
            $listing->published_at = Carbon::now();
            $this->notify($listing);
        }

        $listing->status = $status;
        $listing->save();
        return $listing;
    }

    public function notify(Listing $listing)
    {
        $users = [];
        if ($listing->visibility == Listing::VisibilityAll) {
            $users = User::all();
        }
        if ($listing->visibility == Listing::VisibilityQuarter) {
            $users = User::select('users.*')
                ->join('tenants', 'tenants.user_id', '=', 'users.id')
                ->join('buildings', 'buildings.id', '=', 'tenants.building_id')
                ->where('buildings.quarter_id', $listing->quarter_id)
                ->get();
        }
        if ($listing->visibility == Listing::VisibilityAddress) {
            $users = User::select('users.*')
                ->join('tenants', 'tenants.user_id', '=', 'users.id')
                ->join('buildings', 'buildings.id', '=', 'tenants.building_id')
                ->where('buildings.address_id', $listing->address_id)
                ->get();
        }
        Notification::send($users, new ListingPublished($listing));
    }
}
