<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Database;


class FriendController extends Controller
{

    public function listFriendByUser($id)
    {
        $friends = DB::table('friends')
            ->join('users', 'users.id', '=', 'friends.friend_id')
            ->select('friends.friend_name', 'users.image', 'friends.user_id', 'friends.friend_id')
            ->where([['friends.friend_id',$id],['friends.is_accept',true]])
            ->get();
        return response()->json($friends);
    }

    public function requestFriend($id)
    {
        $friends = DB::table('friends')
            ->join('users','users.id','=','friends.friend_id')
            ->select('friends.friend_name','friends.user_id','friends.friend_id','friends.is_accept')
            ->where([['friends.friend_id',$id],['is_accept',false]])
            ->get();

        return response()->json($friends);
    }

    public function addFriend($id)
    {
        $user = Auth::user();
        $friend = new Friend();
            $friend->user_id = Auth::id();
            $friend->friend_id = $id;
            $friend->friend_name = $user->name;
            $friend->save();
            return response()->json($friend);

    }

    public function deleteRequest($id)
    {
        $user = Friend::where([['friend_id',Auth::id()],['user_id',$id]])->first();
        $user->delete();
        return response()->json('Delete friend');
    }

    public function acceptFriend($id)
    {
        $friend = Friend::where([['friend_id',Auth::id()],['user_id',$id]])->first();
        $is_friend = Friend::create([
            'user_id'=>$friend->friend_id,
            'friend_id'=>$friend->user_id,
            'friend_name'=>Auth::user()->name,
            'is_accept'=>true
        ]);
        $friend->is_accept = true;
        $friend->save();
        $data = [
            'friend'=>$friend,
            'is_friend'=>$is_friend
        ];
        return response()->json($data);

    }

    public function listUsers()
    {
        $array = [];
        $friends = DB::table('friends')
            ->select('friends.friend_id')
            ->get();
        foreach ( $friends as $friend){
            array_push($array,$friend->friend_id);
        }
        $user = DB::table('users')
            ->select('users.id','users.name', 'users.image')
            ->whereNotIn('id',$array)
            ->limit(10)
            ->get();
        return response()->json($user);

    }

}
