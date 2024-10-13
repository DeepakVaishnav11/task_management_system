<x-app-layout>
    <x-slot name="header">
        <div class="d-flex" style="justify-content: space-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $data['title'] }}
            </h2>
        </div>
    </x-slot>
    <!-- Display Validation Errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($task))
                        @method('PUT')
                        <!-- For updating an existing task -->
                        @endif

                        <div class="mb-3 row">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ isset($task) ? $task->title : old('title') }}"
                                    placeholder="Enter task title" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" id="description"
                                    placeholder="Enter task description"
                                    required>{{ isset($task) ? $task->description : old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                            <div class="col-sm-10">
                                <select name="priority" class="form-control" id="priority" required>
                                    <option value="low"
                                        {{ (isset($task) && $task->priority == 'low') ? 'selected' : '' }}>Low</option>
                                    <option value="medium"
                                        {{ (isset($task) && $task->priority == 'medium') ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="high"
                                        {{ (isset($task) && $task->priority == 'high') ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="deadline" class="col-sm-2 col-form-label">Deadline</label>
                            <div class="col-sm-10">
                                <input type="date" name="deadline" class="form-control" id="deadline"
                                    value="{{ isset($task) ? $task->deadline : old('deadline') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control" id="status" required>
                                    <option value="pending"
                                        {{ (isset($task) && $task->status == 'pending') ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="completed"
                                        {{ (isset($task) && $task->status == 'completed') ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="user_id" class="col-sm-2 col-form-label">Assigned User</label>
                            <div class="col-sm-10">
                                <select name="user_id" class="form-control" id="user_id" required>
                                    <option value="" disabled>Select a user</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user['id']}}"
                                        {{ (isset($task) && $task->user_id == $user['id']) ? 'selected' : '' }}>
                                        {{ $user['name'] }} ({{ $user['role']['name'] }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="document" class="col-sm-2 col-form-label">Task Document</label>
                            <div class="col-sm-10">
                                <input type="file" name="document" class="form-control" id="document">
                                @if(isset($task) && $task->document)
                                <p>Current Document: <a href="{{ Storage::url($task->document) }}"
                                        target="_blank">View Document</a></p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($task) ? 'Update Task' : 'Create Task' }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>