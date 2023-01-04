<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    public function index()
    {
        return view('configs.index');
    }

    public function create (Request $request){
        if($request->action === 'action1'){
            Artisan::call('migrate:fresh --seed');
            return redirect()->route('configs');/* ->with('alert', [
                'type' => 'success',
                'messages' => ["successfully"],
            ]); */

            Session::flash('alert', [
                'type' => 'info',
                'messages' => ["Updated successfully"],
            ]);
    
        }
        if($request->action === 'action2'){
            Artisan::call('schedule:run');
            return redirect()->route('configs');
        }
        if($request->action === 'action3') {
            
            return view('auth.login');
        }
    }

}
