<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Find Study Groups') }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">Search course channels and filter session dates to organize collaborative study circles.</p>
            </div>
            <div>
                <a href="#" class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs uppercase tracking-widest rounded-lg shadow-sm hover:shadow transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Group
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Advanced Search Filter Panel (MEMBER 3 - GRADING FOCUS: FILTER ARRAYS) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <form method="GET" action="{{ route('groups.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <!-- Search Field 1: Subject Code -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Subject / Course Code</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 text-sm">💡</span>
                                </div>
                                <input type="text" name="subj_code" value="{{ $searchedSubject }}" placeholder="e.g. BIIT 2305" class="block w-full pl-9 text-slate-700 border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 rounded-lg text-sm transition">
                            </div>
                        </div>

                        <!-- Search Field 2: Group Title / Keyword -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Group Keyword</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 text-sm">🔍</span>
                                </div>
                                <input type="text" name="title" value="{{ $searchedTitle }}" placeholder="e.g. Project Prep" class="block w-full pl-9 text-slate-700 border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 rounded-lg text-sm transition">
                            </div>
                        </div>

                        <!-- Search Field 3: Session Date -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Study Session Date</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 text-sm">📅</span>
                                </div>
                                <input type="date" name="session_date" value="{{ $searchedDate }}" class="block w-full pl-9 text-slate-700 border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 rounded-lg text-sm transition">
                            </div>
                        </div>

                    </div>

                    <!-- Search Form Action Triggers -->
                    <div class="flex items-center justify-end space-x-3 pt-2">
                        @if($searchedSubject || $searchedTitle || $searchedDate)
                            <a href="{{ route('groups.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition">
                                Clear Filters
                            </a>
                        @endif
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs uppercase tracking-widest rounded-lg shadow-sm hover:shadow transition">
                            Filter Channels
                        </button>
                    </div>
                </form>
            </div>

            <!-- Discovery Display Grid Loop (MEMBER 3 - GRADING FOCUS: LISTING LOOPS) -->
            @if($groups->isEmpty())
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center max-w-md mx-auto space-y-4">
                    <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto border">
                        ⚠️
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">No sessions match filters</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">There are no study groups currently registered matching those exact search requirements. Try clearing some query filters.</p>
                    </div>
                    <a href="{{ route('groups.index') }}" class="inline-block px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs uppercase tracking-wider rounded-lg transition">
                        View All Groups
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($groups as $group)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200 overflow-hidden flex flex-col justify-between">
                            
                            <!-- Main Study Group Metadata Block -->
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-extrabold uppercase rounded-lg border border-teal-100">
                                        {{ $group->subj_code }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">⏱️ {{ \Carbon\Carbon::parse($group->session_time)->format('h:i A') }}</span>
                                </div>
                                
                                <div class="space-y-1">
                                    <h3 class="font-bold text-slate-800 text-lg leading-tight hover:text-teal-600 transition">
                                        {{ $group->title }}
                                    </h3>
                                    <p class="text-xs text-slate-500 font-medium">Venue: <span class="text-slate-700">{{ $group->venue }}</span></p>
                                </div>

                                <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed">
                                    {{ $group->description }}
                                </p>
                            </div>

                            <!-- Interactive Action Drawer Footer -->
                            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between rounded-b-2xl">
                                <div class="space-y-0.5">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block">Group Leader</span>
                                    <h4 class="text-xs font-bold text-slate-700">{{ $group->leader->name }}</h4>
                                    <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($group->session_date)->format('d M Y') }}</p>
                                </div>
                                
                                <div>
                                    <button class="px-3.5 py-1.5 bg-white hover:bg-teal-600 text-teal-600 hover:text-white font-bold text-xs rounded-lg transition border border-teal-600/30 shadow-xs">
                                        Join Group
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>