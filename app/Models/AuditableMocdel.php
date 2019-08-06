<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;

class AuditableMocdel extends \Illuminate\Database\Eloquent\Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

}
