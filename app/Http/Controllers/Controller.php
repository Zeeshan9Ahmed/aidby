<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $stripe_public_key, $stripe_secret_key;

    public function __construct()
    {
        $this->stripe_public_key = 'pk_test_51H0UoCJELxddsoRYqANwUqQLd24vQYATeVTsN7Sm1xnAD68ARNm6bK0vsdCSqisOhSMNCATShUvDmXdzeyW0Cezz00RbGzoMup';
        $this->stripe_secret_key = 'sk_test_51H0UoCJELxddsoRYdF40WwR8HUvA8U5wgUNqQwDCweZT4TnbAuIGINVtVWAItPMcSoMOighLxdZR1Jjl8vdUwldb00EMPAVgIE';
    }
}
