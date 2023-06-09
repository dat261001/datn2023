<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    private $htmlSlelect = '';

    public function __construct(){
        $this->htmlSlelect ='';
        $this->middleware('CheckLoginAdmin');
    }
    public function index()
    {
        $data = User::with("roles")->orderBy('created_at', 'desc')->paginate(20);
        return view("admin.users.index",["data"=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'img' => '',
                'dob' => ''
            ]);
            $user->syncRoles($request->role);
            DB::commit();

            return redirect('admin/users')->with(["mess"=>"Đã thêm 1 tài khoản mới"]);
        } catch(Exception $e){
            DB::rollBack();

            return redirect('admin/users')->with(["mess"=>"Email đã tồn tại"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("admin.users.change");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view("admin.users.change");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update([
            'password'=> Hash::make($request->new_password)
        ]);
        return redirect()->back()->with(['mess'=>"Đã đổi mật khẩu thành công",'title'=>"Thông báo"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeRole($id)
    {
        $data = User::findOrFail($id)->load("roles");
        return view("admin.users.changeRole", ["data" => $data]);
    }

    public function changeRolePost(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->update([
                "name" => $request->name,
                "email" => $request->email,
            ]);
            $user->syncRoles($request->role);
            DB::commit();

            return redirect()->back()->with(['mess'=>"Đã cập nhật tài khoản thành công",'title'=>"Thông báo"]);
        } catch(Exception $e){
            DB::rollBack();

            return redirect('admin/users')->with(["mess"=>"Email đã tồn tại"]);
        }
    }

    public function destroy($id)
    {
        //
    }
    public function config(){

    }
}
