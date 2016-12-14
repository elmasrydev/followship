<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

//call the Auth Facade 
use Illuminate\Support\Facades\Auth;

//call The Users And Followers Models
use App\User;
use App\Follower;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all registered users except the authenticated one 
        $arr['users'] = User::where("id","!=",  Auth::id())->get();
        return view('home',$arr);
    }
    
    #### to be called by method post through Ajax
    public function doFollowShip()
    {
        //check if the action of userDo is follow to add a followship record
        if($_POST['userDo'] == "follow"){
            if(Follower::insert(array("followed" => $_POST['userId'],"follower" => Auth::id())))
                echo "success";
        }elseif($_POST['userDo'] == "unfollow"){
            //check if the action of userDo is unfollow to delete a followship record
            if(Follower::where("followed",$_POST['userId'])->where("follower",Auth::id())->delete())
                echo "success";
        }
        
    }
    
    
}
