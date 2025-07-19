<div x-data="sideMenu()" class="relative flex flex-col min-h-screen">
    {{-- Toggle Button --}}
    <button
        @click="toggleSidebar"
        class="absolute top-16 -right-4 transform -translate-y-1/2 z-20 bg-f7 text-white p-1 rounded-full transition-all hover:bg-f7/90"
        aria-label="Toggle Sidebar"
    >
        <div :class="{ 'rotate-180': !open }" class="transition-transform duration-300">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                <path d="M7.82054 20.7313C8.21107 21.1218 8.84423 21.1218 9.23476 20.7313L15.8792 14.0868C17.0505 12.9155 17.0508 11.0167 15.88 9.84497L9.3097 3.26958C8.91918 2.87905 8.28601 2.87905 7.89549 3.26958C7.50497 3.6601 7.50497 4.29327 7.89549 4.68379L14.4675 11.2558C14.8581 11.6464 14.8581 12.2795 14.4675 12.67L7.82054 19.317C7.43002 19.7076 7.43002 20.3407 7.82054 20.7313Z" fill="#129990"/>
            </svg>
        </div>
    </button>

    {{-- Sidebar --}}
    <div
        :class="{ 'w-60': open, 'w-20': !open }"
        class="transition-all duration-300 bg-navgreen text-white h-full flex flex-col pt-8"
    >
        {{-- Logo --}}
        <div class="flex items-center h-14 px-4 gap-1">
            <img src="{{ asset('images/icons/logo.svg') }}" class="w-5 h-5 min-w-10">
           <span class="font-bold whitespace-nowrap text-[13px] sm:text-sm md:text-base transition-transform duration-300"
                :class="{ 'scale-x-0 opacity-0': !open }">
                MYGRADETRACK
            </span>
        </div>

        {{-- Navigation --}}
        <ul class="flex-1 mt-10">
            <li class="flex items-center group">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center w-full py-3 pl-6 hover:bg-white/10 transition-colors gap-2"
                   :class="{
                       'bg-[#148079] text-f7 font-bold': activeItem === 'home',
                       'text-white': activeItem !== 'home'
                   }"
                   @click="setActive('home')"
                >
                    <img src="{{ asset('images/icons/home.svg') }}" class="w-4 h-4 min-w-[1.5rem]">
                    <span
                        class="ml-3 whitespace-nowrap transition-all duration-200"
                        :class="{ 'opacity-0 invisible': !open, 'opacity-100 visible': open, 'font-bold': activeItem === 'home' }"
                    >
                        Home
                    </span>
                </a>
            </li>
            <li class="flex items-center group">
                <a href="{{ route('grades') }}"
                   class="flex items-center w-full py-3 pl-6 hover:bg-white/10 transition-colors gap-2"
                   :class="{
                       'bg-[#148079] text-f7 font-bold': activeItem === 'grades',
                       'text-white': activeItem !== 'grades'
                   }"
                   @click="setActive('grades')"
                >
                    <img src="{{ asset('images/icons/grades.svg') }}" class="w-4 h-4 min-w-[1.5rem]">
                    <span
                        class="ml-3 whitespace-nowrap transition-all duration-200"
                        :class="{ 'opacity-0 invisible': !open, 'opacity-100 visible': open, 'font-bold': activeItem === 'grades' }"
                    >
                        Grades
                    </span>
                </a>
            </li>
            <li class="flex items-center group">
                <a href="{{ route('metrics') }}"
                   class="flex items-center w-full py-3 pl-6 hover:bg-white/10 transition-colors gap-2"
                   :class="{
                       'bg-[#148079] text-f7 font-bold': activeItem === 'metrics',
                       'text-white': activeItem !== 'metrics'
                   }"
                   @click="setActive('metrics')"
                >
                    <img src="{{ asset('images/icons/analytics.svg') }}" class="w-4 h-4 min-w-[1.5rem]">
                    <span
                        class="ml-3 whitespace-nowrap transition-all duration-200"
                        :class="{ 'opacity-0 invisible': !open, 'opacity-100 visible': open, 'font-bold': activeItem === 'metrics' }"
                    >
                        Metrics
                    </span>
                </a>
            </li>
        </ul>

        {{-- User Profile (Bottom) --}}
        <div class="p-4 bg-greenactive relative">
            <div
                @mouseenter="showMenu = true"
                @mouseleave="showMenu = false"
                class="relative"
            >
                {{-- Profile Button --}}
                <button
                    @click="showMenu = !showMenu"
                    class="flex items-center justify-between w-full"
                >
                    {{-- Profile Info --}}
                  <div class="flex items-center">
                        <img
                            src="{{ asset('images/fox.jpg') }}"
                            class="w-8 h-8 rounded-full object-cover"
                        >
                        <div
                            class="flex flex-col justify-center items-start leading-tight ml-3 transition-all duration-200"
                            :class="{ 'opacity-0 invisible': !open, 'opacity-100 visible': open }"
                        >
                            @php
                                $nameParts = explode(' ', Auth::user()->name);
                                $shortName = implode(' ', array_slice($nameParts, 0, 2));
                            @endphp

                            <p class="text-sm font-medium leading-tight">{{ $shortName }}</p>
                            <p class="text-xs text-white/60 leading-tight">Super Gay</p>
                        </div>
                    </div>

                    {{-- Arrow SVG --}}
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 ml-2 flex-shrink-0 transition-transform"
                        :class="{ 'rotate-180': showMenu }"
                        x-show="open"
                    >
                        <path d="M7.82054 20.7313C8.21107 21.1218 8.84423 21.1218 9.23476 20.7313L15.8792 14.0868C17.0505 12.9155 17.0508 11.0167 15.88 9.84497L9.3097 3.26958C8.91918 2.87905 8.28601 2.87905 7.89549 3.26958C7.50497 3.6601 7.50497 4.29327 7.89549 4.68379L14.4675 11.2558C14.8581 11.6464 14.8581 12.2795 14.4675 12.67L7.82054 19.317C7.43002 19.7076 7.43002 20.3407 7.82054 20.7313Z" fill="#f7f7f7"/>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div
                    x-show="showMenu"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute bg-f7 rounded-md shadow-lg z-10 overflow-hidden min-w-[12rem]"
                    @mouseenter="showMenu = true"
                    @mouseleave="showMenu = false"
                    x-bind:style="popupPosition()"
                >
                    {{-- Account Settings --}}
                    <a href="{{ route('profile.show') }}"  class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Account Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="{{ route('logout') }}"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-200"
                        @click.prevent="$root.submit();"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>