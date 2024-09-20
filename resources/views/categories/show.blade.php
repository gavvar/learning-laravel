@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<h1 class="mb-4">Category Details</h1>
<p><strong>Name:</strong> {{ $category->name }}</p>
<a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
@endsection