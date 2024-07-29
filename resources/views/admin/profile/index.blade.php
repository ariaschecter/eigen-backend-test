@extends('admin.admin_template')

@section('main')
    @include('admin.partials.breadcrumb')
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">{{ $title }}</div>
                </div>
            </header>
            @include('admin.partials.alert')
            <div class="card-text h-full ">
                <form class="space-y-4" method="POST" action="{{ route('admin.profile.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="input-area relative">
                        <label for="name" class="form-label">Name<span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter Your Name" value="{{ $user->name }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="email" class="form-label">Email<span class="text-red-500">*</span></label>
                        <input type="text" id="email" name="email" class="form-control"
                            placeholder="Enter Your Email" value="{{ $user->email }}" readonly>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter Your Password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            placeholder="Enter Your Password Confirmation">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <button class="btn inline-flex justify-center btn-dark">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
