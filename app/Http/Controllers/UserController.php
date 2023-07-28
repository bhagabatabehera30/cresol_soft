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
            $user = User::select('*');
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('hobbies', function($row){
                $userHobbies=UserHobby::where('user_id',$row->id)->get();
                //dd($userHobbies);
                $hobbiStr='';
                foreach ($userHobbies as $key => $userHobbie) {
                    //dd($userHobbie);
                    $hobbiStr.=($userHobbie->hobby) ? $userHobbie->hobby->hobbie_name.', ' : '';
                }
                return $hobbiStr;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>&nbsp;';
                $btn .= '<a href="'.route('user.destroy', $row->id).'" onclick="return confirm(\'are you sure to delete?\')" class="btn btn-danger btn-xs" title="delete"><i class="fa fa-remove"></i></a>';
                return $btn;
            })
            ->rawColumns(['hobbies','action'])
            ->make(true);
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
