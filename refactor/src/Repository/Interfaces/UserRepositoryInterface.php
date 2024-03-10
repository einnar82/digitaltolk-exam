<?php

namespace DTApi\Repository\Interfaces;

interface UserRepositoryInterface
{
    public function createOrUpdate($id = null, $request);
}
