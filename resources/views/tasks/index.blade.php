@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right">
                @can('task-create')
                    <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create New Task</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered table-striped table-hover table-responsive mt-3">
        <tr>
            <th>No</th>
            <th>Title Name</th>
            <th>User Name</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Documents</th>
            <th width="280px">Action</th>
        </tr>

        @if (!@empty($tasks))
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->deadline }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        @if (!empty($task->document))
                            <a class="btn btn-info" href="document/{{ $task->document }}">Document Show</a>
                        @else
                            <a class="btn btn-info" href="#">No Document</a>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @can('task-edit')
                                <a class="btn btn-primary" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                            @endcan
                            @csrf
                            @method('DELETE')
                            @can('task-delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>


    {!! $tasks->links() !!}
@endsection
