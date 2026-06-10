<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden my-6">
    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
        <div>
            <h3 class="font-bold text-gray-800 text-base">Pending Group Applicants</h3>
            <p class="text-xs text-gray-500">Review student applications requesting to access your managed study groups.</p>
        </div>
        <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-1 rounded-full">{{ count($pendingRequests) }} New</span>
    </div>
    
    <ul class="divide-y divide-gray-100">
        @forelse($pendingRequests as $request)
            <li class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50/50 transition duration-150">
                <div class="space-y-1 max-w-xl">
                    <div class="flex items-center space-x-2">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $request->user->name }}</h4>
                        <span class="text-xs text-gray-400">|</span>
                        <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $request->user->matric_number }}</span>
                    </div>
                    <p class="text-xs text-indigo-600 font-semibold tracking-wide uppercase">Area of Expertise: {{ $request->user->expertise_area ?? 'General Student' }}</p>
                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-200/60 mt-2">
                        <p class="text-xs text-gray-600 italic">"{{ $request->message }}"</p>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Applying for group: <span class="font-medium text-gray-600">{{ $request->studyGroup->title }}</span></p>
                </div>
                
                <div class="flex items-center space-x-3 mt-4 sm:mt-0 self-end sm:self-center">
                    <form action="{{ route('requests.decline', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-rose-600 font-semibold bg-rose-50 hover:bg-rose-100 border border-rose-100 px-4 py-2 rounded-xl transition duration-150">
                            Decline
                        </button>
                    </form>

                    <form action="{{ route('requests.approve', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-white font-bold bg-emerald-500 hover:bg-emerald-600 shadow-sm border border-emerald-500 px-4 py-2 rounded-xl transition duration-150">
                            Approve Member
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 text-gray-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">All caught up! No pending join requests found.</p>
            </li>
        @endforelse
    </ul>
</div>
