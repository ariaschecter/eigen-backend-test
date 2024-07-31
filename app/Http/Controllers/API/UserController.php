<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * @OA\Get(
 *     path="/v1/users",
 *     tags={"Users"},
 *     summary="Get all users",
 *     description="Returns list of users",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/UserGet"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Post(
 *     path="/v1/users",
 *     tags={"Users"},
 *     summary="Store User to database",
 *     description="Store User to database",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"name", "email", "password", "password_confirmation"},
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="password", type="string", example="passwordPanjang"),
 *                 @OA\Property(property="password_confirmation", type="string", example="passwordPanjang")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/UserStore"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Get(
 *     path="/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Get detail user",
 *     description="Returns detail of user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/UserGetDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Put(
 *     path="/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Update user",
 *     description="Returns updated user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"name"},
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="password", type="string", example=""),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/UserPutDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Delete(
 *     path="/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Get deleted user",
 *     description="Return deleted user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/UserDelete"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 */

class UserController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     title="Get All Users",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="email", type="string", example="john@example.com"),
     * )
     * @OA\Schema(
     *     schema="UserGet",
     *     type="object",
     *     title="Get All Users",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/User"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="UserStore",
     *     type="object",
     *     title="Add User",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=201),
     *     @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/User"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="UserGetDetail",
     *     type="object",
     *     title="Get Detail User",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/User"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="UserPutDetail",
     *     type="object",
     *     title="Update User",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diubah"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/User"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="UserDelete",
     *     type="object",
     *     title="Update User",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil dihapus"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/User"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     */
    public function index()
    {
        $users = User::latest()->get(['id', 'name', 'email']);

        return response()->success(data: $users, httpCode: 200);
    }

    public function store(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'email_verified_at' => now()
            ]);

            $user = $user->only('id', 'name', 'email');

            DB::commit();

            return response()->success(data: $user, httpCode: 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        try {
            $user = User::findOrFail($user);
            return response()->success(data: $user);
        } catch (Exception $e) {
            return response()->failed(message: $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            if (@$validated['password'] == null) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            DB::commit();

            return response()->success(data: $user, httpCode: 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->success(data: $user, httpCode: 200);
        } catch (Exception $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
