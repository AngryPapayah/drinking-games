<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- ✅ Left side: Logo + Links -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">BoozeBuddies</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="/about-us" :active="request()->is('about-us')">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link href="/contact-page" :active="request()->is('contact-page')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- ✅ Right side: Auth Buttons or Dropdown -->
            <div class="flex items-center space-x-4">
                {{-- Als je NIET bent ingelogd --}}
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        🔑 Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                            📝 Register
                        </a>
                    @endif
                @endguest

                {{-- Als je WEL bent ingelogd --}}
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <span class="mr-2 font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Admin-link --}}
                            @if(Auth::user()->role_id === 1)
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Admin Dashboard') }}
                                </x-dropdown-link>
                            @endif

                            {{-- Profile --}}
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                <!-- Hamburger button for mobile -->
                <button @click="open = !open"
                        class="sm:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ✅ Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}"
         class="hidden sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4 mb-2">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-2 space-y-1">
                    @if(Auth::user()->role_id === 1)
                        <x-responsive-nav-link :href="route('admin.dashboard')">
                            🛠️ {{ __('Admin Dashboard') }}
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-600 text-center space-y-2">
                <a href="{{ route('login') }}"
                   class="block mx-auto px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    🔑 Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="block mx-auto px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        📝 Register
                    </a>
                @endif
            </div>
        @endauth
    </div>
</nav>
