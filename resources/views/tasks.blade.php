<x-app-layout>
    <x-slot name="header">
        <div class="d-flex" style="justify-content: space-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('All Tasks') }}
            </h2>
            <a href="{{route('tasks.create')}}" class="btn btn-primary"> + Add Tasks</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-borderd table-striped" width="100%" cellpadding="5px">
                        <tbody>
                            <tr>
                                <td>Sr.No.</td>
                                <td>title</td>
                                <td>description</td>
                                <td>priority</td>
                                <td>deadline</td>
                                <td>status</td>
                                <td>User</td>
                                <td>Document</td>
                                <td>Action</td>
                            </tr>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task['title'] }}</td>
                                <td>{{ $task['description'] }}</td>
                                <td>{{ $task['priority'] }}</td>
                                <td>{{ $task['deadline'] }}</td>
                                <td>{{ $task['status'] }}</td>
                                <td>{{ $task['user']['name'] }}</td>
                                <td>
                                    @if($task['document'])
                                    <a href="{{ Storage::url($task['document']) }}" target="_blank">View
                                        Document</a>
                                    @else
                                    No document
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tasks.edit', $task['id']) }}"><i class="fa fa-edit"></i></a>
                                    <!-- Delete Form -->
                                    <form action="{{ route('tasks.destroy', $task['id']) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this task?');">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            <tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>