<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Task</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
</head>

<body class="bg-blue-100">
  <div class="container">
    @if (Session::has('message'))
    <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 w-[40%] m-auto mt-20"
      role="alert">
      <p>{{Session::get('message')}}</p>
    </div>
  @endif
  </div>


  <div class="container flex justify-center pt-20">
    <div class="w-full max-w-xs">
    <a href="{{route('tasks.index')}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-5 rounded">Go back</a>
      <form action="{{ route('tasks.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 my-4">
        @csrf
        <h1 class="font-bold text-2xl mb-8 text-blue-600">Create Project Task</h1>
        <div class="mb-6">
          <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
            project</label>
          <select id="countries" name="project"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">Choose a Project</option>
            @foreach ($projects as $project)
        <option value="{{$project->id}}">{{$project->name}}</option>
      @endforeach
          </select>
          @error('project')
        <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
        <p class="text-sm">{{ $message }}</p>
        </div>
      @enderror
        </div>
        <div class="mb-6">
          <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task title</label>
          <input type="text" name="task" id="tasks"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
          @error('task')
        <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
        <p class="text-sm">{{ $message }}</p>
        </div>
      @enderror
        </div>
        <div class="mb-6">
          <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task
            status</label>
          <select id="countries" name="status"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">Choose a status</option>
            <option value="incomplete">Incomplete</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
          @error('status')
        <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
        <p class="text-sm">{{ $message }}</p>
        </div>
      @enderror
        </div>
        <div class="flex items-center justify-between">
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Create Task
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>