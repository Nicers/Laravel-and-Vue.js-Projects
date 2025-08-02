<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Project Detail</title>
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
                <a href="{{ url('/') }}" class="btn btn-danger d-flex justify-content-center align-items-center px-5">Go
                    Back</a>
                <h1>Projects Detail</h1>
            </div>
        </div>
    </div>

    @if (Session::has('message'))
    <div class="alert d-flex align-items-center justify-content-center bg-success text-white fw-bold px-4 py-1 w-25 m-auto my-5">
      <p>{{Session::get('message')}}</p>
    </div>
  @endif


    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Tasks</th>
                            <th>Project Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{ $project->name }}</td>
                        @if ($project->tasks->isNotEmpty())
                        <td>
                        <select id="task" name="task"
            class="form-control">
            @foreach ($project->tasks as $task)
            <option value="">{{$task->title}} ({{$task->status}})</option>
            @endforeach
          </select>
        </td>
        @else
        <td>No tasks created</td>
        @endif
        <td class="d-flex">
        <a href="{{ url('projectEdit', $project->id) }}" class="btn btn-success d-flex justify-content-center align-items-center px-3 mr-2">Edit</a>
        <a href="{{ url('projectDelete/'.$project->id) }}" class="btn btn-danger d-flex justify-content-center align-items-center px-3">Delete</a>
        </td>
                    </tr>
        @endforeach
                    </tbody>
                </table>
                {{$projects->links()}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>