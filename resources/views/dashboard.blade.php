<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Welcome back, ') . Auth::user()->name }}!
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-1">Matric Number: <span class="text-teal-600 font-bold">{{ Auth::user()->matric_number ?? 'N/A' }}</span> | Focus Area: {{ Auth::user()->expertise_area ?? 'General academic support' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('groups.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs uppercase tracking-widest rounded-lg shadow-sm hover:shadow transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Find Study Groups
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-teal-800 rounded-2xl bg-teal-50 border border-teal-100 shadow-sm flex items-center space-x-2 animate-fade-in">
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.207a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Groups You Manage</span>
                        <span class="text-4xl font-extrabold text-teal-600 mt-1 block">{{ $ledCount }}</span>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-xl">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Joined Groups</span>
                        <span class="text-4xl font-extrabold text-teal-600 mt-1 block">{{ $joinedCount }}</span>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-xl">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Available Sessions</span>
                        <span class="text-4xl font-extrabold text-slate-700 mt-1 block">{{ $totalGroupsCount }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div>
                                <h3 class="text-md font-bold text-slate-800">Groups You Lead</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Study circles managed and hosted by you.</p>
                            </div>
                            <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full">{{ $ledCount }} Led</span>
                        </div>
                        
                        <div class="p-6">
                            @if($ledGroups->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="text-sm font-semibold text-slate-600">You are not leading any study groups yet.</p>
                                    <p class="text-xs text-slate-400 mt-1">Start your first group to manage your study session with peers.</p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 -my-4">
                                    @foreach($ledGroups as $group)
                                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-0.5 bg-teal-50 text-teal-700 text-xs font-extrabold uppercase rounded border border-teal-100">
                                                        {{ $group->subj_code }}
                                                    </span>
                                                    <span class="text-slate-300 text-xs">|</span>
                                                    <span class="text-xs text-slate-500 font-medium">📍 {{ $group->venue }}</span>
                                                </div>
                                                <h4 class="font-bold text-slate-800 text-base leading-tight hover:text-teal-600 transition">{{ $group->title }}</h4>
                                                <div class="flex items-center space-x-4 text-xs text-slate-500">
                                                    <span class="flex items-center">
                                                        📅 {{ \Carbon\Carbon::parse($group->session_date)->format('d M Y') }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        ⏱️ {{ \Carbon\Carbon::parse($group->session_time)->format('h:i A') }}
                                                    </span>
                                                    <span class="flex items-center text-teal-600 font-medium">
                                                        👥 {{ $group->members_count }} Member(s)
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2 self-start sm:self-center">
                                                <a href="{{ route('groups.show', $group->id) }}" class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold text-xs rounded-lg transition border border-slate-200">
                                                    Manage Group
                                                <a href="{{ route('study-groups.edit', $group->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold text-xs rounded-lg transition border border-amber-200">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('study-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this study group? This cannot be undone.');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-lg transition border border-rose-200">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div>
                                <h3 class="text-md font-bold text-slate-800">Your Joined Groups</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Study circles where you are participating as a group member.</p>
                            </div>
                            <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full">{{ $joinedCount }} Enrolled</span>
                        </div>
                        
                        <div class="p-6">
                            @if($joinedGroups->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="text-sm font-semibold text-slate-600">You haven't joined any study groups yet.</p>
                                    <p class="text-xs text-slate-400 mt-1">Discover peer sessions filtering by specialized subject codes.</p>
                                    <a href="{{ route('groups.index') }}" class="inline-block mt-3 text-teal-600 text-xs font-bold hover:underline">Find Study Circles Now &rarr;</a>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100 -my-4">
                                    @foreach($joinedGroups as $group)
                                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-extrabold uppercase rounded border border-slate-200">
                                                        {{ $group->subj_code }}
                                                    </span>
                                                    <span class="text-slate-300 text-xs">|</span>
                                                    <span class="text-xs text-teal-600 font-semibold">Leader: {{ $group->leader->name }}</span>
                                                </div>
                                                <h4 class="font-bold text-slate-800 text-base leading-tight">{{ $group->title }}</h4>
                                                <div class="flex items-center space-x-4 text-xs text-slate-500">
                                                    <span>📅 {{ \Carbon\Carbon::parse($group->session_date)->format('d M Y') }}</span>
                                                    <span>⏱️ {{ \Carbon\Carbon::parse($group->session_time)->format('h:i A') }}</span>
                                                    <span>📍 {{ $group->venue }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 self-start sm:self-center">
                                                <a href="{{ route('groups.show', $group->id) }}" class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-700 font-semibold text-xs rounded-lg transition border border-teal-200">
                                                    Enter Session
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-md font-bold text-slate-800">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('study-groups.create') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs uppercase tracking-widest rounded-xl transition duration-150 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Create Study Group
                            </a>

                            <a href="{{ route('groups.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-widest rounded-xl transition border border-slate-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Find Academic Circles
                            </a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                            <h3 class="text-md font-bold text-slate-800">Pending Requests</h3>
                            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($pendingRequests as $req)
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-xs font-bold text-slate-800">{{ $req->sender_name }}</h4>
                                            <span class="text-[9px] px-1.5 py-0.5 bg-amber-100 text-amber-800 font-bold uppercase rounded">Pending</span>
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Matric No: {{ $req->matric_number }}</p>
                                        <p class="text-[10px] text-teal-600 font-semibold mt-0.5">Target: {{ $req->group_title }}</p>
                                    </div>
                                    <p class="text-xs text-slate-600 bg-white p-2.5 rounded border border-slate-100 leading-relaxed italic">
                                        "{{ $req->message }}"
                                    </p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <button class="px-2.5 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-[10px] font-bold rounded-lg transition shadow-sm">Approve</button>
                                        <button class="px-2.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold rounded-lg transition">Decline</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>