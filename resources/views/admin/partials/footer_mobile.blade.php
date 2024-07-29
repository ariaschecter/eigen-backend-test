@auth
    <div
        class="bg-white bg-no-repeat custom-dropshadow footer-bg dark:bg-slate-700 flex justify-around items-center backdrop-filter backdrop-blur-[40px] fixed left-0 bottom-0 w-full z-[9999] bothrefm-0 py-[12px] px-4 md:hidden">
        {{-- <div>
            <span class="block text-[17px] text-slate-600 dark:text-slate-300">
                Stay
            </span>
        </div> --}}
        <a href="{{ route('admin.profile.edit') }}"
            class="relative bg-white bg-no-repeat backdrop-filter backdrop-blur-[40px] rounded-full footer-bg dark:bg-slate-700 h-[65px] w-[65px] z-[-1] -mt-[40px] flex justify-center items-center">
            <div class="h-[50px] w-[50px] rounded-full relative left-[0px] hrefp-[0px] custom-dropshadow">
                <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" alt="User"
                    class="w-full h-full rounded-full border-2 border-slate-100">
            </div>
        </a>
        {{-- <div>
            <span class="block text-[17px] text-slate-600 dark:text-slate-300">
                Coding
            </span>
        </div> --}}
    </div>
@endauth
