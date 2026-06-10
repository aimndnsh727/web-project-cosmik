@props(['group'])

<button onclick="document.getElementById('joinModal-{{ $group->id }}').classList.remove('hidden')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-200 ease-in-out transform hover:-translate-y-0.5 text-center text-sm">
    Request to Join Group
</button>

<div id="joinModal-{{ $group->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden flex items-center justify-center z-50 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden border border-gray-100">
        <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
            <h3 class="text-lg font-bold text-indigo-900">Join Study Group</h3>
            <p class="text-xs text-indigo-600 mt-0.5">Target Group: <span class="font-semibold">{{ $group->title }}</span></p>
        </div>
        
        <form action="{{ route('groups.join', $group->id) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Introduce yourself / Message to Leader</label>
                <textarea name="message" rows="4" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder-gray-400 p-3 transition" placeholder="Hi! I want to join this study group because I want to collaborate on assignment topics..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3 border-t border-gray-150 pt-4">
                <button type="button" onclick="document.getElementById('joinModal-{{ $group->id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm transition">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
