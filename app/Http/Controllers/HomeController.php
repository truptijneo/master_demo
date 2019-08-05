<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Validator;
use App\Forms\AddRoleForm;
use Yajra\Datatables\Datatables;

use App\Http\Requests\User\UserViewRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserDeleteRequest;

use App\Http\Requests\Role\RoleViewRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Requests\Role\RoleDeleteRequest;

use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

use App\Product;
use App\Order;
use App\User;
use App\Role;

use Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;
        if($role == 'admin'){
            return view('home');
        }
        return response()->view('401');
    }

    public function userIndex()
    {        
        $user = User::with('roles')->find(\Auth::id());
        $role = $user->roles[0]->name;

        $products = Product::all()
                            ->toArray();
        $user_id = auth()->user()->id; 
        
        $orders = Order::where('user_id', $user_id)->get();
        
        return view('user.home', compact('orders'));        
    }

    // Get roles
    public function roles(RoleViewRequest $req)
    {
        $roles = Role::all();
        return view('vendor.adminlte.role.roles', compact('roles'));
    }

    public function createRole(FormBuilder $formBuilder, RoleCreateRequest $request)
    {
        $form = $formBuilder->create(AddRoleForm::class,[
            'method' => 'POST',
            'url' => route('addRole')
        ]);
        
        return view('vendor.adminlte.role.add_role', compact('form'));
    }

    public function addRole(RoleCreateRequest $request)
    {
        $roles = Role::get()->pluck('name')->toArray(); 
        $name = $request->get('name');
        if(!in_array($name, $roles)){ 
            
            $role = new Role();
            $role->name = $request->get('name');
            $role->guard_name = $request->get('guard_name');

            try{
                $res = $role->save();

                if($res === true){
                    return redirect()
                            ->route('roles')
                            ->with('success', 'Role added successfully!');
                }else{
                    return redirect()
                            ->route('roles')
                            ->with('error', 'Something went wrong.');
                }
            }catch(QueryException $e){
                if($e->errorInfo[1] == 1062){
                    return redirect()
                            ->route('roles')
                            ->with('error', 'Role must be unique.');
                }else{
                    throw $e;
                }
            }

            
        }else{
            return redirect()
                    ->route('roles')
                    ->with('error', 'Role already exist.');
        }
    }

    public function editRole(RoleUpdateRequest $request, $id)
    {
        $role = Role::find($id);
        if(!empty($role)){
            return view('vendor.adminlte.role.edit_role', compact('role'));
        }else{
            return redirect()
                    ->route('roles')
                    ->with('error', 'Role not found');
        }
    }

    // Update Role
    public function updateRole(RoleUpdateRequest $request, $id) 
    {
        $role = Role::find($id);

        if(!empty($role)){
            $roles = Role::get()->pluck('name')->toArray(); 

            $name = $request->get('name');
            if(!in_array($name, $roles)){ 
                
                $role->name = $request->get('name');
                $role->guard_name = $request->get('guard_name');

                try {
                    $res = $role->update();
                    if($res === true){
                        return redirect()
                                ->route('roles')
                                ->with('success', 'Role updated successfully!');
                    }else{
                        return redirect()
                                ->route('roles')
                                ->with('error', 'Something went wrong.');
                    }
                } catch (QueryException $e) {
                    if($e->errorInfo[1] == 1062) {
                        return redirect()
                            ->route('roles')
                            ->with('error', 'Role must be unique.');
                    } else {
                        throw $e;
                    }
                }
            }else{
                return redirect()
                        ->route('roles')
                        ->with('error', 'Role already exist.');
            }
        }else{
            return redirect()
                        ->route('roles')
                        ->with('error', 'Role not found.');
        }
    }

    // Delete Role
    public function deleteRole(RoleDeleteRequest $request, $id)
    {
        $role = Role::find($id);
        if(!empty($role)){
            $res = $role->delete();

            if($res === true){
                return redirect()
                        ->route('roles')
                        ->with('success', 'Role has been deleted successfully!');
            }else{
                return redirect()
                        ->route('roles')
                        ->with('error', 'Something went wrong.');
            }
        }else{
            return redirect()
                    ->route('roles')
                    ->with('error', 'Role not found');
        }
    }

    public function users(UserViewRequest $request)
    {
        return view('vendor.adminlte.user.users');
    }

    public function userView()
    {
        $users = User::with('roles')
                        ->get();
        //return Datatables::of($users)->make(true);                
        return $users = Datatables::of(User::query()->with('roles'))
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="edit-user/'.$row->id.'" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>' . ' ' .
                                    '<a href="delete-user/'.$row->id.'" class="edit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                            return $btn;
                        })
                        ->addColumn('role', function ($users) {
                            $roles = '';
                            if(!empty($users->roles)){
                                
                                foreach($users->roles as $role){
                                    $roles = ucfirst($role->name).", ".$roles;
                                }
                            }
                            return trim($roles,', ');
                                
                        })
                        ->rawColumns(['action', 'role'])
                        ->make(true);
    }

    public function editUser(UserUpdateRequest  $request,$id)
    { 
        $user = User::find($id); 
        if(!empty($user)){
            return view('vendor.adminlte.user.edit_user', compact('user'));
        }else{
            return redirect()
                    ->route('users')
                    ->with('error', 'User not found');
        }
    }

    // Update User
    public function updateUser(UserUpdateRequest  $request, $id) 
    {
        $user = User::find($id); 

        if(!empty($user)){
            $users = Role::get()->pluck('email')->toArray(); 

            $email = $request->get('email');
            if(!in_array($email, $users)){ 
                $user->name = $request->get('uname');
                $user->email = $request->get('email');

                try{
                    $res = $user->save();

                    if($res === true){
                        return redirect()
                                ->route('users')
                                ->with('success', 'User updated successfully!');
                    }else{
                        return redirect()
                                ->route('users')
                                ->with('error', 'Something went wrong.');
                    }
                }catch(QueryException $e){
                    if($e->errorInfo[1] == 1062){
                        return redirect()
                                ->route('users')
                                ->with('error', 'Email must be unique.');
                    }else{
                        throw $e;
                    }
                }
            }else{
                return redirect()
                        ->route('users')
                        ->with('error', 'User already exist.');
            }
        }else{
            return redirect()
                        ->route('users')
                        ->with('error', 'User not found.');
        }
    }

    // Delete User
    public function deleteUser(UserDeleteRequest $request, $id)
    {
        $user = User::find($id);
        if(!empty($user)){
            $res = $user->delete();

            if($res === true){
                return redirect()
                        ->route('users')
                        ->with('success', 'User has been deleted successfully!');
            }else{
                return redirect()
                        ->route('users')
                        ->with('error', 'Something went wrong.');
            }
        }else{
            return redirect()
                    ->route('users')
                    ->with('error', 'User not found');
        }
    }

    // Import CSV file
    public function importUserCSV(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file')->getRealPath();
        
        $data = \Excel::load($path)->get();

        $users = User::get()->pluck('email')->toArray();
        $temp = array();

        if($data->count()){
            foreach ($data as $key => $value) {
                $key = $key+2;
                if(!in_array($value->email, array_map('strtolower', $users))){
                    User::create([
                        'name' => $value->name,
                        'email' => $value->email,
                        'password' => \Hash::make('User@123'),
                        'remember_token' => Str::random(60),
                        'created_at' => $value->created_at,  
                        'updated_at' => $value->updated_at     
                    ]);

                    $users = User::get()->pluck('email')->toArray();
                }else{
                    $temp[$key] = $value->email;
                }
            }

            $count = count($temp);
            
            if($count>0){
               
                return redirect()
                    ->route('users')
                    ->with(['message'=> $temp]);
            }else{
                return back()->with('success', 'File data inserted successfully!');
            }
        }
    }

    public function exportUsers($type) 
    {
        $data = User::get()->toArray();
            
        return Excel::create('Users', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
}