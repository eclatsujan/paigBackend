<?php

namespace App\Repositories\Contracts;


interface SettingRepositoryContract
{
    public function getSettings($params);
    public function saveSettings($settings);

}
