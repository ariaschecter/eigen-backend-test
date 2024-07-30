<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
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
    public function show(Member $member)
    {
        $member = Member::where('id', $member->id)->withCount(['tBooks as borrowed_book' => fn ($book) => $book->whereNull('return_date')])->first();
        return response()->success(data: $member);
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
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return response()->success(data: $member, httpCode: 200);
        } catch (Exception $e) {
            return response()->failed(message: $e->getMessage());
        }
    }
}
