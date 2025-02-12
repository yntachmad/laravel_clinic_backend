<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //index

    public function index($email)
    {
        //Check User
        $users = User::where('email', $email)->first();
        return response()->json([
            'data' => $users,
            'status' => 'success',
        ]);



    }

    public function updateGoogleId(Request $request, $id)
    {

        $request->validate([
            'google_id' => 'required|string',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->google_id = $request->google_id;
            $user->save();

            return response()->json([
                'data' => $user,
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }


    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'data' => $user,
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }

    }
}
