<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Project Edit</title>
    <style>
        h1 {
            color: blue;
            width: fit-content;
        }

        label {
            color: blue;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-danger {
            margin-right: 20rem;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <div class="row">
            <div class="col d-flex">
                <a href="{{ route('projects.index') }}" class="btn btn-danger d-flex justify-content-center align-items-center px-5">Go
                    Back</a>
                <h1>Modify Project Detail</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="">
                    
                    @csrf
                    @method('PUT')
                    <div class="form-group">
    <label for="projectName">Rename project</label>
    <input type="text" class="form-control" id="projectName" placeholder="Rename a project" value="{{$project->name}}">
  </div>
  @if ($project->tasks->isNotEmpty())
  <label for="">Project tasks</label>
  

  <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Task name</th>
                            <th>Task status</th>
                            <th>Task actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->tasks as $task)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$task->title}}</td>
                        <td>{{$task->status}}</td>
        <td class="d-flex">
        <a href="{{ url('taskEdit', $task->id) }}" class="btn btn-success d-flex justify-content-center align-items-center px-3 mr-2">Edit</a>
        <a href="{{ url('taskDelete/'.$task->id)}}" onclick="return confirm('Are you want to delete this task?')" class="btn btn-danger d-flex justify-content-center align-items-center px-3 mr-2">Delete</a>
    </td>
                    </tr>
        @endforeach
                    </tbody>
                </table>


  @endif
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>