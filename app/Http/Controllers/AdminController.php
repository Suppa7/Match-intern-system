<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\ImageReview;
use App\Models\ReportedReview;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    public function report()
    {
        $report = ReportedReview::all();
        return view('admin.report',compact('report'));
    }

    public function user()
    {
        $user = User::query()->where('role','user')->orderBy('id')->paginate(10);
        return view('admin.user_manage',compact('user'));
    }

    public function user_edit($id)
    {
        $user = User::query()->find($id);
        return view('admin.user_edit',compact('user','id'));
    }

    public function user_update(StoreUpdateUserRequest $request,$id)
    {
        $user = User::query()->find($id);
        $validated = $request->validated();
        $user->update([
            'name' => $validated['name'],
            'student_id' => $validated['student_id']
        ]);
        return redirect()->route('admin.user');
    }
    public function user_destroy($id)
    {
        $user = User::query()->find($id);
        $user->delete();
        return back();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::query()->find($id);
        $images = ImageReview::query()->where('review_id', $review->id)->get();
        return view('admin.show',compact('review','images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete_review($id)
    {
        $review = Review::find($id);
        $review->delete();
        return redirect()->route('admin.report');
    }
}
