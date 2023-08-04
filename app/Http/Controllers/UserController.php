<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Hobby;
use App\Models\UserHobby;
use DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('users_list');

    }
    public function getUsersData(Request $request)
    {
        if($request->ajax()) {
            $searchValue=$request->search['value'];
            //dd($searchValue);
            $user = User::select('*');
            $dataTableObj=DataTables::eloquent($user)
            ->addIndexColumn()
            ->addColumn('hobbies', function($row){
                $userHobbies=UserHobby::where('user_id',$row->id)->get();
                $hobbiStr=[];
                foreach ($userHobbies as $key => $userHobbie) {
                    $hobby=($userHobbie->hobby) ? $userHobbie->hobby->hobbie_name : null;
                    if($hobby!=null){
                        $hobbiStr[]=$hobby;
                    }
                }
                if(!empty($hobbiStr)){
                    return implode(',', $hobbiStr);
                }else{
                    return null;
                } 
            });
            
            $keyword=$searchValue;
            $usersArr=[];
            if($keyword!=null){
                $usersArr=UserHobby::whereHas('hobby', function ($query) use ($keyword) {
                    if($keyword!=null && strpos($keyword, ',')!==false){
                        $keywordArr=explode(',', $keyword);
                        $f=1;
                        foreach ($keywordArr as $key => $rsVal) {
                            if($rsVal!=null){
                               if($f==1){
                                $query->whereRaw("hobbie_name like ?", ["%$rsVal%"]);
                            }else{
                              $query->orWhereRaw("hobbie_name like ?", ["%$rsVal%"]);  
                          }
                      }
                      $f++;
                  }
              }else{
                $query->whereRaw("hobbie_name like ?", ["%$keyword%"]);
            }
        })->pluck('user_id')->toArray();
                if(!empty($usersArr)){
                    $usersArr=array_unique($usersArr);
                    $usersArr=array_values($usersArr);
                }
            }
            if(!empty($usersArr)){
               $dataTableObj->filterColumn('hobbies', function ($q) use ($usersArr) {
                   $q->orWhereIn("id", $usersArr);
               });
           }

           $dataTableObj=$dataTableObj->addColumn('action', function($row){
            $btn = '<a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>&nbsp;';
            $btn .= '<a href="'.route('user.destroy', $row->id).'" onclick="return confirm(\'are you sure to delete?\')" class="btn btn-danger btn-xs" title="delete"><i class="fa fa-remove"></i></a>';
            return $btn;
        })
           ->rawColumns(['hobbies','action'])
           ->toJson();
           return $dataTableObj;
       }
   }
   public function create()
   {
    $hobbies=Hobby::all();
        //dd($hobbies);
    return view('create_user',['hobbies'=>$hobbies]);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'user_hobbies' => 'required'
    ]);

    $user_hobbies=$request->user_hobbies;
        //dd($user_hobbies);
    $user=new User;
    $user->first_name=$request->first_name;
    $user->last_name=$request->last_name;
    $user->save();
    if($user->id){
        foreach ($user_hobbies as $key => $user_hobby_id) {
            $userHobby=new UserHobby;
            $userHobby->user_id=$user->id;
            $userHobby->hobby_id=$user_hobby_id;
            $userHobby->save();
        }

    }


    return Redirect::route('users.list')->with('success', 'User has been created successfully.');

}

public function edit($id)
{
    $user=User::findOrFail($id);
    $hobbies=Hobby::all();
    $userHobbies=$user->userHobbies()->pluck('hobby_id')->toArray();
    return view('edit_user',['hobbies'=>$hobbies,'user'=>$user,'userHobbies'=>$userHobbies]);
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'user_hobbies' => 'required'
    ]);

    $user=User::findOrFail($id);
    $user_hobbies=$request->user_hobbies;
        //dd($user_hobbies);
    $user->first_name=$request->first_name;
    $user->last_name=$request->last_name;
    $user->save();
    if($user->id){
        $includeIdsArr=[];
        foreach ($user_hobbies as $key => $user_hobby_id) {
           $userHobbies=$user->userHobbies()->pluck('hobby_id')->toArray();
           if(!empty($userHobbies)){
            if(in_array($user_hobby_id, $userHobbies)){
                $userHobby=UserHobby::where('user_id',$user->id)->where('hobby_id', $user_hobby_id)->first();
                if($userHobby!=null){
                    $includeIdsArr[]=$userHobby->id;
                }
            }else{
             $userHobby=new UserHobby;
             $userHobby->user_id=$user->id;
             $userHobby->hobby_id=$user_hobby_id;
             $userHobby->save();  
             $includeIdsArr[]=$userHobby->id;
         }
     }else{
        $userHobby=new UserHobby;
        $userHobby->user_id=$user->id;
        $userHobby->hobby_id=$user_hobby_id;
        $userHobby->save(); 
        $includeIdsArr[]=$userHobby->id;  
    }
}

if(!empty($includeIdsArr)){
    $userHobbyArr=UserHobby::whereNotIn('id',$includeIdsArr)->where('user_id',$user->id)->get();
    foreach ($userHobbyArr as $key => $userHobby) {
        $userHobby->delete();
    }
}

}

return Redirect::route('users.list')->with('success', 'User has been updated successfully.');
}
public function destroy($id)
{
    $user=User::findOrFail($id);
    $userHobbyArr=UserHobby::where('user_id',$user->id)->get();
    foreach ($userHobbyArr as $key => $userHobby) {
        $userHobby->delete();
    }
    $user->delete();
    return Redirect::route('users.list')->with('success', 'User has been deleted successfully.');
}

}
