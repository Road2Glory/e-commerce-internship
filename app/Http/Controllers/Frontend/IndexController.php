<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;


class IndexController extends Controller
{
    public function index(){
        return view('frontend.index');
    }

    public function userLogout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function userProfile(){
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile',compact('user'));

    }

    public function userProfileStore(Request $request){

        $data = User::find(Auth::user()->id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;



        if($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
           // unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('YmdHi').'.'.$file->getClientOriginalExtension();

            $file->move(public_path('upload/user_images'),$filename);

            $data['profile_photo_path'] = $filename;

            $data->save();


            $notification = array(
                'message' => 'User Profile Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('dashboard')->with($notification);

        }
    }

    public function userChangePassword(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password',compact('user'));
    }

    public function userPasswordUpdate(Request $request){
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',

        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            // $notification = array(
            //     'message' => 'Admin Profile Updated Successfully',
            //     'alert-type' => 'success'
            // );



            Auth::logout();
            return redirect()->route('admin.logout');
        }else{
            return redirect()->back();
        }
    }
}
