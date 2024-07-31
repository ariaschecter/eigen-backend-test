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

class TBookController extends Controller
{
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

        return response()->success(data: $tBook, httpCode: 201, message: __('tBook.success.borrow'));
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

        return response()->success(data: $tBook, httpCode: 201, message: __('tBook.success.return'));
    }
}
