<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use Spatie\Permission\Models\Role;
use App\Custom\Constants;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Mail;
use Validator;
use Image;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::whereHas('role',function($query){
            $query->where('name','<>',Constants::ROLE_ADMIN);
        })->get();
        
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::where('name','<>',Constants::ROLE_ADMIN)->get();
        $states = State::all();
        return view('user.add',compact('roles','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
                
            $validation = Validator::make($input,[
                'role'          => ['required'],
                'name'             => ['required', 'string', 'max:255'],
                'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile'           => ['required','unique:users'],
                'firm_name'        => ['required'],
                'gst_no'           => ['required'],
                'state_id'         => ['required'],
                'district'         => ['required'],
                'image'            => ['mimes:jpeg,png,jpg,gif']
            ],[
                'role.required'       => 'This field is required',
                'name.required'          => 'This field is required',
                'name.string'            => 'This field can only accept string',
                'name.max'               => 'This field max length is 255',
                'email.required'         => 'This field is required',
                'email.string'            => 'This field can only accept string',
                'email.max'               => 'This field max length is 255',
                'mobile.required'         => 'This field is required',
                'firm_name.required'         => 'This field is required',
                'gst_no.required'         => 'This field is required',
                'state_id.required'         => 'This field is required',
                'district.required'         => 'This field is required',
                'image.mimes'            => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            $role = Role::where('name',$request->input('role'))->first();
            
            $input['role_id'] = $role->id;

            DB::beginTransaction();
            $users = new User();
    
            if ($file = $request->file('image')) {
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/user_profile/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['profile'] = $image;
    
            }
            $input['status'] =1;
            $dummy_password = str::random(8);
            $input['password'] = Hash::make($dummy_password);
            $input['created_by'] = Auth::id();
            $users->create($input);
            $users->assignRole($request->input('role'));

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        

        $from_email = env('MAIL_FROM_ADDRESS');
        $from_name = env('MAIL_FROM_NAME');

        Mail::send('emails.welcomemail', ['user'=>$input,'password'=>$dummy_password], function($message) use($from_email,$from_name,$input)
        {
            $message->to($input['email'])->from($from_email)->subject('Login Credentails From '.$from_name);
        });

        DB::commit();
        return back()->with('success','User is created successfully');
        
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
        
        $user = User::findOrFail($id);

        $roles = Role::get();
        $states = State::all();
        $userRole = $user->roles->pluck('name','name')->first();

        return view('user.edit',compact('roles','states','user','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            
            
            $validation = Validator::make($input,[
                'role'          => ['required'],
                'name'             => ['required', 'string', 'max:255'],
                // 'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile'           => ['required','unique:users,mobile,'.$id.',id'],
                'firm_name'        => ['required'],
                'gst_no'           => ['required'],
                'state_id'         => ['required'],
                'district'         => ['required'],
                'image'            => ['mimes:jpeg,png,jpg,gif']
            ],[
                'role.required'       => 'This field is required',
                'name.required'          => 'This field is required',
                'name.string'            => 'This field can only accept string',
                'name.max'               => 'This field max length is 255',
                'email.required'         => 'This field is required',
                'email.string'            => 'This field can only accept string',
                'email.max'               => 'This field max length is 255',
                'mobile.required'         => 'This field is required',
                'firm_name.required'         => 'This field is required',
                'gst_no.required'         => 'This field is required',
                'state_id.required'         => 'This field is required',
                'district.required'         => 'This field is required',
                'image.mimes'            => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            $role = Role::where('name',$request->input('role'))->first();
            
            $input['role_id'] = $role->id;
            
            DB::beginTransaction();
            $users = User::findOrFail($id);
    
            if ($file = $request->file('image')) {
                
                if ($users->profile != '' && file_exists(public_path() . '/uploads/user_profile/' . $users->profile)) {
                    unlink(public_path() . '/uploads/user_profile/' . $users->profile);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/user_profile/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['profile'] = $image;
    
            }
            $input['updated_by'] = Auth::id();
            $users->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $users->assignRole($request->input('role'));


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        
        DB::commit();
        return back()->with('success','User is updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(!is_admin(Auth::user()->role_id)){
        //     return abort('401', 'Not Aurthorized');
        // }

        $user = User::find($id);

        if ($user->profile != '' && file_exists(public_path() . '/uploads/user_profile/' . $user->profile)) {
            unlink(public_path() . '/uploads/user_profile/' . $user->profile);
        }

        $value = $user->delete();

        if ($value) {
            return back()->with('success','User Has Been Deleted');
        }
    }

    public function status_update($id){
        
        // if(!is_admin(Auth::user()->role_id)){
        //     return abort('401', 'Not Aurthorized');
        // }

        $f = User::findorfail($id);

        if($f->status==1)
        {
            $f->update(['status' => "0"]);
            return back()->with('success',"Status changed to Deactive !");
        }
        else
        {
            $f->update(['status' => "1"]);
            return back()->with("success","Status changed to Active !");
        }
    }
}
