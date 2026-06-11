<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\StudyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudyResourceController extends Controller
{
    /**
     * Store a newly uploaded study resource in storage.
     */
    public function store(Request $request, StudyGroup $group)
    {
        // 1. Authorize: User must be a member or the leader of the study group
        $userId = Auth::id();
        $isMember = $group->members()->where('user_id', $userId)->exists();
        $isLeader = $group->leader_id === $userId;

        if (!$isMember && !$isLeader) {
            return back()->with('error', 'You must be a member of this study group to upload resources.');
        }

        // 2. Validate the request to accept multiple files
        $request->validate([
            'files' => ['required'],
            'files.*' => [
                'file',
                'max:10240', // Max 10MB per file
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg,txt,zip',
            ],
        ], [
            'files.required' => 'Please select at least one file to upload.',
            'files.*.max' => 'Each file must not exceed 10MB.',
            'files.*.mimes' => 'Unsupported file format. Allowed types: PDF, Word, Excel, PowerPoint, Text, ZIP, or Images (PNG/JPG).',
        ]);

        // 3. Process each uploaded file
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filenames = $request->input('filenames');

            foreach ($files as $index => $uploadedFile) {
                if (!$uploadedFile->isValid()) {
                    continue; // skip invalid files
                }
                 // Check if the specific index exists and isn't empty, otherwise fall back to native name
                $originalName = (!empty($filenames[$index])) ? $filenames[$index] : $uploadedFile->getClientOriginalName();
                $extension = strtolower($uploadedFile->getClientOriginalExtension());
                
                // Ensure extension is preserved or added
                if (!str_ends_with(strtolower($originalName), '.' . $extension)) {
                    $originalName .= '.' . $extension;
                }

                $size = $uploadedFile->getSize();

                // Store the file in the public resources folder
                $path = $uploadedFile->store('resources', 'public');

                // 4. Create a resource record for this file
                StudyResource::create([
                    'study_group_id' => $group->id,
                    'user_id' => $userId,
                    'file_name' => $originalName,
                    'file_path' => $path,
                    'file_type' => $extension,
                    'file_size' => $size,
                ]);
            }
            return back()->with('success', 'Resources uploaded successfully!');
        }

        return back()->with('error', 'No valid files were uploaded.');
    }

    /**
     * Download the specified resource.
     */
    /**
     * Download the specified resource.
     */
    public function download(StudyResource $resource)
    {
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($resource->file_path)) {
            abort(404, 'File not found in storage.');
        }

        // Force a safe file download response
        return Storage::disk('public')->download($resource->file_path, $resource->file_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyResource $resource)
    {
        $userId = Auth::id();
        // 1. Authorize: Only the uploader or the group leader can delete the resource
        $isUploader = $resource->user_id === $userId;
        $isLeader = $resource->studyGroup && $resource->studyGroup->leader_id === $userId;
        if (!($isUploader || $isLeader)) {
            abort(403, 'Unauthorized action. Only the uploader or group leader can delete this resource.');
        }

        // 2. Delete the physical file from storage
        if (Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }

        // 3. Delete database record
        $resource->delete();

        return back()->with('success', 'Resource deleted successfully.');
    }
}
