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
                <form class="space-y-4" method="POST" action="{{ route('admin.book.update', $book->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="input-area relative">
                        <label for="code" class="form-label">Code @if ($editable)
                                <x-required />
                            @endif
                        </label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Code"
                            value="{{ $book->code }}" {{ !$editable ? 'disabled' : '' }}>
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="title" class="form-label">Title @if ($editable)
                                <x-required />
                            @endif
                        </label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title"
                            value="{{ $book->title }}" {{ !$editable ? 'disabled' : '' }}>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div>
                        <label for="m_author_id" class="form-label">Author</label>
                        <select name="m_author_id" id="m_author_id" class="select2 form-control w-full mt-2 py-2">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}"
                                    {{ $author->id == $book->m_author_id ? 'selected' : '' }}
                                    class=" inline-block font-Inter font-normal text-sm text-slate-600">
                                    {{ $author->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('m_author_id')" class="mt-2" />
                    </div>
                    <div class="input-area relative">
                        <label for="stock" class="form-label">Stock @if ($editable)
                                <x-required />
                            @endif
                        </label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="Enter Stock"
                            value="{{ $book->stock }}" {{ !$editable ? 'disabled' : '' }}>
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    @if ($editable)
                        <button class="btn inline-flex justify-center btn-dark">Submit</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
