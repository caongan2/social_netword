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
    public function listFriend($id)
    {
        $friends = DB::table('friends')
                ->join('users','users.id','=','friends.friend_id')
                ->select('friends.id','users.name','friends.user_id','friends.friend_id','friends.is_accept')
                ->where([['friends.user_id',$id],['is_accept',true]])
                ->get();

        return response()->json($friends);
    }

    public function requestFriend($id)
    {
        $friends = DB::table('friends')
            ->join('users','users.id','=','friends.friend_id')
            ->select('users.name','friends.user_id','friends.friend_id','friends.is_accept')
            ->where([['friends.user_id',$id],['is_accept',false]])
            ->get();

        return response()->json($friends);
    }

    public function addFriend($id)
    {
            $friend = new Friend();
            $friend->user_id = Auth::id();
            $friend->friend_id = $id;
            $friend->save();
            return response()->json($friend);

    }

    public function deleteRequest($id)
    {
        $user = Friend::where([['friend_id',$id],['user_id',Auth::id()]])->first();
        $user->delete();
        return response()->json('Delete friend');
    }

    public function acceptFriend($id)
    {
        $friend = Friend::where([['friend_id',$id],['user_id',Auth::id()]])->first();
        $friend->is_accept = true;
        $friend->save();
        return response()->json($friend);
        
    }
}
