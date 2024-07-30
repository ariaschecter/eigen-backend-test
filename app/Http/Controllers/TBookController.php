<?php

namespace App\Http\Controllers;

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
        $breadcrumbs = [
            ['Borrow', true, route('admin.borrow.borrow')],
            ['Index', false],
        ];
        $title = 'All Borrow';
        $tBooks = TBook::whereHas('member')->with('book', 'member')->get();

        $books = Book::withCount(['tBooks' => fn ($book) => $book->whereNull('return_date')])->orderBy('code', 'asc')->get();

        $books = $books->filter(function ($book) {
            if ($book->stock - $book->t_books_count > 0) {
                return $book;
            }
        })->values();

        $members = Member::orderBy('code', 'asc')->get();

        return view('admin.borrow.index', compact('breadcrumbs', 'title', 'tBooks', 'books', 'members'));
    }

    public function storeBorrow(BorrowRequest $request)
    {
        $validated = $request->validated();

        $member = Member::where('id', $validated['m_member_id'])->withCount(['tBooks' => fn ($book) => $book->whereNull('return_date')])->first();

        // Check if member got penalty
        if (@$member->penalty !== null) {
            $now = Carbon::today();
            $penalty = Carbon::parse($member->penalty);

            if ($now->gte($penalty)) {
                return redirect()->back()->with(['color' => 'bg-danger-500', 'message' => __('tBook.failed.member_penalty')]);
            }
        }

        // Check if member has borrow 2 books
        if ($member->t_books_count >= 2) {
            return redirect()->back()->with(['color' => 'bg-danger-500', 'message' => __('tBook.failed.member_quota')]);
        }

        $book = Book::where('id', $validated['m_book_id'])->withCount(['tBooks' => fn ($book) => $book->whereNull('return_date')])->orderBy('code', 'asc')->first();
        // Check Book Stock
        if ($book->stock - $book->t_books_count <= 0) {
            return redirect()->back()->with(['color' => 'bg-danger-500', 'message' => __('tBook.failed.book_quota')]);
        }

        // Store to database
        $validated['borrow_date'] = Carbon::now();
        $validated['code'] = 'B' . Carbon::now()->format('ym') . '-' . Str::upper(Str::random(3));
        TBook::create($validated);

        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('tBook.success.borrow')]);
    }

    public function destroyBorrow(TBook $tBook)
    {
        $tBook->delete();
        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('tBook.success.delete')]);
    }

    public function return()
    {
        $breadcrumbs = [
            ['Return', true, route('admin.return.return')],
            ['Index', false],
        ];
        $title = 'Return Book';

        return view('admin.return.index', compact('breadcrumbs', 'title'));
    }

    public function storeReturn(ReturnRequest $request)
    {
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

        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('tBook.success.return')]);
    }
}
