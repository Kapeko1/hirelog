<div class="min-h-screen bg-slate-50 dark:bg-zinc-950 transition-colors duration-200"
     x-data="{
         darkMode: localStorage.getItem('darkMode') === 'true',
         init() {
             this.$watch('darkMode', value => {
                 localStorage.setItem('darkMode', value);
                 if (value) {
                     document.documentElement.classList.add('dark');
                 } else {
                     document.documentElement.classList.remove('dark');
                 }
             });
             if (this.darkMode) {
                 document.documentElement.classList.add('dark');
             }
         }
     }">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-slate-200 dark:border-zinc-800 z-50 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-2xl font-bold bg-gradient-to-r from-amber-500 to-amber-600 bg-clip-text text-transparent">{{ __('landing.app_name') }}</span>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-lg text-slate-600 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-1 bg-slate-100 dark:bg-zinc-800 rounded-lg p-1">
                        <a href="{{ route('locale.switch', 'pl') }}"
                           class="px-3 py-1 rounded {{ app()->getLocale() === 'pl' ? 'bg-white dark:bg-zinc-700 text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-600 dark:text-zinc-300' }} transition-all">
                            PL
                        </a>
                        <a href="{{ route('locale.switch', 'en') }}"
                           class="px-3 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-white dark:bg-zinc-700 text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-600 dark:text-zinc-300' }} transition-all">
                            EN
                        </a>
                    </div>

                    <!-- Auth Links -->
                    <a href="/admin/login" class="text-slate-600 dark:text-zinc-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors px-4 py-2 rounded-lg hover:bg-amber-50 dark:hover:bg-zinc-800">
                        {{ __('landing.nav.login') }}
                    </a>
                    <a href="/admin/register" class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg shadow-amber-500/30 hover:shadow-xl hover:shadow-amber-500/40">
                        {{ __('landing.nav.register') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)">
                <div x-show="visible" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 dark:text-white mb-6 leading-tight">
                        {{ __('landing.hero.title_part1') }}
                        <span class="bg-gradient-to-r from-amber-500 via-amber-600 to-orange-500 bg-clip-text text-transparent">
                            {{ __('landing.hero.title_highlight') }}
                        </span>
                        <br>{{ __('landing.hero.title_part2') }}
                    </h1>
                    <p class="text-xl sm:text-2xl text-slate-600 dark:text-zinc-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                        {{ __('landing.hero.subtitle') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/admin/register" class="group relative px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl font-bold text-lg shadow-2xl shadow-amber-500/40 hover:shadow-amber-500/60 hover:from-amber-600 hover:to-amber-700 transition-all duration-300 transform hover:-translate-y-1">
                            <span class="relative z-10">{{ __('landing.hero.cta_register') }}</span>
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-amber-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity blur"></div>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 500)">
                    <div x-show="visible" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xl border border-slate-100 dark:border-zinc-800">
                        <div class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-amber-600 bg-clip-text text-transparent mb-2">7</div>
                        <div class="text-slate-600 dark:text-zinc-400 font-medium">{{ __('landing.stats.statuses') }}</div>
                    </div>
                    <div x-show="visible" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xl border border-slate-100 dark:border-zinc-800">
                        <div class="text-4xl font-bold bg-gradient-to-r from-cyan-500 to-blue-600 bg-clip-text text-transparent mb-2">100MB</div>
                        <div class="text-slate-600 dark:text-zinc-400 font-medium">{{ __('landing.stats.storage') }}</div>
                    </div>
                    <div x-show="visible" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xl border border-slate-100 dark:border-zinc-800">
                        <div class="text-4xl font-bold bg-gradient-to-r from-lime-500 to-green-600 bg-clip-text text-transparent mb-2">∞</div>
                        <div class="text-slate-600 dark:text-zinc-400 font-medium">{{ __('landing.stats.visualizations') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-zinc-900 transition-colors duration-200">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ __('landing.features.section_title') }}
                </h2>
                <p class="text-xl text-slate-600 dark:text-zinc-400 max-w-2xl mx-auto">
                    {{ __('landing.features.section_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($features as $index => $feature)
                <div
                    x-data="{ visible: false, hovered: false }"
                    x-init="setTimeout(() => visible = true, {{ $index * 150 }})"
                    x-show="visible"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    @mouseenter="hovered = true"
                    @mouseleave="hovered = false"
                    class="group relative bg-gradient-to-br from-slate-50 to-white dark:from-zinc-800 dark:to-zinc-900 p-8 rounded-2xl border-2 transition-all duration-300 transform hover:-translate-y-2"
                    :style="hovered ? 'border-color: {{ $feature['color'] }}; box-shadow: 0 25px 50px -12px {{ $feature['color'] }}33;' : 'border-color: ' + (darkMode ? '#3f3f46' : '#f1f5f9') + ';'"
                >
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 transform group-hover:scale-110 transition-transform duration-300 shadow-lg"
                             style="background: linear-gradient(135deg, {{ $feature['colorFrom'] }}, {{ $feature['colorTo'] }});">
                            @if($feature['icon'] === 'briefcase')
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            @elseif($feature['icon'] === 'document')
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            @elseif($feature['icon'] === 'chart')
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            @else
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-3 transition-colors duration-300 dark:text-white"
                            :style="hovered ? 'color: {{ $feature['color'] }};' : ''">
                            {{ __($feature['title_key']) }}
                        </h3>
                        <p class="text-slate-600 dark:text-zinc-400 leading-relaxed">
                            {{ __($feature['description_key']) }}
                        </p>
                    </div>
                    <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"
                         style="background: linear-gradient(135deg, {{ $feature['color'] }}15, transparent);"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-zinc-950 dark:to-zinc-900 transition-colors duration-200">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ __('landing.about.section_title') }}
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Author -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-8 shadow-xl border border-slate-100 dark:border-zinc-800" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 300)" x-show="visible" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('landing.about.author_title') }}</h3>
                    </div>
                    <p class="text-slate-600 dark:text-zinc-400 leading-relaxed mb-6">
                        {{ __('landing.about.author_text') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://www.linkedin.com/in/kacper-gądek-16471330b/"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-[#0A66C2] hover:bg-[#004182] text-white rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <span>{{ __('landing.about.connect_linkedin') }}</span>
                        </a>
                        <a href="mailto:kacper.gadek2@wp.pl"
                           class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('landing.about.email_me') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Why HireLog -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-8 shadow-xl border border-slate-100 dark:border-zinc-800" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 450)" x-show="visible" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('landing.about.why_title') }}</h3>
                    </div>
                    <p class="text-slate-600 dark:text-zinc-400 leading-relaxed mb-4">
                        {{ __('landing.about.why_text') }}
                    </p>
                    <p class="text-slate-600 dark:text-zinc-400 leading-relaxed font-medium italic">
                        {{ __('landing.about.mission') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 dark:bg-black text-slate-400 dark:text-zinc-600 py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-200">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xl font-bold text-white">{{ __('landing.app_name') }}</span>
                </div>
                <div class="text-center md:text-right">
                    <p>&copy; {{ date('Y') }} {{ __('landing.app_name') }}. {{ __('landing.footer.rights') }}</p>
                </div>
            </div>
        </div>
    </footer>
</div>
