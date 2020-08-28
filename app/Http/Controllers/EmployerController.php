<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Auth;
use Session;
use App\User;
use Storage;
use App\Employee;
use Illuminate\Http\UploadedFile;

class EmployerController extends Controller
{   

  protected function createFilename(UploadedFile $file)
  {
      $extension = $file->getClientOriginalExtension();
      $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

      // Add timestamp hash to name of the file
      $filename .= "_" . md5(time()) . "." . $extension;

      return $filename;
  }


    public function show_login_form(){
          
     return view('login');
    }

    public function process_login( Request $request){
        $dataForm = $request->all();
        $rules =[
          'email' => 'required',
          'password' => 'required',
       ];
       $validator = validator($dataForm, $rules);
       if ($validator->fails())
       {
         return response()->json([ 'success'=>3, 'error'=>$validator->errors()->all()]);
       }
        else
         {
            $password = $request->password;
            $email = $request->email;
            
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([ 'success'=>1, 'error'=>'user is login!']);
            }
            else{

                return response()->json([ 'success'=>0, 'error'=>'credentials are not correct!']);
            }


         }
     }
     public function show_signup_form(){
          
        return view('register');
       }

       public function process_signup( Request $request){
        $dataForm = $request->all();
        $rules =[
          'email' => 'required|unique:users',
          'password' => 'required',
          'name' => 'required',
       ];
       $validator = validator($dataForm, $rules);
       if ($validator->fails())
       {
         return response()->json([ 'success'=>3, 'error'=>$validator->errors()->all()]);
       }
        else
         {
            $user= new User();
            $user->name=$request->name;
            $user->password=bcrypt($request->password);
            $user->email=$request->email;
            $user->save();

            if($user->save()){
                return response()->json([ 'success'=>1, 'error'=>'user register successfully!']); 
            }
            else{
                return response()->json([ 'success'=>0, 'error'=>'something went wrong!']);
            }    
         

         }
     }


     public function register_employee(Request $request){
      $dataForm = $request->all();
      $rules =[
        'email' => 'required|unique:employees',
        'file' => 'required',
        'name' => 'required',
     ];
     $validator = validator($dataForm, $rules);
     if ($validator->fails())
     {
       return response()->json([ 'success'=>3, 'error'=>$validator->errors()->all()]);
     }
      else
       {  
        if($request->hasFile('file'))
        {
        
          $image = $request->file('file');
          $main_url=config('constant.url');
          $base_url="{$main_url}/";
          $path = $request->file('file')->store("public/image/employee");
      
           $x=$base_url.$path;
          
              $user= new Employee();
              $user->name=$request->name;
              $user->image=$x;
              $user->email=$request->email;
              $user->save();
            
            if($user->save()){
              return response()->json([ 'success'=>1, 'error'=>'Employee register successfully!']); 
            }
            else{
              return response()->json([ 'success'=>0, 'error'=>'something went wrong!']);
            }    
          }


       }

     }

     public function employe_list(){
       $x=Employee::all();
       if($x){
        return response()->json([ 'success'=>1, 'data'=>$x]); 
      }
      else{
        return response()->json([ 'success'=>0, 'error'=>'something went wrong!']);
      }    
     }

     public function delete (Request $request)
    {
        $id=$request->id;
        $x= Employee::find($id);
        $x->delete();
        return response(array(
            
            'success'=>1,
            'msg'=>'succes data'
        ));

    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
