<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Menu;

use App\User;


class RolesController extends AdminController
{
    //

    public function index(){
        $permissions = config('roles.models.permission')::all();
        $roles = config('roles.models.role')::all();
        $users = User::all();
        return view('admin.role', compact('permissions', 'roles', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($path)
    {
        return view('admin.article-update', compact('path'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make($path, Request $request)
    {

        $data = $request->only([
            'name', 'path', 'text'
        ]);
        
        $page = Page::where('path', '=' , $path)->where('status', '!=' , 4)->first();
        
        $data['page_id'] = $page->id;
        $data['status'] = 4;

        $article = Page::create($data);
        $page->users()->attach(\Auth::user()->id);

        return redirect()->route('admin.pages.index', $page->path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Page::findOrFail($id);

        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = config('roles.models.role')::all();
        $user->role = 0;
        $mRoles = [\Lang::get('messages.no_role')];
        foreach ($roles as $role) {
            $mRoles[$role->id] = $role->name;
            if ($user->hasRole(strtolower($role->name))){
                $user->role = $role->id;
            }
        }
        return view('admin.user', compact('user', 'mRoles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->detachAllRoles();
        $data = $request->only([
            'role'
        ]);
        if($data['role']) {
            $user->attachRole($data['role']);
        }

        return redirect()->route('admin.roles.index');
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'roles'
        ]);
        foreach ($request->roles as $roleKey => $permissions) {
            $role = config('roles.models.role')::find($roleKey);
            $role->detachAllPermissions();
            foreach ($permissions as $permissionKey => $trigger) {
                $permission = config('roles.models.permission')::find($permissionKey);
                $role->attachPermission($permission);
                
            }
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function priority(Request $request, $path)
    {
        
        $data = $request->only([
            'ids'
        ]);
        $articles = Page::findOrFail($data['ids']);
        
        foreach ($articles as $article) {
            foreach ($data['ids'] as $key => $value) {
                if($article->id == $value){
                    $article->priority = $key;
                    $article->update();
                    unset($data[$key]);
                    break;
                }
            }
        }
        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $uesr = User::findOrFail($id);
        $uesr->delete();

        return redirect()->route('admin.roles.index');
    }
}
