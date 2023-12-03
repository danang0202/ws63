<?php

namespace App\Controllers;

use App\Models\VersionModel;

class LatestVersion extends BaseController
{
    public function index(string $riset)
    {
        $model = new VersionModel();
        return $model->getLatestVersion($riset);
    }
}
