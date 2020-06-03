<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SettingRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    private $setting_repo;
    public function __construct(SettingRepositoryContract $setting_repo)
    {
        $this->setting_repo=$setting_repo;
    }

    public function view(){
        $settings=$this->setting_repo->getSettings([
            'email',
            'cc_email',
            'bcc_email'
        ]);
        return view("dashboard.settings.view")->with(compact('settings'));
    }

    public function save(Request $request){
        try{
            $settings=[];
            $settings["email"]=!is_null($request->get("email"))?$request->get("email"):"";
            $settings["cc_email"]=!is_null($request->get("cc_email"))?$request->get("cc_email"):"";
            $settings["bcc_email"]=!is_null($request->get("bcc_email"))?$request->get("bcc_email"):"";
            $this->setting_repo->saveSettings($settings);
            Session::flash('message', 'Sucessfully Saved');
            return redirect()->back();
        }
        catch(\Exception $e){
            Session::flash('message', 'Sucessfully failed');
            return redirect()->back()->with("error",$e->getMessage());
        }
    }


}
