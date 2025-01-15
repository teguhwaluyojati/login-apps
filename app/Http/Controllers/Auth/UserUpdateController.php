<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
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

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'New password cannot be the same as the current password'
            ], 400);
        }

        $userData = $request->only(['name', 'email']);

        if ($request->has('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $data = $user->only(['name', 'email', 'updated_at']);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $data
        ], 200);
    }

    public function deleteUserById(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $data = $user->only(['name', 'email']);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted user',
            'data' => $data
        ], 200);
    }
}
