<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortlist = [
            [
                "displayname" => "Name (A -> Z)",
                "sortfield" => "name",
                "sortorder" => "asc"
            ],
            [
                "displayname" => "Name (Z -> A)",
                "sortfield" => "name",
                "sortorder" => "desc"
            ],
            [
                "displayname" => "Email (A -> Z)",
                "sortfield" => "email",
                "sortorder" => "asc"
            ],
            [
                "displayname" => "Email (Z -> A)",
                "sortfield" => "email",
                "sortorder" => "desc"
            ],
            [
                "displayname" => "Not Active",
                "sortfield" => "active",
                "sortorder" => "asc"
            ],
            [
                "displayname" => "Admin",
                "sortfield" => "admin",
                "sortorder" => "desc"
            ],
            ];

        $user_name = '%' . $request->input('user_name') . '%';
        $sortfield =$sortlist[$request->input('user_filter')]['sortfield'] ?? 'name';
        $sortorder =$sortlist[$request->input('user_filter')]['sortorder'] ?? 'asc';

        $users = User::orderBy($sortfield, $sortorder)
        ->where(function ($query) use ($user_name){
            $query->where('name', 'like', $user_name);
        })
        ->orWhere(function ($query) use ($user_name){
            $query->where('email', 'like', $user_name);
        }) 
        ->paginate(10)
        ->appends(['name' => $request->input('name')]);
        
        $result = compact('users','sortlist');
        \Json::dump($result);
        $request->flash();
        return view('admin.users.index',$result);
    }

    /**
     * Redirect to admin/users
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact("user");
        \Json::dump($result);
        return view("admin.users.edit", $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required|min:1|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email' . $user->emails
            
        ]);
        //check checkboxes
        $user->admin = $request->admin ?? '0';
        $user->active = $request->active ?? '0';

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        session()->flash('success', 'The user has been updated');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->name === "Wout Sips"){
            session()->flash("warning", "You cannot delete your own profile.");
            return redirect("admin/users");
        }
        
        $user->delete();
       session()->flash('succes', "The user <b>$user</b> has been deleted");
       return redirect('admin/users');
    }
}
