<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Database;


class FriendController extends Controller
{
//    private $database;
//    private $tablename;
//
//    public function __construct(Database $database)
//    {
//        $this->database = $database;
//        $this->tablename = 'friends';
//    }

    public function addFriend($id)
    {

        $user = User::where([['friend_id',$id],['user_id',Auth::id()]])->first();
        if ($user) {
            $user->delete();
            return response()->json('Delete friend');
        } else {
            $friend = new Friend();
            $friend->user_id = Auth::id();
            $friend->friend_id = $id;
            $friend->save();
            return response()->json($friend);

//            $postData = [
//                'user_id' => Auth::id(),
//                'friend_id'=> $id,
//                'is_accept'=> false
//            ];
//            $postRef = $this->database->getReference($this->tablename)->push($postData);
//            return response()->json($postRef);
        }
//    }
    }
}
