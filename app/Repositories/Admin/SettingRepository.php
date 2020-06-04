<?php


namespace App\Repositories\Admin;


use App\Models\Setting;
use App\Repositories\Contracts\Repository;
use App\Repositories\Contracts\SettingRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class SettingRepository extends BaseRepository implements SettingRepositoryContract
{


    public function saveSettings($settings)
    {
        foreach($settings as $key=>$setting){
            Setting::updateOrCreate(
                ['key'=>$key],
                ['value'=>$setting]
            );
        }
    }

    public function getSettings($params)
    {
        return Setting::whereIn("key",$params)->get()->pluck("value","key")->all();
        // TODO: Implement getSettings() method.
    }
}
