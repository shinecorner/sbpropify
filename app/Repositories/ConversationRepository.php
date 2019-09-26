<?php

namespace App\Repositories;

use App\Models\Conversation;

/**
 * Class ConversationRepository
 * @package App\Repositories
 * @version February 11, 2019, 6:22 pm UTC
 *
 * @method Conversation findWithoutFail($id, $columns = ['*'])
 * @method Conversation find($id, $columns = ['*'])
 * @method Conversation first($columns = ['*'])
*/
class ConversationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Conversation::class;
    }
}
