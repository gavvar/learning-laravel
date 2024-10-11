<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Categories</title>
</head>

<body class="container mt-5">
    <h1 class="mb-4">Category List</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
    <ul class="list-group">
        @foreach ($categories as $category)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $category->name }}
            <div>
                <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
</body>

</html>