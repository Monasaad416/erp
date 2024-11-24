<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(15);
        return view('admin.pages.roles.index',compact('roles'));
    }


    public function store(RoleStoreRequest $request)
    {
        //return dd($request->all());

        $role = Role::create(['name' => $request->input('name')]);
     
        $role->syncPermissions($request->permissions);

        Alert::success(trans('admin.role_created_successfully'));
        return redirect()->route('roles');
    }


    public function show(string $id)
    {
        //
    }



    public function update(RoleUpdateRequest $request)
    {

        $role = Role::find($request->role_id);
        
        //return dd($request->all());


        // $role->name = $request->input('name');

        // $role->save();

       //dd($request->input('permissions'));
        $role->syncPermissions($request->permissions);
        
         Alert::success(trans('admin.role_updated_successfully'));
        return redirect()->route('roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();
        $users_roles = User::pluck('roles_name','roles_name')->toArray();

        if(in_array($role->name , $users_roles)) {
            Alert::error('عفوا لايمكن حذف  المهة لوجود بيانات بجدول الموظفين مرتبطة بها');
        }
        else {
            $role->delete();
            Alert::success(trans('admin.role_deleted_successfully'));
        }

        return redirect()->route('roles');
    }
}
