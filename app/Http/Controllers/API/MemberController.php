<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Get(
 *     path="/v1/members",
 *     tags={"Members"},
 *     summary="Get all members",
 *     description="Returns list of members",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/MemberGet"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Post(
 *     path="/v1/members",
 *     tags={"Members"},
 *     summary="Store member to database",
 *     description="Store member to database",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"name"},
 *                 @OA\Property(property="name", type="string", example="This is my name"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/MemberStore"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Get(
 *     path="/v1/members/{id}",
 *     tags={"Members"},
 *     summary="Get detail member",
 *     description="Returns detail of member",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="member ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/MemberGetDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Put(
 *     path="/v1/members/{id}",
 *     tags={"Members"},
 *     summary="Update member",
 *     description="Returns updated member",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="member ID",
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
 *                 @OA\Property(property="name", type="string", example="This is my name"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/MemberPutDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Delete(
 *     path="/v1/members/{id}",
 *     tags={"Members"},
 *     summary="Get deleted member",
 *     description="Return deleted member",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="member ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/MemberDelete"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 */

class MemberController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="MemberAll",
     *     type="object",
     *     title="Get All members",
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", example="A0001"),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="penalty", type="string", example=""),
     *     @OA\Property(property="borrowed_book", type="integer", example=0),
     * )
     * @OA\Schema(
     *     schema="Member",
     *     type="object",
     *     title="Get All members",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", example="A0001"),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="penalty", type="string", example=""),
     * )
     * @OA\Schema(
     *     schema="MemberGet",
     *     type="object",
     *     title="Get All members",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/MemberAll"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="MemberStore",
     *     type="object",
     *     title="Add book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=201),
     *     @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Member"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="MemberGetDetail",
     *     type="object",
     *     title="Get Detail book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/MemberAll"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="MemberPutDetail",
     *     type="object",
     *     title="Update book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diubah"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Member"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="MemberDelete",
     *     type="object",
     *     title="Update book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil dihapus"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Member"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     */

    public function index()
    {
        $members = Member::withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])->get();

        return response()->success(data: $members, httpCode: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $member = Member::withTrashed()->count();
            $code = $member + 1;
            $validated['code'] = sprintf('M%03d', $code);

            $member = Member::create($validated);

            DB::commit();

            return response()->success(data: $member, httpCode: 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($member)
    {
        try {
            $member = Member::where('id', $member)->withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])->first();

            if ($member) {
                return response()->success(data: $member);
            } else {
                return response()->failed();
            }
        } catch (Exception $e) {
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Member $member)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $member->update($validated);

            DB::commit();

            return response()->success(data: $member, httpCode: 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($member)
    {
        try {
            $book = Member::find($member);
            if ($book) {
                $book->delete();
                return response()->success(data: $book, httpCode: 200);
            }
            return response()->failed();
        } catch (\Throwable $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
