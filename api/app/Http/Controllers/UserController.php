<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Session;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
        if(strlen($request->password) < 6){
            return [500, 'email ou senha invalido'];
        }

        if(!str_contains($request->email, '@') || !str_contains($request->email, '.com')){
            return [500, 'email ou senha invalido'];
        }

        $result = DB::table('users')->where(['email' => $request->email, 'password' => $request->password])->first();

        if (empty($result)) {
            return [500, 'usuario não encontrado'];
        }

        if(!$result->online){
            DB::table('users')->where('email', $result->email)->update(['online'=> true]);
            return [200, 'usuario logado'];
        }

        return [200, 'usuario já logado'];
    }
}
