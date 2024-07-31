<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Get(
 *     path="/v1/books",
 *     tags={"Books"},
 *     summary="Get all books",
 *     description="Returns list of books",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/BookGet"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Post(
 *     path="/v1/books",
 *     tags={"Books"},
 *     summary="Store book to database",
 *     description="Store book to database",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"code", "title", "m_author_id", "stock"},
 *                 @OA\Property(property="code", type="string", example="BK-192"),
 *                 @OA\Property(property="title", type="string", example="Buku Matematika"),
 *                 @OA\Property(property="m_author_id", type="string", example=""),
 *                 @OA\Property(property="stock", type="integer", example=12),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/BookStore"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Get(
 *     path="/v1/books/{id}",
 *     tags={"Books"},
 *     summary="Get detail book",
 *     description="Returns detail of book",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="book ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/BookGetDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Put(
 *     path="/v1/books/{id}",
 *     tags={"Books"},
 *     summary="Update book",
 *     description="Returns updated book",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="book ID",
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
 *                 required={"code", "title", "m_author_id", "stock"},
 *                 @OA\Property(property="code", type="string", example="BK-192"),
 *                 @OA\Property(property="title", type="string", example="Buku Matematika"),
 *                 @OA\Property(property="m_author_id", type="string", example=""),
 *                 @OA\Property(property="stock", type="integer", example=12),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/BookPutDetail"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 * @OA\Delete(
 *     path="/v1/books/{id}",
 *     tags={"Books"},
 *     summary="Get deleted book",
 *     description="Return deleted book",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="book ID",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/BookDelete"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad request",
 *     )
 * )
 */

class BookController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="author",
     *     type="object",
     *     title="Author",
     *     required={"id", "name"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", nullable=true, example=null),
     *     @OA\Property(property="name", type="string", example="J.K Rowling")
     * )
     * @OA\Schema(
     *     schema="bookAll",
     *     type="object",
     *     title="Get All books",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", example="A0001"),
     *     @OA\Property(property="title", type="string", example="John Doe"),
     *     @OA\Property(property="stock", type="integer", example=12),
     *     @OA\Property(property="m_author_id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5d"),
     *     @OA\Property(property="borrowed_book", type="integer", example=0),
     *     @OA\Property(property="available_stock", type="integer", example=12),
     *     @OA\Property(
     *         property="author",
     *         ref="#/components/schemas/author"
     *     )
     * )
     * @OA\Schema(
     *     schema="book",
     *     type="object",
     *     title="Get All books",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5c"),
     *     @OA\Property(property="code", type="string", example="A0001"),
     *     @OA\Property(property="title", type="string", example="John Doe"),
     *     @OA\Property(property="stock", type="integer", example=12),
     *     @OA\Property(property="m_author_id", type="string", example="9ca5730f-866c-430f-8067-c112e0ac9a5d"),
     * )
     * @OA\Schema(
     *     schema="BookGet",
     *     type="object",
     *     title="Get All books",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/bookAll"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="BookStore",
     *     type="object",
     *     title="Add book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=201),
     *     @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/book"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="BookGetDetail",
     *     type="object",
     *     title="Get Detail book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/bookAll"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="BookPutDetail",
     *     type="object",
     *     title="Update book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil diubah"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/book"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     * @OA\Schema(
     *     schema="BookDelete",
     *     type="object",
     *     title="Update book",
     *     required={"status_code", "message", "data"},
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Data berhasil dihapus"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/book"
     *     ),
     *     @OA\Property(property="dev", type="string", nullable=true, example=null)
     * )
     */
    public function index()
    {
        $books = Book::whereHas('author')->with('author:id,code,name')->withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])
            ->get()->map(function ($book) {
                $book->available_stock = $book->stock - $book->borrowed_book;
                return $book;
            });

        return response()->success(data: $books, httpCode: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $book = Book::create($validated);

            DB::commit();

            return response()->success(data: $book, httpCode: 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            $book = Book::where('id', $book->id)->whereHas('author')->with('author:id,code,name')->withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])
                ->first();
            $book->available_stock = $book->stock - $book->borrowed_book;

            return response()->success(data: $book);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $book->update($validated);

            DB::commit();

            return response()->success(data: $book, httpCode: 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->failed(message: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($book)
    {
        try {
            $book = Book::find($book);
            if (@$book->id) {
                $book->delete();
                return response()->success(data: $book, httpCode: 200);
            }
            return response()->failed();
        } catch (\Throwable $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
