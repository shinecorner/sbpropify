<?php
declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    var $user;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$this->user) {
            $this->user = (new User())->first();
        }
    }
}
