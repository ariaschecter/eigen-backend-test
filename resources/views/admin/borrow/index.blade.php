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
                        <form class="space-y-4" method="POST" action="{{ route('admin.borrow.borrow') }}">
                            @csrf
                            <div>
                                <label for="m_book_id" class="form-label">Book <x-required /></label>
                                <select name="m_book_id" id="m_book_id" class="select2 form-control w-25 mt-2 py-2">
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}"
                                            {{ $book->id == old('m_book_id') ? 'selected' : '' }}
                                            class=" inline-block font-Inter font-normal text-sm text-slate-600">
                                            {{ $book->code . ' - ' . $book->title }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('m_book_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="m_member_id" class="form-label">Member <x-required /></label>
                                <select name="m_member_id" id="m_member_id" class="select2 form-control w-full mt-2 py-2">
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ $member->id == old('m_member_id') ? 'selected' : '' }}
                                            class=" inline-block font-Inter font-normal text-sm text-slate-600">
                                            {{ $member->code . ' - ' . $member->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('m_member_id')" class="mt-2" />
                            </div>
                            <button class="btn inline-flex justify-center btn-primary mt-3">
                                <span class="flex items-center">
                                    {{-- <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2"
                                        icon="heroicons-outline:plus-circle"></iconify-icon> --}}
                                    <span>Borrow</span>
                                </span>
                            </button>
                        </form>
                    </div>

                </div>
                <div class="card-body px-6 pb-6">
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
                                                        <form action="{{ route('admin.borrow.destroy', $tBook->id) }}"
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
                </div>
            </div>
        </div>

    </div>
@endsection
