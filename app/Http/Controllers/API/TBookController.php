<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowRequest;
use App\Http\Requests\ReturnRequest;
use App\Models\Book;
use App\Models\Member;
use App\Models\TBook;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * @OA\Get(
 *     path="/v1/borrows",
 *     tags={"Borrow"},
 *     summary="Get list of borrows",
 *     description="Returns a list of borrow records with related book and member information.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Data berhasil diambil"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="string", example="9ca7a33e-cda8-4db8-b827-3208c32b4c69"),
 *                     @OA\Property(property="code", type="string", example="B2407-XO5"),
 *                     @OA\Property(property="borrow_date", type="string", format="date", example="2024-07-31"),
 *                     @OA\Property(property="return_date", type="string", format="date", example=null),
 *                     @OA\Property(property="m_member_id", type="string", example="9ca7a31e-3c61-48a0-b26c-5a56757c8df3"),
 *                     @OA\Property(property="m_book_id", type="string", example="9ca7a31e-3b83-41d6-9154-5cc49ca20743"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T15:02:02.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T15:02:02.000000Z"),
 *                     @OA\Property(property="deleted_at", type="string", format="date-time", example=null),
 *                     @OA\Property(
 *                         property="book",
 *                         type="object",
 *                         @OA\Property(property="id", type="string", example="9ca7a31e-3b83-41d6-9154-5cc49ca20743"),
 *                         @OA\Property(property="code", type="string", example="HOB-83"),
 *                         @OA\Property(property="title", type="string", example="The Hobbit, or There and Back Again"),
 *                         @OA\Property(property="stock", type="integer", example=1),
 *                         @OA\Property(property="m_author_id", type="string", example="9ca7a31e-3b63-456a-a48b-55535be38765"),
 *                         @OA\Property(
 *                             property="author",
 *                             type="object",
 *                             @OA\Property(property="id", type="string", example="9ca7a31e-3b63-456a-a48b-55535be38765"),
 *                             @OA\Property(property="code", type="string", example=null),
 *                             @OA\Property(property="name", type="string", example="J.R.R. Tolkien")
 *                         )
 *                     ),
 *                     @OA\Property(
 *                         property="member",
 *                         type="object",
 *                         @OA\Property(property="id", type="string", example="9ca7a31e-3c61-48a0-b26c-5a56757c8df3"),
 *                         @OA\Property(property="code", type="string", example="M001"),
 *                         @OA\Property(property="name", type="string", example="Angga"),
 *                         @OA\Property(property="penalty", type="string", example=null)
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="dev", type="string", example=null)
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Bad Request"
 *     )
 * )
 * @OA\Post(
 *     path="/v1/borrows",
 *     tags={"Borrow"},
 *     summary="Create a new borrow record",
 *     description="Creates a new borrow record and returns the details of the created record.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/BorrowRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Borrow record created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/BorrowResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/v1/returns",
 *     tags={"Return"},
 *     summary="Return a borrowed book",
 *     description="Records the return of a borrowed book and returns the details of the return record.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"code"},
 *                 @OA\Property(property="code", type="string", example="B2407-5V9"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book returned successfully",
 *         @OA\JsonContent(ref="#/components/schemas/ReturnResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

class TBookController extends Controller
{

    /**
     * @OA\Schema(
     *     schema="BorrowRequest",
     *     type="object",
     *     required={"m_member_id", "m_book_id"},
     *     @OA\Property(property="m_member_id", type="string", example="9ca7a31e-3c61-48a0-b26c-5a56757c8df3"),
     *     @OA\Property(property="m_book_id", type="string", example="9ca7a31e-3b83-41d6-9154-5cc49ca20743"),
     * )
     * @OA\Schema(
     *     schema="BorrowResponse",
     *     type="object",
     *     @OA\Property(property="status_code", type="integer", example=201),
     *     @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         @OA\Property(property="m_member_id", type="string", example="9ca7a31e-3c61-48a0-b26c-5a56757c8df3"),
     *         @OA\Property(property="m_book_id", type="string", example="9ca7a31e-3b83-41d6-9154-5cc49ca20743"),
     *         @OA\Property(property="borrow_date", type="string", format="date-time", example="2024-07-31T15:19:17.483108Z"),
     *         @OA\Property(property="code", type="string", example="B2407-01N"),
     *         @OA\Property(property="id", type="string", example="9ca7a969-b496-45df-99de-eef0ebc66e58"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T15:19:17.000000Z"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T15:19:17.000000Z")
     *     ),
     *     @OA\Property(property="dev", type="string", example=null)
     * )
     *
     * @OA\Schema(
     *     schema="ReturnResponse",
     *     type="object",
     *     @OA\Property(property="status_code", type="integer", example=200),
     *     @OA\Property(property="message", type="string", example="Berhasil Mengembalikan Buku."),
     *     @OA\Property(
     *         property="data",
     *         type="object",
     *         @OA\Property(property="id", type="string", example="9ca7ab94-7409-48f6-b712-406d42f64ffe"),
     *         @OA\Property(property="code", type="string", example="B2407-5V9"),
     *         @OA\Property(property="borrow_date", type="string", format="date", example="2024-07-31"),
     *         @OA\Property(property="return_date", type="string", format="date-time", example="2024-07-31T15:30:09.353265Z"),
     *         @OA\Property(property="m_member_id", type="string", example="9ca7a31e-3c61-48a0-b26c-5a56757c8df3"),
     *         @OA\Property(property="m_book_id", type="string", example="9ca7a31e-3b83-41d6-9154-5cc49ca20743"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T15:25:21.000000Z"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T15:30:09.000000Z"),
     *         @OA\Property(property="deleted_at", type="string", format="date-time", example=null)
     *     ),
     *     @OA\Property(property="dev", type="string", example=null)
     * )
     */
    public function borrow()
    {
        $tBooks = TBook::whereHas('member')->with(['book' => function ($book) {
            $book->select('id', 'code', 'title', 'stock', 'm_author_id')->with('author:id,code,name');
        }, 'member:id,code,name,penalty'])->get();

        return response()->success(data: $tBooks, httpCode: 200);
    }

    public function storeBorrow(BorrowRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        $member = Member::where('id', $validated['m_member_id'])->withCount(['tBooks' => fn ($book) => $book->whereNull('return_date')])->first();

        // Check if member got penalty
        if (@$member->penalty !== null) {
            $now = Carbon::today();
            $penalty = Carbon::parse($member->penalty);

            if ($now->gte($penalty)) {
                return response()->failed(message: __('tBook.failed.member_penalty'), httpCode: 422);
            }
        }

        // Check if member has borrow 2 books
        if ($member->t_books_count >= 2) {
            return response()->failed(message: __('tBook.failed.member_quota'), httpCode: 422);
        }

        $book = Book::where('id', $validated['m_book_id'])->withCount(['tBooks' => fn ($book) => $book->whereNull('return_date')])->orderBy('code', 'asc')->first();
        // Check Book Stock
        if ($book->stock - $book->t_books_count <= 0) {
            return response()->failed(message: __('tBook.failed.book_quota'), httpCode: 422);
        }

        // Store to database
        $validated['borrow_date'] = Carbon::now();
        $validated['code'] = 'B' . Carbon::now()->format('ym') . '-' . Str::upper(Str::random(3));
        $tBook = TBook::create($validated);

        return response()->success(data: $tBook, httpCode: 201);
    }

    public function storeReturn(ReturnRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) :
            return response()->failed(error: $request->validator->errors());
        endif;

        $validated = $request->validated();

        $tBook = TBook::where('code', $validated['code'])->first();

        $now = Carbon::today();
        $borrowBook = Carbon::parse($tBook->borrow_date)->addDays(1);

        if (!$now->lt($borrowBook)) {
            // Member got penalty
            Member::where('id', $tBook->m_member_id)->update([
                'penalty' => Carbon::now()->addDays(3),
            ]);
        }

        $tBook->update([
            'return_date' => Carbon::now(),
        ]);

        return response()->success(data: $tBook, httpCode: 200, message: __('tBook.success.return'));
    }
}
