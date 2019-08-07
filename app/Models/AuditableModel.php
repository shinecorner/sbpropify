<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;

class AuditableModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

}
