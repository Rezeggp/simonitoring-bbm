@if (session('success'))
    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-gradient-to-r from-emerald-50 to-emerald-50/50 ring-1 ring-emerald-200 text-emerald-800 px-4 py-3.5 text-sm shadow-sm fade-in">
        <span class="h-6 w-6 rounded-full bg-emerald-100 grid place-items-center shrink-0 mt-0.5">
            <x-icon name="check" class="h-3.5 w-3.5 text-emerald-600"/>
        </span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-gradient-to-r from-red-50 to-red-50/50 ring-1 ring-red-200 text-red-800 px-4 py-3.5 text-sm shadow-sm fade-in">
        <span class="h-6 w-6 rounded-full bg-red-100 grid place-items-center shrink-0 mt-0.5">
            <x-icon name="alert" class="h-3.5 w-3.5 text-red-600"/>
        </span>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-gradient-to-r from-red-50 to-red-50/50 ring-1 ring-red-200 text-red-800 px-4 py-3.5 text-sm shadow-sm fade-in">
        <span class="h-6 w-6 rounded-full bg-red-100 grid place-items-center shrink-0 mt-0.5">
            <x-icon name="alert" class="h-3.5 w-3.5 text-red-600"/>
        </span>
        <div>
            <p class="font-semibold mb-1">Periksa kembali data yang Anda masukkan:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
