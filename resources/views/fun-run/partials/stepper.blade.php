@php
    $frSteps = [
        ['01', 'Email'],
        ['02', 'Biodata'],
        ['03', 'Bayar'],
        ['04', 'Selesai'],
    ];
@endphp

<div class="mx-auto mb-8 flex max-w-md items-center">

    @foreach ($frSteps as $i => [$num, $label])

        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">

            <div class="flex flex-col items-center gap-1.5">

                <div class="flex h-8 w-8 items-center justify-center rounded-full font-display text-[11px] font-bold transition
                    {{ ($i + 1) <= $currentStep
                        ? 'bg-emerald-500 text-slate-950'
                        : 'bg-white/5 text-slate-500 ring-1 ring-white/10' }}">
                    {{ $num }}
                </div>

                <span class="text-[9px] font-bold uppercase tracking-wider
                    {{ ($i + 1) <= $currentStep ? 'text-emerald-400' : 'text-slate-600' }}">
                    {{ $label }}
                </span>

            </div>

            @if (!$loop->last)
                <div class="mx-2 mb-4 h-px flex-1 {{ ($i + 1) < $currentStep ? 'bg-emerald-500' : 'bg-white/10' }}"></div>
            @endif

        </div>

    @endforeach

</div>