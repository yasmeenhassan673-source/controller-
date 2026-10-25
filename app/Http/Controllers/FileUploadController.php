<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Show the file upload form.
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Handle incoming file upload from an HTML form.
     */
    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // Max 10MB
                // Optional: to restrict to HTML files only, add: 'mimes:html,htm'
            ],
        ], [
            'file.required' => 'Please select a file to upload.',
            'file.file' => 'The uploaded item must be a valid file.',
            'file.max' => 'The file size cannot exceed 10MB.',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');

            // File metadata
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            // Create a safe, unique filename to prevent collisions or overwriting
            $safeBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $fileName = time() . '_' . $safeBaseName . '.' . $extension;

            // Store in storage/app/public/uploads
            $path = $file->storeAs('uploads', $fileName, 'public');

            // Generate public URL
            $fileUrl = Storage::url($path);

            // Return JSON response if the request was made via Fetch/AJAX
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded successfully!',
                    'file' => [
                        'name' => $originalName,
                        'stored_name' => $fileName,
                        'path' => $path,
                        'url' => asset($fileUrl),
                        'size' => $fileSize,
                        'extension' => $extension,
                    ],
                ], 200);
            }

            // Redirect back with flash data for standard HTML form submissions
            return back()
                ->with('success', 'File uploaded successfully!')
                ->with('fileName', $originalName)
                ->with('fileUrl', asset($fileUrl));
        }

        return back()->withErrors(['file' => 'Failed to upload the file. Please try again.']);
    }
}

