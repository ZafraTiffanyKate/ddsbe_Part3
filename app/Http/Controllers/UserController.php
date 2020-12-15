<?php
namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use DB;


Class UserController extends Controller {
   use ApiResponse;

 private $request;


 public function __construct(Request $request){
    $this->request = $request;
 }
 public function getUsers(){
    
   $users = DB :: connection('mysql')
   ->select("Select * from tbluser");
   return $this->successResponse($users);
  }
  
  public function index() {

   $users = User::all();
       return $this->successResponse($users);

  }
  public function addUser(Request $request ){
    $rules = [
      'username' => 'required|max:20',
      'password' => 'required|max:20',
      'jobid' => 'required|numeric|min:1|not_in:0',
    ];

    $this->validate($request,$rules);
    // validate if Jobid is found in the table tbluserjob
    $userjob = UserJob::findOrFail($request->jobid);
    $user = User::create($request->all());

    return $this->successResponse($user, Response::HTTP_CREATED);
    }

  public function showId($id) {

    
     $users = User::where('ID',$id) ->first(); 
    if ($users){
    return $this -> successResponse($users);
  }
  {
    return $this ->errorResponse('User ID does not exists', Response::HTTP_NOT_FOUND);
  }
}
  public function updateUser(Request $request,$id){
    $rules = [
      'username' => 'max:20',
      'password' => 'max:20',
      'jobid' => 'required|numeric|min:1|not_in:0',
 ];

    $this->validate($request, $rules);
 // validate if Jobid is found in the table tbluserjob
    $userjob =UserJob::findOrFail($request->jobid);

    $user = User::findOrFail($id);

    $user->fill($request->all());
 // if no changes happen
    if ($user->isClean()) {
      return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
  }
    $user->save();
    return $this->successResponse($user);

 }
 
  public function deleteUser($id){
    $users = User::where('ID', $id)-> first();
    if($users) {
      $users->delete();
      return $this->successResponse($users);
    }
    {
      return$this->errorResponse('User ID does not Exists', Response::HTTP_NOT_FOUND);
    }
    

  }
}
