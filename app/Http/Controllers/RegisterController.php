<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
class RegisterController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('admin');
        }else{
            return view('admin.register');
        }
    }

    public function create(Request $request) {
        if($request->password != $request->re_password) {
            return redirect('register')->with([
               'mess' => 'Nhập lại mật khẩu không khớp.',
            ]);
        }
        try {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'img' => 'https://www.google.com/imgres?imgurl=https%3A%2F%2Fimages.unsplash.com%2Fphoto-1508919801845-fc2ae1bc2a28%3Fixlib%3Drb-4.0.3%26ixid%3DMnwxMjA3fDB8MHxzZWFyY2h8Mnx8aW1nfGVufDB8fDB8fA%253D%253D%26w%3D1000%26q%3D80&imgrefurl=https%3A%2F%2Funsplash.com%2Fs%2Fphotos%2Fimg&tbnid=R4kSBBU37T2shM&vet=12ahUKEwjxuencwsn9AhVWFYgKHYkeBBcQMygRegUIARDbAQ..i&docid=f3riLA-4-1potM&w=1000&h=637&q=img&ved=2ahUKEwjxuencwsn9AhVWFYgKHYkeBBcQMygRegUIARDbAQ',
            ]);
            $user->syncRoles(2);
            $credentials = ([
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if (Auth::attempt($credentials)) {
                return redirect()->route('home')->with([
                   'mess' => 'Đăng ký thành công .',
                ]);
            } else {
                return redirect('register')->with([
                   'mess' => 'Đăng ký thất bại thành công .',
                ]);
            }
        } catch (\Exception $e) {
            return redirect('register')->with([
               'mess' => 'Email đã có người sử dụng.',
            ]);
        }
    }
}
