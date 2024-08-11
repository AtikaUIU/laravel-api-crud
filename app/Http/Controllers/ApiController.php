<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    //
    public function index(): JsonResponse
    {

        $user = User::all();

        $data = [
            'status' => 200,
            'user' => $user

        ];

        return response()->json($data, 200);
    }


    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); // Hash the password
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data stored successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Data updated successfully',
        ], 200);
    }

    public function delete($id): JsonResponse
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
