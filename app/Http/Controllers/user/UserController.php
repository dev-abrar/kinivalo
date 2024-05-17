<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //user list
    function index(){
        $users=User::orderBy("id", "desc")->paginate(10);
        $roles= Role::orderBy('name', 'asc')->get();
        return view('back-end.user.index', compact('users', 'roles'));
    }

    //user register
    function register(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_type' => 'required|max:255',
            'photo' => 'mimes:jpeg,png,jpg',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Please Enter User Name!',
            'email.required' => 'Please Enter User Email',
            'user_type.required' => 'Please Enter User Type',
            'photo.required' => 'Please Enter User Photo',
            'password.required' => 'Please Enter User Password',
        ]);
        
        $dbUrl = '';
        if ($request->file('photo')) {
            $image = $request->file('photo');
            $imageName = $image->getClientOriginalName();
            Image::make($image)->resize(530, 370)->save('public/uploads/users/' . $imageName);
            $dbUrl = 'public/uploads/users/' . $imageName;
        }

       $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $dbUrl,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->user_type);
        if ($user == true) {
            $notification = ([
                'success' => 'User Registered Successfully',
            ]);
        } else{
            $notification = ([
                'error' => 'Opps! Something is wrong...!',
            ]);
        }

        return redirect()->back()->with($notification);
    }

   //delete user
    function deleteUser($user_id){
        User::findOrFail($user_id)->delete();
        return redirect()->back();
    }

    // update user 
    function updateUser(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .$request->id,
            'user_type' => 'required|max:255',
            'photo' => 'mimes:jpeg,png,jpg',
        ], [
            'name.required' => 'Please Enter User Name!',
            'email.required' => 'Please Enter User Email',
            'user_type.required' => 'Please Enter User Type',
            'photo.required' => 'Please Enter User Photo',
        ]);
        $userData = User::findOrFail($request->id);
        $dbUrl = $userData->photo;
        if ($request->file('photo')) {
            File::delete($userData->oldImage);
            $image = $request->file('photo');
            $imageName = $image->getClientOriginalName();
            Image::make($image)->resize(530, 370)->save('public/uploads/users/' . $imageName);
            $dbUrl = 'public/uploads/users/' . $imageName;
        }
       
        $user = $userData->update([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $dbUrl,
            'user_type' => $request->user_type,
        ]);

        DB::table('model_has_roles')->where('model_id',$request->id)->delete();
        $roleId = $request->user_type;
        $role = Role::find($roleId);
        $userData->assignRole($role);
        if ($user == true) {
            $notification = ([
                'success' => 'User Updated Successfully',
            ]);
        } else{
            $notification = ([
                'error' => 'Opps! Something is wrong...!',
            ]);
        }

        return redirect()->back()->with($notification);
    }
}
