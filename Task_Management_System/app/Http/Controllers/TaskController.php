<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Laravel\Prompts\Output\ConsoleOutput;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return TaskResource::collection(Task::paginate(3));
        return view('taskDetail', ['tasks' => TaskResource::collection(Task::simplePaginate(3))]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = ProjectResource::collection(Project::all());
        return view('createTask', compact('projects'));
    }

    public function filterTask(Request $request){
        $request->validate([
            'search'=> 'required'
        ]);
        
        // if(Task::orderBy('status')->where('status', '=', $request->search)->get() != []){
        //     $filterTasks = Task::orderBy('status')->where('status', '=', $request->search)->get() ;
        // }else{
        //     $filterTask = Task::where('title', '=', $request->search)->get() ;
        // }

        $filterTasks = Task::orderBy('status')->where('status', '=', $request->search)->get();
        return back()->with('filterTask', $filterTasks);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project' => 'required',
            'task' => 'required',
            'status' => 'required',
        ]);
        $taskCreate = Task::create([
            'project_id' => $request->project,
            'title' => $request->task,
            'status' => $request->status,
        ]);
        if($taskCreate){
            return back()->with('message', 'Task Created Successfully!');
        }else{
            return back()->with('message', 'Task Not Created!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('editTask', ['task' => new TaskResource(Task::findOrFail($id))]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task'=>'required'
        ]);
        $taskUpdate = Task::where('id','=',$id)->update(['title' => $request->task, 'status' => $request->status,]);
        if($taskUpdate){
            return back()->with('message', 'Task updated Successfully!');
        }
        else{
            return back()->with('message', 'Task not updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::destroy($id);
        return back()->with('message', 'Task deleted Successfully!');
    }
}
