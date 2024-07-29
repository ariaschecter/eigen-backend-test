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
                <form class="space-y-4" method="POST" action="{{ route('admin.book.store') }}">
                    @csrf
                    <div class="input-area relative">
                        <label for="code" class="form-label">Code <x-required /></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Code"
                            value="{{ old('code') }}">
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="title" class="form-label">Title <x-required /></label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title"
                            value="{{ old('title') }}">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="author" class="form-label">Author <x-required /></label>
                        <input type="text" id="author" name="author" class="form-control" placeholder="Enter Author"
                            value="{{ old('author') }}">
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="stock" class="form-label">Stock <x-required /></label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="Enter Stock"
                            value="{{ old('stock') }}">
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    <button class="btn inline-flex justify-center btn-dark">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
