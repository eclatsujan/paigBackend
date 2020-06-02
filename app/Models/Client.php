<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    //
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
