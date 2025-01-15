<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserUpdateController extends Controller
{
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messsage' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userData = $request->only(['name', 'email']);

        if ($request->has('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $data = [
            'name' =>
            $user->name,
            'email' =>
            $user->email,
            'updated_at' =>
            $user->updated_at
        ];

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $data
        ], 200);
    }
}
