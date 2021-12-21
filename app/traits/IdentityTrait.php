<?php

namespace IdentityTrait;

trait IdentityTrait
{
    public function generateId()
    {
        return uniqid();
    }
}
