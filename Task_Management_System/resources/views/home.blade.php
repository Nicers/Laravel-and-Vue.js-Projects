<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
</head>
<body>
<h1 class="text-blue-700 text-center text-4xl font-bold py-4">Task Management System</h1>
<div class="container flex justify-center gap-5 py-10">
    <a href="{{route('projects.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded">Projects Detail</a>
    <a href="{{route('tasks.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded">Tasks Detail</a>
    <a href="{{route('projects.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded">Create Project</a>
    <a href="{{route('tasks.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded">Create Task</a>
</div>

</body>
</html>