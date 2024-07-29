<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['Book', true, route('admin.book.index')],
            ['Index', false],
        ];
        $title = 'All Books';
        $books = Book::with('author')->get();

        return view('admin.book.index', compact('breadcrumbs', 'title', 'books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['Book', true, route('admin.book.index')],
            ['Create', false],
        ];
        $title = 'Create Book';

        $authors = Author::orderBy('name', 'ASC')->get();

        return view('admin.book.create', compact('breadcrumbs', 'title', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $validated = $request->validated();

        $member = Book::withTrashed()->count();

        Book::create($validated);

        return redirect()->route('admin.book.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.store')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $breadcrumbs = [
            ['Book', true, route('admin.book.index')],
            [$book->title, false],
        ];
        $title = $book->title;
        $editable = false;
        $authors = Author::orderBy('name', 'ASC')->get();

        return view('admin.book.edit', compact('breadcrumbs', 'title', 'book', 'editable', 'authors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $breadcrumbs = [
            ['Book', true, route('admin.book.index')],
            [$book->title, true, route('admin.book.show', $book->id)],
            ['Edit', false],
        ];
        $title = $book->title;
        $editable = true;
        $authors = Author::orderBy('name', 'ASC')->get();

        return view('admin.book.edit', compact('breadcrumbs', 'title', 'book', 'editable', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $validated = $request->validated();

        $book->update($validated);

        return redirect()->route('admin.book.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.update')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('member.success.delete')]);
    }
}
