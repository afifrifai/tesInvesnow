<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Komda;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoles();
        // dd($komda);
        $data = User::query();
        $data->select('users.id', 'users.name', 'users.email', DB::raw('GROUP_CONCAT(ro.display_name SEPARATOR ", ") as "role"'), 'ko.name as komda');
        $data->leftJoin('role_user as ru', 'ru.user_id', '=', 'users.id');
        $data->leftJoin('roles as ro', 'ro.id', '=', 'ru.role_id');
        $data->leftJoin('komdas as ko', 'ko.id', '=', 'users.komda_id');

        // dd($komda);
        if(!in_array('superadmin', $roles)){
            $komda = $user->komda->id;
            if($komda==''){
                $komda='0';
            }
            if (in_array('komda', $roles)){
                $data->where('users.komda_id', '=', $komda);
                $data->whereNotIn('ro.name', array('superadmin'));
            }elseif(in_array('pengurus', $roles)){
                $data->where('users.komda_id', '=', $komda);
                $data->whereNotIn('ro.name', array('superadmin','komda'));
            }elseif(in_array('anggota', $roles)){
                $data->where('users.komda_id', '=', $komda);
                $data->whereNotIn('ro.name', array('superadmin','komda','pengurus'));
            }
        }
        
        $data->groupby('users.id');
        // dd($data->get());
        // dd($user->getRoles());
        return view('user.user',[
            'user' => $data->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $roles = $user->getRoles();
        $role = '';
        $komda = array($user->komda);
        if (in_array('superadmin', $roles)){
            $role = Role::all();
            $komda = Komda::all();
        }elseif(in_array('komda', $roles)){
            $role = Role::whereNotIn('name', array('superadmin','komda'))->get();
        }elseif(in_array('pengurus', $roles)){
            $role = Role::whereNotIn('name', array('superadmin','komda','pengurus'))->get();
        }

        return view ('user.create', [
            'role' => $role,
            'komda' => $komda
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name" => "required",
            "email" => "required|email:dns|unique:users",
            "role" => "required",
            "password" => "required|min:8",
            "komda" => "required"
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->komda_id = $request->komda;
        $user->save();
        
        $id = $user->id;
        foreach($request->role as $role){
            DB::table('role_user')->insert([
                'role_id' => $role,
                'user_id' => $id,
                'user_type' => 'App\Models\User'
            ]);
        }

        return redirect()->route('user')->with('success', 'Berhasil menambahkan user');
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
    public function edit(User $user)
    {
        $auth = Auth::user();
        $roles = $auth->getRoles();
        $role = '';
        $komda = array($auth->komda);
        if (in_array('superadmin', $roles)){
            $role = Role::all();
            $komda = Komda::all();
        }elseif(in_array('komda', $roles)){
            $role = Role::whereNotIn('name', array('superadmin','komda'))->get();
        }elseif(in_array('pengurus', $roles)){
            $role = Role::whereNotIn('name', array('superadmin','komda','pengurus'))->get();
        }

        // $role_user = DB::table('role_user')->select(DB::raw('GROUP_CONCAT(role_id SEPARATOR ", ") as "role"'))->where('user_id', $user->id)->first();
        $role_user = DB::table('role_user as ru')
        ->leftJoin('roles as ro', 'ru.role_id', '=', 'ro.id')
        ->where('ru.user_id', $user->id)->get();
        // dd($role_user);
        return view('user.edit',[
            'user' => $user,
            'role_user' => $role_user,
            'role' => $role,
            'komda' => $komda
        ]);
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
        $rules = [
            "name" => "required",
            "role" => "required",
            "komda" => "required"
        ];

        if($request->email != $user->email){
            $rule['email'] = 'required|email:dns|unique:users';
        }
        
        $request->validate($rules);
        $data = array(
            'name' => $request->name,
            'komda_id' => $request->komda,
            'email' => $request->email
        );
        User::where('id', $user->id)->update($data);
        DB::table('role_user')->where('user_id', $user->id)->delete();
        foreach($request->role as $role){
            DB::table('role_user')->insert([
                'role_id' => $role,
                'user_id' => $user->id,
                'user_type' => 'App\Models\User'
            ]);
        }
        return redirect()->route('user')->with('success', 'Berhasil mengubah data');
    }

    public function changepassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);

        if ( $user->save()) {
            return redirect()->route('user')->with('success', 'Password updated successfully');
        } else {            
            return redirect()->route('user')->with('error', 'Password failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        DB::table('role_user')->where('user_id', $user->id)->delete();
        return redirect()->route('user')->with('success', 'Berhasil menghapus data');
    }
}
