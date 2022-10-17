<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRecords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:users,uuid|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(403);
        }
        User::create([
            'uuid' => $request->post('user_id')
        ]);
        return response()->json([
            'status' => true,
        ]);

    }

    public function getRecords(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(403);
        }
        $records = UserRecords::where('user_id', $request->get('user_id'))->get();
        return response()->json($records);
    }

    public function saveRecords(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'recording_at' => 'required|date',
            'service' => 'required|in:Доверенность,Наследство,Справка',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(403);
        }

        $model = UserRecords::create($request->all());
        return response()->json($model);
    }

    public function resetRecords(Request $request): JsonResponse
    {
        UserRecords::truncate();
        return response()->json([
            'status' => true,
        ]);
    }
}
