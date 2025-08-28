<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function index(Project $project)
    {
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
            return response()->json(['message' => 'Invalid passcode'], 403);
        }

        $feedback->update([
            'developer_response' => $request->developer_response,
            'status' => $request->status,
        ]);

        return response()->json($feedback, 200);
    }
}