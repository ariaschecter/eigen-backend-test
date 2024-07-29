<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['User', true, route('admin.user.index')],
            ['Index', false],
        ];
        $title = 'All Users';
        $users = User::latest()->get();
        return view('admin.user.index', compact('breadcrumbs', 'title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['User', true, route('admin.user.index')],
            ['Create', false],
        ];
        $title = 'Create User';
        return view('admin.user.create', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'email_verified_at' => now()
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return redirect()->route('admin.user.create')->with(['color' => 'bg-success-500', 'message' => __('user.success.store')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $breadcrumbs = [
            ['User', true, route('admin.user.index')],
            [$user->name, false],
        ];
        $title = $user->name;
        $editable = false;
        return view('admin.user.edit', compact('breadcrumbs', 'title', 'user', 'editable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['User', true, route('admin.user.index')],
            [$user->name, false],
        ];
        $title = $user->name;
        $editable = true;
        return view('admin.user.edit', compact('breadcrumbs', 'title', 'user', 'editable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            if ($validated['password'] == null) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            DB::commit();

            return redirect()->route('admin.user.index')->with(['color' => 'bg-success-500', 'message' => __('user.success.store')]);
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
