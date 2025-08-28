<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $feedback = $project->feedbacks()->create([
            'comment' => $request->comment,
            'rating' => $request->rating,
            'user_id' => null, // No authentication for regular feedback
        ]);

        return response()->json($feedback, 201);
    }

    public function index(Request $request, Project $project)
    {
        // Log passcode configuration for debugging
        Log::debug('Feedback fetch attempt', [
            'passcode_config' => config('api.developer_passcode'),
            'has_passcode_header' => $request->hasHeader('X-Developer-Passcode'),
            'header_passcode' => $request->header('X-Developer-Passcode')
        ]);

        // Check for developer passcode if provided
        if ($request->hasHeader('X-Developer-Passcode')) {
            $passcode = $request->header('X-Developer-Passcode');
            $expectedPasscode = config('api.developer_passcode');
            if ($passcode !== $expectedPasscode) {
                Log::warning('Invalid passcode for feedback fetch', [
                    'passcode' => $passcode,
                    'expected' => $expectedPasscode
                ]);
                return response()->json(['message' => 'Invalid passcode'], 403);
            }
            Log::info('Developer passcode validated for feedback fetch', ['passcode' => $passcode]);
        }

        return $project->feedbacks()->paginate(10); // Paginated feedback
    }

    public function updateDeveloperResponse(Request $request, Feedback $feedback)
    {
        $validator = Validator::make($request->all(), [
            'developer_response' => 'nullable|string|max:1000',
            'status' => 'required|in:Not Started,In Progress,Fixed',
            'passcode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->passcode !== config('api.developer_passcode')) {
            Log::warning('Invalid passcode for response update', [
                'passcode' => $request->passcode,
                'expected' => config('api.developer_passcode')
            ]);
            return response()->json(['message' => 'Invalid passcode'], 403);
        }

        $feedback->update([
            'developer_response' => $request->developer_response,
            'status' => $request->status,
        ]);

        return response()->json($feedback, 200);
    }
}