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
            <div class="card-text h-full ">
                <form class="space-y-4" method="POST" action="{{ route('admin.author.update', $author->id) }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="input-area relative">
                        <label for="name" class="form-label">Nama
                            @if ($editable)
                                <x-required />
                            @endif
                        </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama"
                            value="{{ $author->name }}" {{ !$editable ? 'disabled' : '' }}>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    @if ($editable)
                        <button class="btn inline-flex justify-center btn-dark">Submit</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
