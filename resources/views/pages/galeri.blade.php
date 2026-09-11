@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<section class="relative overflow-hidden bg-slate-950 bg-mesh py-20">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">

        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand-400">HIMAFA Gallery</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white sm:text-5xl">Galeri Kegiatan</h1>
            <p class="mx-auto mt-3 max-w-xl text-slate-400">
                Dokumentasi momen dan kegiatan yang telah dilaksanakan oleh HIMAFA.
            </p>
        </div>

        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($galleries as $gallery)

                @php
                    $photos = $gallery->photos;
                @endphp

                @if ($photos->isNotEmpty())

                    <div class="group">

                        <div
                            class="gallery-slider relative aspect-[4/3] overflow-hidden rounded-2xl border border-white/10 bg-slate-900"
                            data-interval="3500"
                        >

                            @foreach ($photos as $slideIndex => $photo)
                                <img
                                    src="{{ asset('storage/' . $photo->foto) }}"
                                    alt="{{ $gallery->judul }}"
                                    data-slide-src="{{ asset('storage/' . $photo->foto) }}"
                                    class="gallery-slide absolute inset-0 h-full w-full object-cover transition duration-1000 group-hover:scale-105
                                    {{ $slideIndex === 0 ? 'opacity-100' : 'opacity-0' }}"
                                >
                            @endforeach

                            @if ($photos->count() > 1)
                                <div class="pointer-events-none absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5">
                                    @foreach ($photos as $slideIndex => $photo)
                                        <span
                                            class="gallery-dot h-1.5 w-1.5 rounded-full transition
                                            {{ $slideIndex === 0 ? 'bg-white' : 'bg-white/50' }}"
                                        ></span>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                        <h3 class="mt-3 text-sm font-bold text-white">
                            {{ $gallery->judul }}
                        </h3>

                        @if ($gallery->deskripsi)
                            <p class="mt-1 text-xs text-slate-400">
                                {{ $gallery->deskripsi }}
                            </p>
                        @endif

                    </div>

                @endif

            @empty

                <div class="col-span-full rounded-2xl border border-dashed border-white/10 p-14 text-center">
                    <p class="text-sm text-slate-400">
                        Belum ada dokumentasi kegiatan.
                    </p>
                </div>

            @endforelse

        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        function setActiveGallerySlide(slider, slides, dots, index) {

            slides.forEach(function(slide, i) {
                slide.classList.toggle('opacity-100', i === index);
                slide.classList.toggle('opacity-0', i !== index);
            });

            dots.forEach(function(dot, i) {
                dot.classList.toggle('bg-white', i === index);
                dot.classList.toggle('bg-white/50', i !== index);
            });

        }

        document.querySelectorAll('.gallery-slider').forEach(function(slider) {

            const slides = Array.from(slider.querySelectorAll('.gallery-slide'));
            const dots = Array.from(slider.querySelectorAll('.gallery-dot'));

            if (slides.length <= 1) {
                return;
            }

            const interval = parseInt(slider.dataset.interval || '3500', 10);
            let current = 0;

            setInterval(function() {
                current = (current + 1) % slides.length;
                setActiveGallerySlide(slider, slides, dots, current);
            }, interval);

        });

    });
</script>
@endsection