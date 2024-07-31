<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Get(
 *     path="/v1/authors",
 *     tags={"Authors"},
 *     summary="Get all authors",
 *     description="Returns list of authors",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/AuthorGet"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Post(
 *     path="/v1/authors",
 *     tags={"Authors"},
 *     summary="Store Author to database",
 *     description="Store Author to database",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"name"},
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/AuthorStore"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Get(
 *     path="/v1/authors/{id}",
 *     tags={"Authors"},
 *     summary="Get detail author",
 *     description="Returns detail of author",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Author ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/AuthorGetDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Put(
 *     path="/v1/authors/{id}",
 *     tags={"Authors"},
 *     summary="Update author",
 *     description="Returns updated author",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Author ID",
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
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/AuthorPutDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Delete(
 *     path="/v1/authors/{id}",
 *     tags={"Authors"},
 *     summary="Get deleted author",
 *     description="Return deleted author",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Author ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/AuthorDelete"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 */

class AuthorController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Author",
     *     type="object",
     *     title="Get All Authors",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", example="A0001"),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     * )
     * @OA\Schema(
     *     schema="AuthorGet",
     *     type="object",
     *     title="Get All Authors",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Author"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="AuthorStore",
     *     type="object",
     *     title="Add Author",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=201),
     *     @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Author"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="AuthorGetDetail",
     *     type="object",
     *     title="Get Detail Author",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Author"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="AuthorPutDetail",
     *     type="object",
     *     title="Update Author",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diubah"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Author"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="AuthorDelete",
     *     type="object",
     *     title="Update Author",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil dihapus"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/Author"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     */
    public function index()
    {
        $authors = Author::all();

        return response()->success(data: $authors, httpCode: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $author_count = Author::withTrashed()->count();
            $code = $author_count + 1;
            $validated['code'] = sprintf('A%03d', $code);
            $author = Author::create($validated);

            DB::commit();

            return response()->success(data: $author, httpCode: 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($author)
    {
        $author = Author::find($author);

        if ($author) {
            return response()->success(data: $author);
        } else {
            return response()->failed(httpCode: 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, $author)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $author = Author::find($author);

            if ($author) {
                $validated = $request->validated();
                $author->update($validated);

                DB::commit();

                return response()->success(data: $author, httpCode: 200);
            } else {
                return response()->failed(httpCode: 404);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author)
    {
        try {
            $author = Author::find($author);
            if ($author) {
                $author->delete();
                return response()->success(data: $author, httpCode: 200);
            }
            return response()->failed(httpCode: 404);
        } catch (\Throwable $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
