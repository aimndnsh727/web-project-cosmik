<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyGroupController extends Controller
{
    /**
     * MEMBER 3: Renders Interactive Dashboard.
     * Coordinates analytics data, user-led groups, and joined groups.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Fetch led groups using model scopes
        $ledGroups = StudyGroup::ledBy($userId)
            ->withCount('members')
            ->orderBy('session_date', 'asc')
            ->get();

        // 2. Fetch joined groups using model scopes
        $joinedGroups = StudyGroup::joinedBy($userId)
            ->with('leader')
            ->withCount('members')
            ->orderBy('session_date', 'asc')
            ->get();

        // 3. Analytics parameters
        $totalGroupsCount = StudyGroup::count();
        $ledCount = $ledGroups->count();
        $joinedCount = $joinedGroups->count();

        // 4. Mock request for approval visual feedback (aligns with project documentation)
        $pendingRequests = [
            (object)[
                'id' => 1,
                'sender_name' => 'Ahmad Nur Adam',
                'matric_number' => '2414137',
                'group_title' => 'Web Application Development BIIT 2305',
                'expertise_area' => 'Tailwind, Blade template engines',
                'message' => 'Assalamualaikum, can I join? I can assist with layout styling using tailwind.'
            ]
        ];

        return view('dashboard', compact(
            'ledGroups',
            'joinedGroups',
            'ledCount',
            'joinedCount',
            'totalGroupsCount',
            'pendingRequests'
        ));
    }

    /**
     * MEMBER 3: Find Study Groups and advanced multi-input filtering search.
     */
    public function index(Request $request)
    {
        // Apply Search query scopes dynamically
        $groups = StudyGroup::with('leader')
            ->withCount('members')
            ->searchBySubject($request->input('subj_code'))
            ->searchByTitle($request->input('title'))
            ->searchByDate($request->input('session_date'))
            ->orderBy('session_date', 'asc')
            ->get();

        // Keep search state values for UI rendering inputs
        $searchedSubject = $request->input('subj_code');
        $searchedTitle = $request->input('title');
        $searchedDate = $request->input('session_date');

        return view('groups.index', compact('groups', 'searchedSubject', 'searchedTitle', 'searchedDate'));
    }

    /**
     * Show study group details and resource repository.
     */
    public function show(StudyGroup $group)
    {
        $userId = Auth::id();

        // Check if user is leader or member
        $isLeader = $group->leader_id === $userId;
        $isMember = $group->members()->where('user_id', $userId)->exists();

        // Load relationships
        $group->load(['leader', 'members', 'resources.uploader']);

        return view('groups.show', compact('group', 'isLeader', 'isMember'));
    // =================================================
    // MEMBER 2 CORE LOGIC: STUDY GROUP CRUD OPERATIONS
    // =================================================

    // Show the form for creating a new study group
    public function create()
    {
        return view('study_groups.create');
    }

    // Store a newly created study group in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'subj_code'     => 'required|string|max:50',
            'description'   => 'nullable|string',
            'venue'         => 'required|string|max:255',
            'session_date'  => 'required|date',
            'session_time'  => 'required',
        ]);

        $validated['leader_id'] = Auth::id();

        StudyGroup::create($validated);

        return redirect()->route('dashboard')->with('success', 'Study group created successfully!');
    }

    // Show the form for editing the specified study group.

    public function edit(StudyGroup $studyGroup)
    {
        // Ensure only the leader can edit the group
        if ($studyGroup->leader_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('study_groups.edit', compact('studyGroup'));
    }

    // Updated the specified study group in the database

    public function update(Request $request, StudyGroup $studyGroup)
    {
        // Ensure only the leader can update the group
        if ($studyGroup->leader_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'subj_code'     => 'required|string|max:50',
            'description'   => 'nullable|string',
            'venue'         => 'required|string|max:255',
            'session_date'  => 'required|date',
            'session_time'  => 'required',
        ]);

        $studyGroup->update($validated);

        return redirect()->route('dashboard')->with('success', 'Study group updated successfully!');
    }

    // remove the specified study group from the database
    public function destroy(StudyGroup $studyGroup)
    {
        // Ensure only the leader can delete the group
        if ($studyGroup->leader_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $studyGroup->delete();

        return redirect()->route('dashboard')->with('success', 'Study group deleted successfully!');
    }
}