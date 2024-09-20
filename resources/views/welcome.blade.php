<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
<h1 class="text-center mt-5">Welcome to Laravel with Bootstrap</h1>
<p class="text-center">This is a sample text using Bootstrap styling.</p>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Another Card title</h5>
                <p class="card-text">Some more example text to build on the card title and make up the bulk of the
                    card's content.</p>
                <a href="#" class="btn btn-secondary">Go somewhere else</a>
            </div>
        </div>
    </div>
</div>
@endsection