<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('role_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' =>'required'
        ]);
        $roleData = $request->all();
        // echo "<pre>";
        // print_r($roleData['permissions']);
        // die;
        $data = [
            'name' => $roleData['name'],
        ];
        $role = Role::create($data);
        $role->syncPermissions($roleData['permissions']);

        return redirect()->route('roles.index')->with('success', "Role created successfully...");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::where('id', $id)->first();
        return view('role.edit', compact('role', 'permissions'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // echo "<pre>";
        // print_r($role->toArray());
        // die;
        $request->validate([
            'name' => 'required'
        ]);
        $roleData = $request->all();
        $rolesdata = $request->only('name');
        Role::where('id', $role->id)->update($rolesdata); 
        // echo "<pre>";
        // print_r($role);
        // die;
        $role->syncPermissions($roleData['permissions']);

        // $role->update($request->only('name'));
        // $role->syncPermissions($request->get('permissions'));
        return redirect()->route('roles.index')->with('success', "Record Updated successfully....");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datadelete = Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', "Record Delete successfully....");
    }
}
