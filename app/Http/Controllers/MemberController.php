<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['Member', true, route('admin.member.index')],
            ['Index', false],
        ];
        $title = 'All Members';
        $members = Member::all();
        return view('admin.member.index', compact('breadcrumbs', 'title', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['Member', true, route('admin.member.index')],
            ['Create', false],
        ];
        $title = 'Create Member';
        return view('admin.member.create', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        $validated = $request->validated();

        $member = Member::withTrashed()->count();

        $code = $member + 1;

        $validated['code'] = sprintf('M%03d', $code);

        Member::create($validated);

        return redirect()->route('admin.member.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.store')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $breadcrumbs = [
            ['Member', true, route('admin.member.index')],
            [$member->name, false],
        ];
        $title = $member->name;
        $editable = false;
        return view('admin.member.edit', compact('breadcrumbs', 'title', 'member', 'editable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $breadcrumbs = [
            ['Member', true, route('admin.member.index')],
            [$member->name, true, route('admin.member.show', $member->id)],
            ['Edit', false],
        ];
        $title = $member->name;
        $editable = true;
        return view('admin.member.edit', compact('breadcrumbs', 'title', 'member', 'editable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Member $member)
    {
        $validated = $request->validated();

        $member->update($validated);

        return redirect()->route('admin.member.index')->with(['color' => 'bg-success-500', 'message' => __('member.success.update')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->back()->with(['color' => 'bg-success-500', 'message' => __('member.success.delete')]);
    }
}
