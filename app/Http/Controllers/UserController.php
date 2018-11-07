<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    
    
    public function allUsers()
    {
        $allUsers = User::select('id','name','status',
                          'premium_member','featured_member','updated_at')->get();
        
        return view('User.index',compact('allUsers'));
    }
    
    public function userDetails($id)
    {
        $user = User::where('id', $id)->first();
        
        return view('User.user-detail',compact('user'));
    }
    
    public function userDelete($id, Request $request)
    {
         User::where('id',$id)->update(['status' => 0]);
         
       return redirect()
            ->route('users.all')
            ->with([
                'message'    => 'User Deleted Successfully!',
                'alert-type' => 'success',
            ]);
        
    }
}
