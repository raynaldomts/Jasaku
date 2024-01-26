<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasRole('Admin')){
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
        }

        $id_user=Auth::user()->id;
        $user=User::find($id_user);
        return view("user.index",compact("user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('Admin')){
            $roles = Role::pluck('name','name')->all();
            return view('users.create',compact('roles'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'phone' => 'required|unique:users,phone'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->hasRole('Admin')){
            $user = User::find($id);
            return view('users.detail',compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // // $id_user=Auth::user()->id;
        // $user=User::find($id);
        // return view("user.edit",compact("user"));

        if(Auth::user()->hasRole('Admin')){
            $user = User::find($id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();

            return view('users.edit',compact('user','roles','userRole'));
        }

        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        if(Auth::user()->hasRole('Admin')){
            if(Auth::user()->no_telp == request('no_telp') && Auth::user()->email == request('email')){
                $this->validate(request(), [
                    'nama' => 'required',
                    // 'email' => 'required|email|unique:users',
                    'password' => 'required|min:8|confirmed',
                    // 'no_telp' => 'required|unique:users',
                    'alamat' => 'required',
                    'no_rek' => 'required',
                    'roles' => 'required',
                ]);
            }
    
            else if(Auth::user()->email == request('email')){
                $this->validate(request(), [
                    'nama' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8|confirmed',
                    // 'no_telp' => 'required|unique:users',
                    'alamat' => 'required',
                    'no_rek' => 'required',
                    'roles' => 'required',
                ]);
            }
            
            else if(Auth::user()->no_telp == request('no_telp')){
                $this->validate(request(), [
                    'nama' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8|confirmed',
                    // 'no_telp' => 'required|unique:users',
                    'alamat' => 'required',
                    'no_rek' => 'required',
                    'roles' => 'required',
                ]);
            }
    
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            
            $user->nama = request('nama');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));
            $user->no_telp = request('no_telp');
            $user->alamat = request('alamat');
            $user->no_rek = request('no_rek');
            $user->assignRole(request('roles'));
            $user->save();
    
            return redirect()->route('users.index')->with('success', 'Berhasil mengedit profil');
        }

        if(Auth::user()->no_telp == request('no_telp') && Auth::user()->email == request('email')){
            $this->validate(request(), [
                'nama' => 'required',
                // 'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                // 'no_telp' => 'required|unique:users',
                'alamat' => 'required',
                'no_rek' => 'required',
            ]);
        }

        else if(Auth::user()->email == request('email')){
            $this->validate(request(), [
                'nama' => 'required',
                // 'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'no_telp' => 'required|unique:users',
                'alamat' => 'required',
                'no_rek' => 'required',
            ]);
        }
        
        else if(Auth::user()->no_telp == request('no_telp')){
            $this->validate(request(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                // 'no_telp' => 'required|unique:users',
                'alamat' => 'required',
                'no_rek' => 'required',
            ]);
        }

        $user->nama = request('nama');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->no_telp = request('no_telp');
        $user->alamat = request('alamat');
        $user->no_rek = request('no_rek');
        if(request('deskripsi')){
            $user->deskripsi = request('deskripsi');
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Berhasil mengedit profil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }

    public function jasa($id)
    {
        $user = User::with('getJasaUser')->find($id);
        $user->getJasaUser =  $user->getJasaUser()->orderBy('waktu_dibuat', 'desc')->paginate(6);
        
        $jasa = Jasa::where('id_penjual', $id)->get();

        $user->count = $jasa->count();
        return view('user.jasa', compact('user'));
    }
}
