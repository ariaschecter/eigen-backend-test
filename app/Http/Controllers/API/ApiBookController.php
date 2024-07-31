<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class ApiBookController extends Controller
{
    /**
     * Display a listing of the resource.
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
    public function store(MemberRequest $request)
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
        $book = Book::where('id', $book->id)->whereHas('author')->with('author:id,code,name')->withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])
            ->first();
        $book->available_stock = $book->stock - $book->borrowed_book;

        return response()->success(data: $book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Book $book)
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
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return response()->success(data: $book, httpCode: 200);
        } catch (Exception $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
