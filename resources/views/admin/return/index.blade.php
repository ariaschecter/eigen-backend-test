@extends('admin.admin_template')

@section('main')
    <div id="content_layout">
        @include('admin.partials.breadcrumb')
        <div class=" space-y-5">
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">{{ $title }}
                    </h4>
                </header>
                @include('admin.partials.alert')
                <div class="p-3">

                    <div class="card-text h-full w-1/2">
                        <form class="space-y-4" method="POST" action="{{ route('admin.return.return') }}">
                            @csrf

                            <div class="input-area relative">
                                <label for="code" class="form-label">Code <x-required /></label>
                                <input type="text" id="code" name="code" class="form-control"
                                    placeholder="Enter Book Code" value="{{ old('code') }}">
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <button class="btn inline-flex justify-center btn-primary mt-3">
                                <span class="flex items-center">
                                    <span>Return</span>
                                </span>
                            </button>
                        </form>
                    </div>

                </div>
                {{-- <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class=" table-th ">
                                                Id
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Code
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Book Title
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Member Name
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Borrow Date
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Return Date
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        @foreach ($tBooks as $key => $tBook)
                                            <tr>
                                                <td class="table-td">{{ $key + 1 }}</td>
                                                <td class="table-td">{{ $tBook->code }}</td>
                                                <td class="table-td">{{ $tBook->book->title }}</td>
                                                <td class="table-td">{{ $tBook->member->name }}</td>
                                                <td class="table-td">
                                                    {{ \Carbon\Carbon::parse($tBook->borrow_date)->format('d F Y') }}
                                                </td>
                                                <td class="table-td">
                                                    {{ $tBook->return_date ? \Carbon\Carbon::parse($tBook->return_date)->format('d F Y') : '-' }}
                                                </td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <a href="{{ route('admin.member.show', $member->id) }}"
                                                            class="toolTip onTop justify-center action-btn"
                                                            data-tippy-content="Show" data-tippy-theme="primary">
                                                            <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                        </a>
                                                        <a href="{{ route('admin.member.edit', $member->id) }}"
                                                            class="toolTip onTop justify-center action-btn"
                                                            data-tippy-content="Edit" data-tippy-theme="info">
                                                            <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                        </a>
                                                        <form action="{{ route('admin.member.destroy', $member->id) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="toolTip onTop justify-center action-btn"
                                                                type="submit" data-tippy-content="Delete"
                                                                data-tippy-theme="danger">
                                                                <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </div>
@endsection
