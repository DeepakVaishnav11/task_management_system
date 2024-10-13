<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->get()->toArray();
        return view('tasks',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        $data = array('title'=>'Add Tasks');
        $users = User::with('role')->get()->toArray();
        return view('add-tasks',compact('data','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,completed',
            'user_id' => 'required|integer|exists:users,id', // Ensure the user exists in the users table
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Acceptable file types and size limit
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }
         // Create a new task
        $task = new Task();
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->priority = $validatedData['priority'];
        $task->deadline = $validatedData['deadline'];
        $task->status = $validatedData['status'];
        $task->user_id = $validatedData['user_id'];
        $task->document = $documentPath;

        // Save the task to the database
        $task->save();

        // Redirect to a specific route or return a success message
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the task by ID
        $task = Task::findOrFail($id); // This will throw a 404 if the task is not found
        $users = User::all();
        $data = array();
        $data = array('title'=>'Edit Tasks');

        // Pass the task data to the view
        return view('add-tasks', compact('task','data','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // Find the task by ID
        $task = Task::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,completed',
            'user_id' => 'required|integer|exists:users,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

         // Handle the document upload
        if ($request->hasFile('document')) {
            // If a document exists, delete the old one
        if ($task->document) {
            Storage::disk('public')->delete('documents/' . $task->document);
        }

        // Store the new document and save the path
        $documentPath = $request->file('document')->store('documents', 'public');
        $validatedData['document'] = $documentPath;
    }
    
        // Update the task with new data
        $task->update($validatedData);

        // Redirect back to the task index or show success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the task by ID and delete it
        $task = Task::findOrFail($id); // This will throw a 404 error if the task is not found

        // Delete the task
        $task->delete();

        // Redirect back to the task index with a success message
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
