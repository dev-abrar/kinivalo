<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermission extends Controller
{
    public function roleIndex()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(10);
        return view('back-end.user.role_and_permission.indexRole', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            $notification = [
                'error' => 'Something is wrong. Please Fill all the fill carefully',
            ];

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with($notification);
        }
        $role = Role::create(['name' => $request->name]);

        if ($role == true) {
            $notification = [
                'success' => 'Role Created Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Role Not Created !',
            ];
        }

        return redirect()
            ->back()
            ->with($notification);
    }

    public function updateRole(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:roles,name,' . $request->id . ',id',
            ],
            [
                'name.required' => 'Please Enter Role Name!',
            ],
        );

        $role = Role::findOrFail($request->id)->update(['name' => $request->name]);

        if ($role == true) {
            $notification = [
                'success' => 'Role Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Role Not Updated !',
            ];
        }

        return response()->json($notification);
    }

    //permission index
    public function indexPermission()
    {
        //  $permissions = Cache::rememberForever("permissions-data", function () {
        //     return  Permission::with('children')->orderBy('position', 'asc')->get();
        //  });

        $permissions = Permission::with('children')
            ->orderBy('name', 'asc')->where('parent_id', 0)
            ->paginate(10);
        $permission_data = Permission::orderBy('name', 'asc')->get();
        return view('back-end.user.role_and_permission.permission', compact('permissions', 'permission_data'));
    }

    //store permissions
    public function storePermission(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'display_name' => 'required|string|max:255|unique:permissions,display_name',
                'name' => 'required|string|max:255|unique:permissions,name',
            ],
            [
                'display_name.required' => 'Permission Display name is required',
                'name.required' => 'Permission name is required',
            ],
        )->validate();

        $parent_id = $request->parent_id == null ? 0 : $request->parent_id;
        $permission = Permission::create([
            'display_name' => $request->display_name,
            'name' => $request->name,
            'parent_id' => $parent_id,
        ]);

        if ($permission == true) {
            $notification = [
                'success' => 'Permission Created Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Permission Not Created !',
            ];
        }
        Cache::forget('permissions-data');
        return response()->json($notification);
    }

    //update permissions
    public function updatePermission(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'display_name' => 'required|string|max:255|unique:permissions,display_name,' . $request->id,
                'name' => 'required|string|max:255|unique:permissions,name,' . $request->id,
            ],
            [
                'display_name.required' => 'Permission Display name is required',
                'name.required' => 'Permission name is required',
            ],
        )->validate();

        $permission = Permission::findOrFail($request->id)->update([
            'display_name' => $request->display_name,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        if ($permission == true) {
            $notification = [
                'success' => 'Permission Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Permission Not Updated !',
            ];
        }
        Cache::forget('permissions-data');
        return response()->json($notification);
    }

    //sort permissions data
    public function sortPermissionData(Request $request)
    {
        $sortData = Permission::all();
        foreach ($sortData as $sort) {
            foreach ($request->order as $order) {
                if ($order['id'] == $sort->id) {
                    $sort->update(['position' => $order['position']]);
                }
            }
        }
        Cache::forget('permissions-data');
        return response('Update Successfull', 200);
    }

    //give user role
    public function giveUserRole()
    {
        $users = User::orderBy('name', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $roles = Role::orderBy('name', 'asc')
            ->where('name', '!=', 'admin')
            ->get();

        return view('back-end.user.role_and_permission.give_role_user', compact('users', 'roles'));
    }

    //give permission to user
    public function giveUserPermission(Request $request)
    {
        $permissions = Permission::orderBy('id', 'asc')
            ->where('parent_id', 0)
            ->get();
        $roles = Role::orderBy('name', 'asc')
            ->where('name', '!=', 'admin')
            ->get();
        $users = User::orderBy('name', 'asc')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('back-end.user.role_and_permission.give_user_permission', compact('permissions', 'users', 'roles'));
    }

    // update given user role
    public function updateGivenUserRole(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|string|integer',
                'role_id' => 'required|string|integer',
            ],
            [
                'user_id.required' => 'User Is Required',
                'role_id.required' => 'Role Is Required',
            ],
        );

        $user = User::findOrFail($request->user_id);
        DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->delete();

        $role = Role::find($request->role_id);
        $user->assignRole($role);

        if ($user == true) {
            $notification = [
                'success' => 'Given Role Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Opps! There Is A Problem !',
            ];
        }
        if ($request->without_ajax == 1) {
            return redirect()
                ->back()
                ->with($notification);
        } else {
            return response()->json($notification);
        }
    }

    // store user permission

    public function storeUserPermission(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|numeric',
                // 'permission_id' => 'required|array',
            ],
            [
                'user_id.required' => 'User Is Required',
                // 'permission_id.required' => 'Permission Is Required',
            ],
        );

        $user = User::findOrFail($request->user_id);
        $cardContend = session()->get('user_excess_session');
        $collection = collect($cardContend);
        
        if (count($collection) > 0) {
            DB::table('model_has_permissions')
                ->where('model_id', $request->user_id)
                ->delete();

                $permissions_ids = $collection
                ->where('id', $user->id)
                ->pluck('permission_id')
                ->toArray();
            // Give new permissions to the user
            $user->givePermissionTo($permissions_ids);
        
            
        } else {
            DB::table('model_has_permissions')
                ->where('model_id', $request->user_id)
                ->delete();
        }

        if ($user == true) {
            $notification = [
                'success' => 'Given Permission Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Opps! There Is A Problem !',
            ];
        }

        return redirect()
            ->back()
            ->with($notification);
    }

    // public function userGivePermissionCheck(Request $request)
    // {
    //     $rolePermissions = Permission::join("model_has_permissions","model_has_permissions.permission_id","=","permissions.id")
    //         ->where("model_has_permissions.model_id", $request->user_id)
    //         ->pluck('model_has_permissions.permission_id');

    //     return response()->json($rolePermissions);

    // }

    public function userGivePermissionCheck(Request $request)
    {
        $permissions = Permission::orderBy('id', 'asc')->get();
        $permission = [];
        foreach ($permissions as $value) {
            $rolePermissions = Permission::join('model_has_permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
                ->where('model_has_permissions.model_id', $request->user_id)
                ->where('model_has_permissions.permission_id', $value->id)
                ->first();

            $checked = $rolePermissions == null ? false : true;
            $singlePermission = [
                'id' => $value->id,
                'pId' => $value->parent_id,
                'name' => $value->name,
                'open' => true,
                'checked' => $checked,
            ];
            array_push($permission, $singlePermission);
        }

        return response()->json($permission);
    }

    public function userExcessInCard(Request $request)
    {
        session()->forget('user_excess_session');
        $nodes = json_decode($request->nodes);

        if (count($nodes) > 0) {
            foreach ($nodes as $value) {
                
                $userExcessSession = session()->get('user_excess_session', []);
        
                // Push the new array to the existing session data
                $userExcessSession[] = [
                    'id' => $request->user_id,
                    'permission_id' => $value->id,
                ];
        
                // Store the updated array back in the session
                session()->put('user_excess_session', $userExcessSession);
               
            }
        }

        return response()->json('ok');
    }

    public function childPermission($permission_id)
    {
        $data['permission'] = Permission::with('children')->findOrFail($permission_id);
        return view('back-end.user.role_and_permission.child_permission', $data);
    }
}
