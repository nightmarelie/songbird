<?php

namespace AppBundle;

# src/AppBundle/User.php
use Symfony\Component\HttpKernel\Bundle\Bundle;

class User extends Bundle
{
    // use a child bundle
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}