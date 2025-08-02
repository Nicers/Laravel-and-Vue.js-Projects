<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Tasks Detail</title>
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
                <h1>Tasks Detail</h1>
            </div>
        </div>
    </div>

    @if (Session::has('message'))
        <div
            class="alert d-flex align-items-center justify-content-center bg-success text-white fw-bold px-4 py-1 w-25 m-auto my-5">
            <p>{{Session::get('message')}}</p>
        </div>
    @endif


    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <div class="d-flex flex-column">
                    <form action="{{route('filterTask')}}" method="POST" class="form-inline py-3 my-lg-0">
                        @csrf
                        <input class="form-control mr-sm-2 w-50" name="search" type="search"
                            placeholder="Search task by status" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    @error('search')
                        <div
                            class="alert-danger d-flex align-items-center justify-content-center fw-bold px-4 w-25 mb-3">
                            <p>{{$message}}</p>
                        </div>
                    @enderror
                </div>


                @if (!empty(Session::has('filterTask')))
                <div class="d-flex justify-content-between">
                <h1>Filtered Task</h1>
                <button onclick="return Confirm('Are you want to remove filter tasks list?')" class="btn btn-danger d-flex justify-content-center align-items-center px-3 mr-2">Remove</button>
                </div>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Task Status</th>
                            <th>Project Name</th>
                            <th>Project Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Session::get('filterTask') as $task)
                            <tr>
                                <th scope="row">{{$loop->index + 1}}</th>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->status }}</td>
                                <td>{{ $task->project->name }}</td>
                                <td class="d-flex">
                                    <a href="{{ url('taskEdit', $task->id) }}"
                                        class="btn btn-success d-flex justify-content-center align-items-center px-3 mr-2">Edit</a>
                                    <a href="{{ url('taskDelete/' . $task->id)}}"
                                        onclick="return confirm('Are you want to delete this task?')"
                                        class="btn btn-danger d-flex justify-content-center align-items-center px-3 mr-2">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br><br><br><h1>Original List Of Task</h1>
    @endif


                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Task Status</th>
                            <th>Project Name</th>
                            <th>Project Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <th scope="row">{{$loop->index + 1}}</th>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->status }}</td>
                                <td>{{ $task->project->name }}</td>
                                <td class="d-flex">
                                    <a href="{{ url('taskEdit', $task->id) }}"
                                        class="btn btn-success d-flex justify-content-center align-items-center px-3 mr-2">Edit</a>
                                    <a href="{{ url('taskDelete/' . $task->id)}}"
                                        onclick="return confirm('Are you want to delete this task?')"
                                        class="btn btn-danger d-flex justify-content-center align-items-center px-3 mr-2">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tasks->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>