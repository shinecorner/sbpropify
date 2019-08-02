<?php

namespace App\Traits;

use Hashids\Hashids;

trait HashId
{
    /**
     * @param null $id
     * @return bool|string
     */
    public function hashId($id = null)
    {
        $id = $id ?? $this->getKey();
        $hashid = new Hashids('', 25);
        return substr($hashid->encode($id),0, 8);
    }

    /**
     * @param null $id
     * @return bool|string
     */
    public function shortHashId($id = null)
    {
        $id = $id ?? $this->getKey();
        $hashId = $this->hashId($id);
        return substr($hashId,0, 8);
    }
}
