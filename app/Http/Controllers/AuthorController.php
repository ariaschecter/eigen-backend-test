<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['Author', true, route('admin.author.index')],
            ['Index', false],
        ];
        $title = 'All Authors';
        $authors = Author::all();
        return view('admin.author.index', compact('breadcrumbs', 'title', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['Author', true, route('admin.author.index')],
            ['Create', false],
        ];
        $title = 'Create Author';
        return view('admin.author.create', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        $validated = $request->validated();

        $author = Author::withTrashed()->count();

        $code = $author + 1;

        $validated['code'] = sprintf('A%03d', $code);

        Author::create($validated);

        return redirect()->route('admin.author.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.store')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $breadcrumbs = [
            ['Author', true, route('admin.author.index')],
            [$author->name, false],
        ];
        $title = $author->name;
        $editable = false;
        return view('admin.author.edit', compact('breadcrumbs', 'title', 'author', 'editable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $breadcrumbs = [
            ['Author', true, route('admin.author.index')],
            [$author->name, true, route('admin.author.show', $author->id)],
            ['Edit', false],
        ];
        $title = $author->name;
        $editable = true;
        return view('admin.author.edit', compact('breadcrumbs', 'title', 'author', 'editable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $validated = $request->validated();

        $author->update($validated);

        return redirect()->route('admin.author.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.update')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('member.success.delete')]);
    }
}
