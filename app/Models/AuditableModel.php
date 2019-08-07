<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;

class AuditableModel extends \Illuminate\Database\Eloquent\Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

}
