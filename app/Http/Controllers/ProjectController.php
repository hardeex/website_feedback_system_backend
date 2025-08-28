<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('feedbacks')->get(); 
    }

    public function show(Project $project)
    {
        return $project->load('feedbacks'); 
    }
}