<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $request->only(['email','password']);

        if (Auth::attempt($user)) {
            return redirect()->route('landing-page');
        } else{
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('succes','Anda telah logout !!');
    }

    public function index(Request $request)
    {
        //
        $users = User::where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'ASC',)->simplePaginate(5);
        return view('user.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
            'role'=>'required',
        ]);

        // user::create([
        //     'email'=>$request->email,
        //     'password'=>hash::make($request->password),
        //     'role'=>'kasir',
        // ]);

        $proses = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => $request->password,
            'role' => $request -> role,
         ]);
 
         if ($proses) {
             return redirect()->route('users')->with('success', 'Data Berhasil Ditambahkan');
         }else {
             return redirect()->route('users.add')->with('failed', 'Gagal menambahkan data ');
         }
    }

    public function login() {
        return view('login');
    }


    // public function pagesLogin(Request $request){
    //     $request->validate([
    //         'email'=>'required|email',
    //         'password'=>'required|min:6',
    //     ]);

    //     if (Auth::attempt(['email' => $email, 'password' => $password])) {
    //         $user= Auth::user();
    //         if  (user->role === 'admin') {
    //             return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    //         }elseif ($user->role === 'kasir') {
    //             return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
    //         }
    //     }

    //     return back()->withErrors([
    //         'email'=>'Email atau password salah.',
    //     ])->withInput($request->only('email'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::where('id', $id)->first();
        return view('user.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $users = User::find($id);

        if (!$users) {
            return redirect()->route('users')->with('failed', 'User not found.');
        }

        // Update the user fields
        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->role;

        // Update password only if provided
        if ($request->filled('password')) {
            $users->password = Hash::make($request->password);
        }

        $users->save();

        return redirect()->route('users')->with('success', 'User account successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $proses = User::where('id', $id)->delete();
        if ($proses) {
            return redirect()->route('users')->with('success', 'Data obat Berhasil Dihapus');
        }else {
            return redirect()->route('users')->with('failed', 'Gagal menghapus data obat');
        }
    }
}
