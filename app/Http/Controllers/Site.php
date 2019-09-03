<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Site extends Controller
{
    public function Index()
    {
        return view('site/sign');
    }

    public function Sign(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required|unique:users',
            'pwd' => 'required',
            'phone' => 'required',
        ]);

        $users=new Users();
        $users->name=$request['name'];
        $users->call=rand(10000000,99999999);
        $users->pwd=md5($request['pwd']);
        $users->phone=$request['phone'];
        if($users->save()){
            return view('site/login');
        }else{
            echo "error";
        }
    }

    public function Login(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'call' => 'required',
            'pwd' => 'required',
        ]);

        $users=new Users();
        $res=$users->where('call',$request['call'])->where('pwd',md5($request['pwd']))->first();
        if(empty($res)){
            return redirect('site/login');
        }else{
            return view('site/user',['res'=>$res]);
        }
            
    }
}