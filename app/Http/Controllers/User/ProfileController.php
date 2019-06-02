<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Update Avatar
     */
    public function updateAvatar(Request $request){

        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $user = Auth::user();
    
        if($request->has('avatar')){
            $imageName = $user->username.'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('images/avatar/'), $imageName);
            $request->avatar = $imageName;
            $validateData['avatar'] = $imageName;
        }

        $user = User::findOrFail($user->id);
        $user->avatar = $imageName;
        $user->save();

        $user->avatar = url('images/avatar/'.$imageName);

        return response()->json([
            'message' => 'Berhasil perbarui avatar',
            'user' => $user
        ]);
    }
}
