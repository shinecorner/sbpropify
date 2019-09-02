<?php

namespace App\Repositories;

use App\Models\CleanifyRequest;
use App\Mails\CleanifyNotification;

/**
 * Class CleanifyRequestRepository
 * @package App\Repositories
 * @version February 11, 2019, 6:22 pm UTC
 *
 * @method CleanifyRequest findWithoutFail($id, $columns = ['*'])
 * @method CleanifyRequest find($id, $columns = ['*'])
 * @method CleanifyRequest first($columns = ['*'])
*/
class CleanifyRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CleanifyRequest::class;
    }

    public function notify(CleanifyRequest $creq, $receiver)
    {
        $tRepo = (new TemplateRepository($this->app));

        $message = $tRepo->getCleanifyParsedTemplate($creq);
        \Mail::to($receiver)
            ->queue(new CleanifyNotification($creq, $message['subject'], $message['body']));
    }
}

