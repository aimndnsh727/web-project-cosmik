<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('dashboard') }}" class="text-teal-600 hover:text-teal-700 text-sm font-bold flex items-center transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Dashboard
                    </a>
                </div>
                <h2 class="font-extrabold text-3xl text-slate-800 leading-tight mt-2 flex items-center gap-3">
                    <span class="px-3 py-1 bg-teal-50 text-teal-700 text-sm font-black uppercase rounded-lg border border-teal-100">
                        {{ $group->subj_code }}
                    </span>
                    {{ $group->title }}
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-1.5">
                    📍 Venue: <span class="text-slate-700 font-bold">{{ $group->venue }}</span> | 📅 Session Date: <span class="text-slate-700 font-bold">{{ \Carbon\Carbon::parse($group->session_date)->format('d M Y') }}</span> at <span class="text-slate-700 font-bold">{{ \Carbon\Carbon::parse($group->session_time)->format('h:i A') }}</span>
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200">
                    👥 {{ $group->members->count() + 1 }} Person(s) in Session
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Flash Session Alerts -->
            @if(session('success'))
                <div class="p-4 bg-teal-50 border-l-4 border-teal-600 rounded-r-xl shadow-sm flex items-start space-x-3 transition animate-pulse">
                    <span class="text-teal-600 font-bold">✓</span>
                    <div class="text-sm font-semibold text-teal-800">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border-l-4 border-rose-600 rounded-r-xl shadow-sm flex items-start space-x-3">
                    <span class="text-rose-600 font-bold">⚠</span>
                    <div class="text-sm font-semibold text-rose-800">{{ session('error') }}</div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT COLUMN: Resources & Drag-and-Drop Uploader -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- File Drag-and-Drop Area (Only if member or leader) -->
                    @if($isMember || $isLeader)
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 transition duration-300 hover:border-teal-400">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Upload Study Resources
                            </h3>
                            <p class="text-xs text-slate-500">Share slides, PDFs, notes, or code zip archives to coordinate resources with your academic circle.</p>
                            
                            <!-- Drag & Drop container -->
                            <form id="upload-form" action="{{ route('resources.store', $group->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <div id="dropzone" class="border-2 border-dashed border-slate-300 hover:border-teal-500 rounded-2xl p-8 text-center bg-slate-50/50 hover:bg-teal-50/20 cursor-pointer transition duration-200 relative">
                                    <input type="file" name="files[]" id="file-input" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.txt,.zip" />
                                    
                                    <div class="space-y-3 pointer-events-none">
                                        <div class="w-16 h-16 bg-white border border-slate-200 rounded-full flex items-center justify-center mx-auto shadow-xs text-2xl text-slate-400" id="upload-icon">
                                            📁
                                        </div>
                                        <div class="text-slate-600 text-sm">
                                            <span class="font-bold text-teal-600 hover:underline">Click to upload</span> or drag and drop files here
                                        </div>
                                        <div class="text-xs text-slate-400 font-medium">
                                            PDF, Word, Excel, PPT, PNG, JPG, TXT, or ZIP (Max 10MB)
                                        </div>
                                    </div>
                                </div>

                                <!-- Real-time File Selected State -->
                                <div id="file-info-preview" class="hidden mt-4 p-4 bg-teal-50/50 rounded-xl border border-teal-100 transition animate-fadeIn">
                                    <div class="flex items-center space-x-3 overflow-hidden">
                                        <span class="text-2xl" id="preview-icon">📄</span>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-bold text-slate-800 truncate" id="preview-filename"></p>
                                            <p class="text-xs text-slate-500" id="preview-filesize"></p>
                                            <ul id="preview-file-list" class="mt-2 list-disc list-inside text-xs text-slate-600 hidden"></ul>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" id="cancel-upload" class="px-3 py-1 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">Cancel</button>
                                        <button type="submit" class="px-3 py-1 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg transition shadow-sm">Upload File</button>
                                    </div>
                                </div>

                                <!-- Validation Error display JS -->
                                <div id="js-error" class="hidden mt-3 p-3 bg-rose-50 border border-rose-100 rounded-xl text-rose-800 text-xs font-semibold"></div>
                            </form>
                        </div>
                    @else
                        <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 flex items-start space-x-4">
                            <span class="text-2xl text-amber-500">🔒</span>
                            <div>
                                <h4 class="font-bold text-amber-800 text-sm">Resource Repository Locked</h4>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Only registered members of this study group can view and upload files. Please request to join this group to unlock access to learning resources.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Resource Repository Grid & Layout -->
                    @if($isMember || $isLeader)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Resource Repository</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Explore shared materials, view previews, and download notes.</p>
                                </div>
                                
                                <!-- Sleek File Category Filtering Tabs -->
                                <div class="flex flex-wrap gap-1 bg-slate-200/60 p-1 rounded-xl text-xs font-bold text-slate-600">
                                    <button onclick="filterType('all')" id="tab-all" class="px-3 py-1.5 bg-white text-teal-600 shadow-xs rounded-lg transition">All</button>
                                    <button onclick="filterType('pdf')" id="tab-pdf" class="px-3 py-1.5 hover:bg-white/50 rounded-lg transition">PDFs</button>
                                    <button onclick="filterType('image')" id="tab-image" class="px-3 py-1.5 hover:bg-white/50 rounded-lg transition">Images</button>
                                    <button onclick="filterType('doc')" id="tab-doc" class="px-3 py-1.5 hover:bg-white/50 rounded-lg transition">Documents</button>
                                </div>
                            </div>

                            <div class="p-6">
                                @if($group->resources->isEmpty())
                                    <div class="text-center py-12" id="no-resources-placeholder">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                                            📥
                                        </div>
                                        <p class="text-sm font-bold text-slate-600">No resources shared yet</p>
                                        <p class="text-xs text-slate-400 mt-1">Be the first to share notes or textbooks with your group!</p>
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="resources-grid">
                                        @foreach($group->resources as $res)
                                            @php
                                                // Categorize file types for filter triggers
                                                $cat = 'doc';
                                                if ($res->file_type === 'pdf') {
                                                    $cat = 'pdf';
                                                } elseif (in_array($res->file_type, ['png', 'jpg', 'jpeg'])) {
                                                    $cat = 'image';
                                                }
                                                
                                                // Icon and Color palette determination
                                                $icon = '📄';
                                                $colorClass = 'bg-slate-50 text-slate-600 border-slate-200';
                                                if ($res->file_type === 'pdf') {
                                                    $icon = '📕';
                                                    $colorClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                                } elseif (in_array($res->file_type, ['png', 'jpg', 'jpeg'])) {
                                                    $icon = '🖼️';
                                                    $colorClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                                } elseif (in_array($res->file_type, ['doc', 'docx'])) {
                                                    $icon = '📘';
                                                    $colorClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                                } elseif (in_array($res->file_type, ['xls', 'xlsx'])) {
                                                    $icon = '📗';
                                                    $colorClass = 'bg-teal-50 text-teal-700 border-teal-100';
                                                } elseif (in_array($res->file_type, ['ppt', 'pptx'])) {
                                                    $icon = '📙';
                                                    $colorClass = 'bg-orange-50 text-orange-700 border-orange-100';
                                                } elseif ($res->file_type === 'zip') {
                                                    $icon = '📦';
                                                    $colorClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                                }
                                            @endphp
                                            
                                            <!-- File Card -->
                                            <div class="resource-card border rounded-2xl p-4 flex flex-col justify-between hover:shadow-sm transition duration-200 bg-white" data-cat="{{ $cat }}">
                                                <div class="flex items-start space-x-3">
                                                    <!-- Colored File Type Badge -->
                                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center border text-2xl shrink-0 {{ $colorClass }}">
                                                        {{ $icon }}
                                                    </div>
                                                    <div class="overflow-hidden">
                                                        <h4 class="font-bold text-sm text-slate-800 truncate" title="{{ $res->file_name }}">
                                                            {{ $res->file_name }}
                                                        </h4>
                                                        <p class="text-[10px] text-slate-400 mt-0.5">
                                                            Size: <span class="font-semibold text-slate-600">{{ round($res->file_size / 1024, 1) }} KB</span>
                                                        </p>
                                                        <p class="text-[10px] text-slate-500 mt-1 flex items-center gap-1">
                                                            👤 <span class="truncate font-medium text-teal-600">{{ $res->uploader->name }}</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                                    <span class="text-[9px] text-slate-400">
                                                        {{ $res->created_at->diffForHumans() }}
                                                    </span>
                                                    
                                                    <div class="flex items-center space-x-1">
                                                        <!-- Preview Actions -->
                                                        @if(in_array($res->file_type, ['png', 'jpg', 'jpeg']))
                                                            <button onclick="previewImage('{{ asset('storage/' . $res->file_path) }}', '{{ $res->file_name }}')" class="px-2 py-1 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold rounded-lg transition" title="Preview Image">
                                                                👁️ Preview
                                                            </button>
                                                        @endif

                                                        <!-- Download -->
                                                        <a href="{{ route('resources.download', $res->id) }}" class="px-2 py-1 bg-teal-50 hover:bg-teal-600 hover:text-white border border-teal-100 text-teal-700 text-[10px] font-bold rounded-lg transition" title="Download Resource">
                                                            📥 Download
                                                        </a>

                                                        <!-- Delete (Only allowed for uploader or leader) -->
                                                        @if($res->user_id === Auth::id() || $isLeader)
                                                            <button type="button" class="p-1 hover:bg-rose-50 border border-transparent hover:border-rose-100 text-rose-600 rounded-lg transition delete-btn" data-url="{{ route('resources.destroy', $res->id) }}" title="Delete Resource">
                                                                🗑️
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Dynamic Empty Filter Placeholder -->
                                    <div class="hidden text-center py-12" id="filter-empty-placeholder">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                            🔍
                                        </div>
                                        <p class="text-sm font-bold text-slate-600">No resources found</p>
                                        <p class="text-xs text-slate-400 mt-1">There are no files uploaded matching this specific category yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- RIGHT COLUMN: Session Details & Members List -->
                <div class="space-y-8">
                    
                    <!-- Session Description Details -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-slate-800">Session Description</h3>
                        <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ $group->description }}
                        </p>
                        
                        <div class="space-y-3 pt-2">
                            <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-2">
                                <span class="font-semibold text-slate-400">COURSE CODE:</span>
                                <span class="font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded border border-teal-100">{{ $group->subj_code }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-2">
                                <span class="font-semibold text-slate-400">VENUE:</span>
                                <span class="font-bold text-slate-700">📍 {{ $group->venue }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-2">
                                <span class="font-semibold text-slate-400">DATE:</span>
                                <span class="font-bold text-slate-700">📅 {{ \Carbon\Carbon::parse($group->session_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-slate-400">TIME:</span>
                                <span class="font-bold text-slate-700">⏱️ {{ \Carbon\Carbon::parse($group->session_time)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Leadership & Member Roster -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-slate-800">Circle Roster</h3>
                        
                        <div class="space-y-4">
                            <!-- Group Leader -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Group Leader</h4>
                                <div class="flex items-center space-x-3 p-3 bg-teal-50/55 rounded-xl border border-teal-100">
                                    <div class="w-10 h-10 bg-teal-600 text-white font-extrabold rounded-lg flex items-center justify-center text-sm shadow-xs">
                                        👑
                                    </div>
                                    <div class="overflow-hidden">
                                        <h5 class="text-sm font-bold text-slate-800 truncate">{{ $group->leader->name }}</h5>
                                        <p class="text-[10px] text-slate-500 truncate">Matric No: {{ $group->leader->matric_number ?? 'N/A' }}</p>
                                        <p class="text-[9px] text-teal-600 font-semibold truncate">Focus: {{ $group->leader->expertise_area ?? 'General Support' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Enrolled Members -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Registered Peers</h4>
                                @if($group->members->isEmpty())
                                    <p class="text-xs text-slate-400 italic py-2 text-center bg-slate-50 rounded-xl">No peers have joined this session yet.</p>
                                @else
                                    <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                        @foreach($group->members as $peer)
                                            <div class="flex items-center space-x-3 p-2.5 bg-white hover:bg-slate-50 rounded-xl border border-slate-100 transition">
                                                <div class="w-8 h-8 bg-slate-100 text-slate-700 font-bold rounded-lg flex items-center justify-center text-xs border border-slate-200">
                                                    {{ strtoupper(substr($peer->name, 0, 2)) }}
                                                </div>
                                                <div class="overflow-hidden">
                                                    <h5 class="text-xs font-bold text-slate-700 truncate">{{ $peer->name }}</h5>
                                                    <p class="text-[9px] text-slate-400 truncate">Matric: {{ $peer->matric_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- HIGH-FIDELITY MEDIA PREVIEW MODAL -->
    <div id="preview-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-xs transition duration-300">
        <div class="relative max-w-4xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-100 flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 id="modal-title" class="font-bold text-slate-800 text-base truncate">Image Preview</h3>
                <button onclick="closePreviewModal()" class="w-8 h-8 rounded-full bg-white hover:bg-slate-200 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs transition">✕</button>
            </div>
            <!-- Modal Content (Scrollable if needed) -->
            <div class="p-6 flex justify-center items-center max-h-[70vh] bg-slate-500/10 overflow-auto">
                <img id="modal-img" src="" alt="Media Preview" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-sm" />
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FOR DRAG-AND-DROP AND FILTERING -->
    <script>
        // 1. Drag & Drop File Upload Interactivity
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file-input');
        const fileInfoPreview = document.getElementById('file-info-preview');
        const previewFilename = document.getElementById('preview-filename');
        const previewFilesize = document.getElementById('preview-filesize');
        const cancelUpload = document.getElementById('cancel-upload');
        const jsError = document.getElementById('js-error');
        const previewIcon = document.getElementById('preview-icon');

        // Allowed extension and sizes
        const allowedExtensions = ['pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','txt','zip'];
        const maxSizeBytes = 10 * 1024 * 1024; // 10MB

        if (dropzone && fileInput) {
            // Highlight drop area
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.add('border-teal-500', 'bg-teal-50/20');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('border-teal-500', 'bg-teal-50/20');
                }, false);
            });

            // Handle dropped files
            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelected(files);
                }
            });

            // Handle picked files
            fileInput.addEventListener('change', (e) => {
                if (fileInput.files.length > 0) {
                    handleFileSelected(fileInput.files);
                }
            });
        }

        function handleFileSelected(files) {
            jsError.classList.add('hidden');
            jsError.innerText = '';

            // Reset any previous list
            const fileListEl = document.getElementById('preview-file-list');
            fileListEl.innerHTML = '';
            fileListEl.classList.add('hidden');

            let totalSize = 0;
            const extensions = [];
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const extension = file.name.split('.').pop().toLowerCase();
                const size = file.size;
                // Validate each file
                if (!allowedExtensions.includes(extension)) {
                    jsError.innerText = `Unsupported file format: .${extension}. Allowed formats: PDF, Word, Excel, PowerPoint, Text, ZIP, or Images.`;
                    jsError.classList.remove('hidden');
                    resetFileInput();
                    return;
                }
                if (size > maxSizeBytes) {
                    jsError.innerText = `File size (${(size / (1024 * 1024)).toFixed(2)}MB) exceeds the 10MB limit.`;
                    jsError.classList.remove('hidden');
                    resetFileInput();
                    return;
                }
                totalSize += size;
                extensions.push(extension);
                // Add to list UI
                const li = document.createElement('li');
                li.textContent = file.name;
                fileListEl.appendChild(li);
            }

            // Update preview with first file info
            const firstFile = files[0];
            const firstExt = firstFile.name.split('.').pop().toLowerCase();
            previewFilename.innerText = firstFile.name;
            previewFilesize.innerText = `${(totalSize / 1024).toFixed(1)} KB`;

            // Determine icon based on first file type (fallback to generic)
            let icon = '📄';
            if (firstExt === 'pdf') icon = '📕';
            else if (['png', 'jpg', 'jpeg'].includes(firstExt)) icon = '🖼️';
            else if (['doc', 'docx'].includes(firstExt)) icon = '📘';
            else if (['xls', 'xlsx'].includes(firstExt)) icon = '📗';
            else if (['ppt', 'pptx'].includes(firstExt)) icon = '📙';
            else if (firstExt === 'zip') icon = '📦';
            previewIcon.innerText = icon;

            // Show list if multiple files
            if (files.length > 1) {
                fileListEl.classList.remove('hidden');
            }

            // Show preview area and disable dropzone
            fileInfoPreview.classList.remove('hidden');
            dropzone.classList.add('opacity-45', 'pointer-events-none');
        }

        if (cancelUpload) {
            cancelUpload.addEventListener('click', () => {
                resetFileInput();
            });
        }

        function resetFileInput() {
            fileInput.value = '';
            fileInfoPreview.classList.add('hidden');
            if (dropzone) {
                dropzone.classList.remove('opacity-45', 'pointer-events-none');
            }
        }

        // 2. Tab Filter Actions
        function filterType(category) {
            const cards = document.querySelectorAll('.resource-card');
            const tabs = ['all', 'pdf', 'image', 'doc'];
            let countVisible = 0;

            // Update tab styles
            tabs.forEach(tab => {
                const btn = document.getElementById(`tab-${tab}`);
                if (btn) {
                    if (tab === category) {
                        btn.className = "px-3 py-1.5 bg-white text-teal-600 shadow-xs rounded-lg transition";
                    } else {
                        btn.className = "px-3 py-1.5 hover:bg-white/50 rounded-lg transition";
                    }
                }
            });

            // Filter cards
            cards.forEach(card => {
                const cat = card.getAttribute('data-cat');
                if (category === 'all' || cat === category) {
                    card.style.display = 'flex';
                    countVisible++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Toggle placeholder if no matching items
            const placeholder = document.getElementById('filter-empty-placeholder');
            const noResPlaceholder = document.getElementById('no-resources-placeholder');
            
            if (countVisible === 0 && cards.length > 0) {
                // Create editable name input with label showing original filename
                const baseName = file.name.replace(/\.[^.]+$/, '');
                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-center space-x-2 mb-1';
                const label = document.createElement('span');
                label.textContent = file.name; // original name with extension
                label.className = 'text-sm text-slate-600';
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'filenames[]';
                input.value = baseName;
                input.dataset.extension = extension;
                input.className = 'relative z-10 border border-slate-300 rounded px-2 py-1 text-xs w-full';
                // simple validation
                input.addEventListener('input', () => {
                    const val = input.value.trim();
                    if (val === '' || /[\\/:*?\"<>|]/.test(val)) {
                        input.classList.add('border-rose-500');
                    } else {
                        input.classList.remove('border-rose-500');
                    }
                });
                wrapper.appendChild(label);
                wrapper.appendChild(input);
                namesContainer.appendChild(wrapper);{
                    placeholder.classList.add('hidden');
                }
            }
        }

        // 3. Media Preview Modal Control
        const modal = document.getElementById('preview-modal');
        const modalImg = document.getElementById('modal-img');
        const modalTitle = document.getElementById('modal-title');

        function previewImage(url, title) {
            modalImg.src = url;
            modalTitle.innerText = title;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closePreviewModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImg.src = '';
            document.body.classList.remove('overflow-hidden');
        }

                // Close on escape key
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePreviewModal();
            }
        });

        // Delete button handler (opens custom modal)
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Show custom confirmation modal instead of native confirm
                const url = this.dataset.url;
                // Store the URL in a temporary variable for later submission
                window.pendingDeleteUrl = url;
                // Show the modal
                document.getElementById('delete-confirm-modal').classList.remove('hidden');
                document.getElementById('delete-confirm-modal').classList.add('flex');
            });
        });

        function executeDelete() {
            const url = window.pendingDeleteUrl;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = token;
            form.appendChild(tokenInput);
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-lg p-6 w-80">
            <h3 class="text-lg font-semibold mb-4 text-slate-800">Confirm Delete</h3>
            <p class="text-sm text-slate-600 mb-6">Are you sure you want to delete this resource? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="delete-cancel-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Cancel</button>
                <button id="delete-confirm-btn" class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700 transition">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Modal button handlers
        document.getElementById('delete-cancel-btn').addEventListener('click', function() {
            document.getElementById('delete-confirm-modal').classList.add('hidden');
            document.getElementById('delete-confirm-modal').classList.remove('flex');
            window.pendingDeleteUrl = null;
        });

        document.getElementById('delete-confirm-btn').addEventListener('click', function() {
            executeDelete();
        });
    </script>
</x-app-layout>
