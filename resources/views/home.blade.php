@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Who To Follow !</div>
                <div class="panel-body">
                    <table class="col-md-10 col-md-offset-1">
                        <thead>
                            <tr style="align:center">
                                <th>User Name</th>
                                <th>Following</th>
                                <th>Followers</th>
                                <th>Follow/Unfollow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr style="height:50px">
                                    <td class="col-md-3">{{$user->name}}</td>
                                    <!-- getting following number where the user is a follower -->
                                    <td class="col-md-3">{{\App\Follower::where("follower",$user->id)->count()}}</td>
                                    <!-- getting followers number where the user is a followed -->
                                    <!-- setting class called followersNum to this td + attribute userId to update its value-->
                                    <td class="col-md-3 followersNum" userId="{{$user->id}}">{{\App\Follower::where("followed",$user->id)->count()}}</td>
                                    <td class="col-md-3">
                                        <!--checking if the authenticated user is already following this user to show a follow/unfollow button -->
                                        @if($following = \App\Follower::where("followed",$user->id)->where("follower",Auth::id())->first())
                                            <button class="btn btn-danger" userId="{{$user->id}}" userDo="unfollow">UnFollow</button>
                                            <button class="btn btn-success" userId="{{$user->id}}" userDo="follow" style="display: none;">Follow</button>
                                        @else
                                            <button class="btn btn-danger" userId="{{$user->id}}" userDo="unfollow" style="display: none;">UnFollow</button>
                                            <button class="btn btn-success" userId="{{$user->id}}" userDo="follow">Follow</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<script>
    $( document ).ready(function() {
            $(".btn").click(function(e){
                $token = "{{csrf_token()}}";//setting variable for csrf token
                var userId = $(this).attr("userId");//setting variable for userId of clicked row
                var userDo = $(this).attr("userDo");//setting variable for button action
                $.post("{{url('doFollowShip')}}",{userId:userId,userDo:userDo,_token:$token},function(data){
                    if(data == "success"){
                        //get the followers number to increment or decrement depending on userDo (follow/unfollow)
                        var followersNum = $(".followersNum[userId="+userId+"]").html();
                        if(userDo == "follow"){
                            $(".btn[userId="+userId+"][userDo="+userDo+"]").hide();
                            $(".btn[userId="+userId+"][userDo=unfollow]").show();
                            $(".followersNum[userId="+userId+"]").html(parseInt(followersNum)+1);
                        }else{
                            $(".btn[userId="+userId+"][userDo="+userDo+"]").hide();
                            $(".btn[userId="+userId+"][userDo=follow]").show();
                            $(".followersNum[userId="+userId+"]").html(parseInt(followersNum)-1);
                        }
                    }else{
                        //alert an error msg if ajax mission failed
                        alert("Oops .. something went wrong !")
                    }
                });
            });
        });
</script>
@endsection
