@extends('layouts.app')

@section('title', 'Penerimaan Santri Baru (PSB)')
@section('description', 'Informasi Lengkap Penerimaan Santri Baru SMP & SMA Dayah Terpadu Ulumul Islam.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-primary-950 text-white py-16 lg:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-accent-gold/20 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-3xl mx-auto space-y-4 scroll-reveal">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-accent-gold text-xs font-bold uppercase tracking-wider">
                Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Penerimaan Santri Baru (PSB)</h1>
            <p class="text-sm sm:text-base text-primary-100/90 leading-relaxed font-medium">
                Informasi resmi pendaftaran santri baru jenjang SMP dan SMA Dayah Terpadu Ulumul Islam. Bergabunglah bersama keluarga besar Ulumul Islam untuk membina generasi berilmu dan berakhlak mulia.
            </p>
        </div>
    </div>
</section>

<!-- Cards Status Pendaftaran SMP & SMA -->
<section class="py-16 bg-bg-warm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Unit 1: SMP PSB Card -->
            <div class="bg-white rounded-3xl p-8 border border-border-main shadow-md space-y-6 scroll-reveal flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-800 font-black text-base flex items-center justify-center">SMP</span>
                            <div>
                                <h3 class="font-black text-lg text-slate-900">SMP Ulumul Islam</h3>
                                <p class="text-xs text-text-sub font-medium">Pendidikan Menengah Pertama</p>
                            </div>
                        </div>
                        @if($smpAdmission && $smpAdmission->is_open)
                        <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Dibuka
                        </span>
                        @else
                        <span class="px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5 border border-rose-200">
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Pendaftaran Sedang Ditutup
                        </span>
                        @endif
                    </div>

                    @if($smpAdmission)
                    <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl {{ $smpAdmission->is_open ? 'bg-primary-50/60 border border-primary-100' : 'bg-slate-50 border border-slate-200 opacity-80' }} text-xs">
                        <div>
                            <span class="text-text-sub font-medium">Periode:</span>
                            <p class="font-bold text-slate-900 mt-0.5">
                                {{ $smpAdmission->start_date ? \Carbon\Carbon::parse($smpAdmission->start_date)->translatedFormat('d M Y') : 'Segera' }} - 
                                {{ $smpAdmission->end_date ? \Carbon\Carbon::parse($smpAdmission->end_date)->translatedFormat('d M Y') : 'Selesai' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-text-sub font-medium">Kuota Tersedia:</span>
                            <p class="font-bold text-slate-900 mt-0.5">{{ $smpAdmission->quota ? $smpAdmission->quota . ' Santri' : 'Sesuai Kapasitas' }}</p>
                        </div>
                    </div>

                    <!-- Persyaratan SMP -->
                    @if($smpAdmission->requirements)
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Persyaratan Pendaftaran:</h4>
                        <div class="text-xs text-text-sub font-medium leading-relaxed whitespace-pre-line bg-bg-alt p-4 rounded-2xl">
                            {{ $smpAdmission->requirements }}
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="pt-6 border-t border-slate-100">
                    @if($smpAdmission && $smpAdmission->is_open)
                    <a href="{{ $smpWaLink }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 rounded-2xl bg-primary-900 hover:bg-primary-950 text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        Daftar SMP via WhatsApp
                    </a>
                    @else
                    <button type="button" disabled class="w-full py-3.5 px-4 rounded-2xl bg-slate-200 text-slate-400 font-extrabold text-xs uppercase tracking-wider cursor-not-allowed pointer-events-none select-none border border-slate-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Pendaftaran Ditutup (WhatsApp Dikunci)
                    </button>
                    @endif
                </div>
            </div>

            <!-- Unit 2: SMA PSB Card -->
            <div class="bg-white rounded-3xl p-8 border border-border-main shadow-md space-y-6 scroll-reveal flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 font-black text-base flex items-center justify-center">SMA</span>
                            <div>
                                <h3 class="font-black text-lg text-slate-900">SMA Ulumul Islam</h3>
                                <p class="text-xs text-text-sub font-medium">Pendidikan Menengah Atas</p>
                            </div>
                        </div>
                        @if($smaAdmission && $smaAdmission->is_open)
                        <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Dibuka
                        </span>
                        @else
                        <span class="px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5 border border-rose-200">
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Pendaftaran Sedang Ditutup
                        </span>
                        @endif
                    </div>

                    @if($smaAdmission)
                    <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl {{ $smaAdmission->is_open ? 'bg-amber-50/60 border border-amber-100' : 'bg-slate-50 border border-slate-200 opacity-80' }} text-xs">
                        <div>
                            <span class="text-text-sub font-medium">Periode:</span>
                            <p class="font-bold text-slate-900 mt-0.5">
                                {{ $smaAdmission->start_date ? \Carbon\Carbon::parse($smaAdmission->start_date)->translatedFormat('d M Y') : 'Segera' }} - 
                                {{ $smaAdmission->end_date ? \Carbon\Carbon::parse($smaAdmission->end_date)->translatedFormat('d M Y') : 'Selesai' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-text-sub font-medium">Kuota Tersedia:</span>
                            <p class="font-bold text-slate-900 mt-0.5">{{ $smaAdmission->quota ? $smaAdmission->quota . ' Santri' : 'Sesuai Kapasitas' }}</p>
                        </div>
                    </div>

                    <!-- Persyaratan SMA -->
                    @if($smaAdmission->requirements)
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Persyaratan Pendaftaran:</h4>
                        <div class="text-xs text-text-sub font-medium leading-relaxed whitespace-pre-line bg-bg-alt p-4 rounded-2xl">
                            {{ $smaAdmission->requirements }}
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="pt-6 border-t border-slate-100">
                    @if($smaAdmission && $smaAdmission->is_open)
                    <a href="{{ $smaWaLink }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 rounded-2xl bg-primary-900 hover:bg-primary-950 text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        Daftar SMA via WhatsApp
                    </a>
                    @else
                    <button type="button" disabled class="w-full py-3.5 px-4 rounded-2xl bg-slate-200 text-slate-400 font-extrabold text-xs uppercase tracking-wider cursor-not-allowed pointer-events-none select-none border border-slate-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Pendaftaran Ditutup (WhatsApp Dikunci)
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alur Pendaftaran Step by Step (Dinamis & Interaktif) -->
        <div class="space-y-8 scroll-reveal pt-8" x-data="{ activeStepTab: 'smp' }">
            <div class="text-center space-y-3 max-w-xl mx-auto">
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Tahapan Masuk</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Alur Penerimaan Santri</h2>
                <p class="text-xs text-text-sub font-medium">Ikuti tahapan resmi seleksi santri baru dengan mudah, transparan, dan terstruktur.</p>
                
                <!-- Unit Switcher for Steps -->
                <div class="inline-flex p-1 rounded-2xl bg-white border border-border-main shadow-xs mt-2">
                    <button type="button" @click="activeStepTab = 'smp'" :class="activeStepTab === 'smp' ? 'bg-primary-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
                        <span>📚</span>
                        <span>Alur SMP</span>
                    </button>
                    <button type="button" @click="activeStepTab = 'sma'" :class="activeStepTab === 'sma' ? 'bg-primary-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
                        <span>🎓</span>
                        <span>Alur SMA</span>
                    </button>
                </div>
            </div>

            @php
                $smpSteps = $smpAdmission ? $smpAdmission->formatted_steps : (new \App\Models\AdmissionSetting)->formatted_steps;
                $smaSteps = $smaAdmission ? $smaAdmission->formatted_steps : (new \App\Models\AdmissionSetting)->formatted_steps;
            @endphp

            <!-- SMP Steps Container -->
            <div x-show="activeStepTab === 'smp'" x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($smpSteps as $index => $step)
                <div class="group bg-white p-6 rounded-3xl border border-border-main shadow-xs hover:shadow-xl hover:border-primary-300 transition-all duration-300 space-y-4 relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary-50 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="w-9 h-9 rounded-2xl bg-primary-900 text-white font-black text-xs flex items-center justify-center shadow-md group-hover:bg-accent-gold group-hover:text-primary-950 transition-colors">
                                {{ $index + 1 }}
                            </span>
                            <div class="p-2 rounded-xl bg-primary-50 text-primary-900 group-hover:bg-accent-gold/20 transition-colors">
                                @if(($step['icon'] ?? '') === 'academic')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/></svg>
                                @elseif(($step['icon'] ?? '') === 'megaphone')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'check')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'user')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'payment')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'mosque')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @elseif(($step['icon'] ?? '') === 'phone')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @endif
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-primary-900 transition-colors">{{ $step['title'] ?? '' }}</h4>
                        <p class="text-xs text-text-sub font-medium leading-relaxed">{{ $step['description'] ?? '' }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-primary-900/70">
                        <span>Tahap {{ $index + 1 }} dari {{ count($smpSteps) }}</span>
                        <svg class="w-3.5 h-3.5 text-primary-900 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- SMA Steps Container -->
            <div x-show="activeStepTab === 'sma'" x-transition:enter="transition ease-out duration-300 transform opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" style="display: none;">
                @foreach($smaSteps as $index => $step)
                <div class="group bg-white p-6 rounded-3xl border border-border-main shadow-xs hover:shadow-xl hover:border-amber-300 transition-all duration-300 space-y-4 relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="w-9 h-9 rounded-2xl bg-amber-900 text-white font-black text-xs flex items-center justify-center shadow-md group-hover:bg-accent-gold group-hover:text-primary-950 transition-colors">
                                {{ $index + 1 }}
                            </span>
                            <div class="p-2 rounded-xl bg-amber-50 text-amber-900 group-hover:bg-accent-gold/20 transition-colors">
                                @if(($step['icon'] ?? '') === 'academic')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/></svg>
                                @elseif(($step['icon'] ?? '') === 'megaphone')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'check')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'user')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'payment')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                @elseif(($step['icon'] ?? '') === 'mosque')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @elseif(($step['icon'] ?? '') === 'phone')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @endif
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-amber-900 transition-colors">{{ $step['title'] ?? '' }}</h4>
                        <p class="text-xs text-text-sub font-medium leading-relaxed">{{ $step['description'] ?? '' }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-amber-900/70">
                        <span>Tahap {{ $index + 1 }} dari {{ count($smaSteps) }}</span>
                        <svg class="w-3.5 h-3.5 text-amber-900 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
