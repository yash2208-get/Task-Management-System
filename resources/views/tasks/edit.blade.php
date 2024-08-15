@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Task</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tasks.update', $task->id) }}" enctype="multipart/form-data">
        @csrf

        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Title Name:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Title Name"
                        value="{{ $task->title }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $task->description }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Priority:</strong>
                    <select name="priority" id="" class="form-control">
                        <option value="low" @if ($task->priority == 'low') selected @endif>Low</option>
                        <option value="medium" @if ($task->priority == 'medium') selected @endif>Medium</option>
                        <option value="high" @if ($task->priority == 'high') selected @endif>High</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Deadline:</strong>
                    <input type="date" name="deadline" class="form-control" placeholder="Deadline"
                        value="{{ $task->deadline }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Documents:</strong>
                    <input type="file" name="document" class="form-control" accept="image/*,.pdf" multiple="multiple">
                    @if ($task->document != null)
                        <a class="btn" href="{{ env('APP_URL') }}/document/{{ $task->document }}">Document Show</a>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>status:</strong>
                    <select name="status" id="" class="form-control">
                        <option value="pending" @if ($task->status == 'pending') selected @endif>Pending</option>
                        <option value="working" @if ($task->status == 'working') selected @endif>Working</option>
                        <option value="completed" @if ($task->status == 'completed') selected @endif>Completed</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>


@endsection
