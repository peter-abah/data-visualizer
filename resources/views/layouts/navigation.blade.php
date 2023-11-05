<nav x-data="{ open: false }" class="border-b bg-bg">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <h1 class="text-xl font-bold tracking-tight text-text">
                            {{ __('Data visualizer') }}
                        </h1>
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div x-data id="theme-btns" class="flex items-center">
                    <button id="theme-dark" data-theme="light" x-cloak
                        x-bind:class="{hidden: @js(request()->cookie('theme')) != null}"
                        title="Switch to light mode"><span class="sr-only">Light mode</span>
                        <x-icons.light-mode class="fill-text" /></button>
                    <button id="theme-dark" data-theme="dark" x-cloak
                        x-bind:class="{hidden: @js(request()->cookie('theme')) !== 'light'}"
                        title="Switch to dark mode"><span class="sr-only">Dark mode</span>
                        <x-icons.dark-mode class="fill-text" /></button>
                    <button id="theme-dark" data-theme="system" x-cloak
                        x-bind:class="{hidden: @js(request()->cookie('theme')) !== 'dark'}"
                        title="Use system theme"><span class="sr-only">System
                            theme</span><x-icons.system class="fill-text" /></button>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center rounded-md border border-transparent bg-bg px-3 py-2 text-sm font-medium leading-4 text-text hover:bg-bg-hover focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="h-4 w-4 fill-current"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-text-light hover:bg-bg-hover focus:bg-bg-hover focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none"
                            viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }"
                                class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="border-t border-border pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-text">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-text-light">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
