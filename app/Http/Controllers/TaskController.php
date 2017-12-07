<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GET all stored tasks from DB
        $storedTasks = Task::orderBy('id', 'asc')->paginate(5);

        // Route: host/tasks
        return view('tasks.index')->with('storedTasks', $storedTasks);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate input
        $this->validate($request, [
            'taskName' => 'required|min:5|max:255'
        ]);
        
        // store data to table
        $task = new Task();
        $task->name = $request->taskName;

        // save data to DB
        $task->save();
        
        // Success Flash Message
        Session::flash('success', 'The Task added succesfully');

        // Redirect after submit
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the task
        $task = Task::find($id);

        return view('tasks.edit')->with('currentTask', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate input
        $this->validate($request, [
            'updatedName' => 'required|min:5|max:255'
        ]);

        $task = Task::find($id);

        $task->name = $request->updatedName;

        // save data to DB
        $task->save();
        
        // Success Flash Message
        Session::flash('success', 'The Task No. #' . $id . ' Updated succesfully');

        // Redirect after submit
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get task
        $task = Task::find($id);

        // Delete task
        $task->delete();

        // Success Flash Message
        Session::flash('success', 'The Task No. #' . $id . ' DELETED succesfully');

        // Redirect after submit
        return redirect('/tasks');
    }
}
