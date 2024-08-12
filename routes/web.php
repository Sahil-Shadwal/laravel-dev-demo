<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;




Route::get('/', function () {

    return view('home');
});

//Index
Route::get('/jobs', function () {

    $jobs = Job::with('employer')->latest()->simplePaginate(10);
    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

//Create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

//Show
Route::get('/jobs/{job}', function ($id) {
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

//Store
Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});

//Edit
Route::get('/jobs/{job}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

//Update
Route::patch('/jobs/{job}', function ($id) {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    $job = Job::findOrFail($id);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    return redirect('/jobs/' . $job->id);
});

//Destroy
Route::delete('/jobs/{job}', function ($id) {

    Job::findOrFail($id)->delete();

    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
