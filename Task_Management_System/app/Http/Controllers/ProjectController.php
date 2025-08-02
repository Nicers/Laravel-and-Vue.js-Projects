<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('projectDetail', ['projects' => ProjectResource::collection(Project::simplePaginate(3))]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createProject');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Project::create([
            'name' => $request->name
        ]);
        return back()->with('message', 'Project Create Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('editProject', ['project' => new ProjectResource(Project::findOrFail($id))]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Project::destroy($id);
        return back()->with('message', 'Project deleted Successfully!');
    }
}
