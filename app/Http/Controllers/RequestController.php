<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\JoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    // Submit a request to join a group
    public function sendRequest(Request $request, $groupId)
    {
        $group = StudyGroup::findOrFail($groupId);
        
        // Safety check: Avoid duplicating membership
        if ($group->members()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You are already a member of this group.');
        }

        // Safety check: Avoid duplicate pending requests
        $existingRequest = JoinRequest::where('user_id', Auth::id())
            ->where('study_group_id', $groupId)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending request for this group.');
        }

        JoinRequest::create([
            'user_id' => Auth::id(),
            'study_group_id' => $groupId,
            'status' => 'pending',
            'message' => $request->input('message')
        ]);

        return back()->with('success', 'Join request sent successfully!');
    }

    // Approve an applicant request
    public function approve(JoinRequest $joinRequest)
    {
        $group = StudyGroup::findOrFail($joinRequest->study_group_id);
        
        // Attach user to pivot table if not already attached
        if (!$group->members()->where('user_id', $joinRequest->user_id)->exists()) {
            $group->members()->attach($joinRequest->user_id, ['role' => 'member']);
        }

        // Change status to approved
        $joinRequest->update(['status' => 'approved']);

        return back()->with('success', 'Request approved successfully!');
    }

    // Decline an applicant request
    public function decline(JoinRequest $joinRequest)
    {
        $joinRequest->update(['status' => 'declined']);
        
        return back()->with('success', 'Request declined.');
    }
}
