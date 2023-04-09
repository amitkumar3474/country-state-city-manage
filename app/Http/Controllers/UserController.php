<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        return view('user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('user_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all();
        return view('user.create', compact('roles'));
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
            'name'             => 'required',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:5',
            'confirm_password' => 'required|same:password',
            'roles'            => 'required'
        ]);
        $userData = $request->all();
        // echo "<pre>";
        // print_r($userData);
        // if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
        //     die("Image avaialbe");
        // }
        // die;
        $usrData = [
            'name'     => $userData['name'],
            'email'    => $userData['email'],
            'password' => Hash::make($userData['password'])
        ];

        $user = User::create($usrData);
        $user->syncRoles($userData['roles']);
        
        if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        if($request->hasFile('banner_image') && $request->file('banner_image')->isValid()){
            $user->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
        }

        return redirect()->route('user.index')->with('success', "User created successfully...");
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
        $roles = Role::all();
        $users = User::where('id', $id)->first();
        return view('user.edit', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $request->validate([
            'name'  => 'required',
            'email' => 'required|unique:users,email,'. $user->id
        ]);
        $userData = $request->all();
        $updateData = $request->only('name', 'email', 'password');
        if($updateData['password']){
            $updateData['password'] = Hash::make($updateData['password']);
        }else{
            unset($updateData['password']);
        }
        User::where('id', $user->id)->update($updateData);
        if(isset($userData['roles'])){
            $user->syncRoles($userData['roles']);
        }else{
            //
        }
        if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }else{
            // $user->clearMediaCollection('profile_image');
        }
        if($request->hasFile('banner_image') && $request->file('banner_image')->isValid()){
            $user->clearMediaCollection('banner_image');
            $user->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
        }else{
            // $user->clearMediaCollection('banner_image');
        }
        return redirect()->route('user.index')->with('success', "Record Updated successfully....");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('user.index')->withSuccess('Record deleted successfully....');
    }
    
     /**
     * Logout the specified resource Admin panel storage.
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success', "Logout successfully....");
    }

    /**
     * Display a registration form of the resource.
     */
    Public function registration()
    {
        return view('registration');
    }
    
    /**
     * Store a newly registerpost resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:5',
            'confirm_password' => 'required|same:password'
        ]);
        $userData = $request->all();

        $user = [
            'name'     => $userData['name'],
            'email'    => $userData['email'],
            'password' => Hash::make($userData['password'])
        ];

        User::create($user);
        return redirect()->route('login')->with('success', "User created successfully...");
    }
     
    /**
     *Display a Dashboard of the resource
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);
        $userData = $request->only('email', 'password');

        if(Auth::attempt($userData)){
            return redirect()->route('dashboard')->with('success', "Logged in successfully....");
        }else{
            return redirect()->route('login')->with('error', "Invalid Credentials....");
        }
    }

    /**
     *Display a Loginpage of the resource
     */
    public function login()
    {
        return view('login');
    }

}
