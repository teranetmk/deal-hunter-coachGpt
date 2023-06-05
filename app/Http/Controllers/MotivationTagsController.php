<?php

namespace App\Http\Controllers;

use App\Models\MotivationTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MotivationTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string[]
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tagName' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $existingTags = MotivationTags::where('tag_name', $request->tagName)
            ->where('userid', $user->id)->get();
        if (count($existingTags) > 0) {
            return ["status" => "error", "message" => "A tag with that name already exists"];
        }
        MotivationTags::create(['tag_name' => $request->tagName, 'userid' => $user->id, 'tag_type' => 'user']);
        $allTags = $this->getAllAvailableTagsForUser($user->id);
        return ["status" => "success", "message" => "New Motivation Tag '{$request->tagName}' created", 'allTags' => $allTags];
    }

    public function getAllAvailableTagsForUser($userid)
    {
        return MotivationTags::where('tag_type', 'admin')
            ->orWhere('userid', $userid)
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MotivationTags $motivationTags
     * @return \Illuminate\Http\Response
     */
    public function show(MotivationTags $motivationTags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\MotivationTags $motivationTags
     * @return \Illuminate\Http\Response
     */
    public function edit(MotivationTags $motivationTags)
    {
        //

    }

    public function updateTag(Request $request)
    {
        $request->validate([
            'tagName' => 'required|string|max:255',
            'tagId'   => 'integer|required'
        ]);

        $user = Auth::user();
        $tagRow = MotivationTags::where('id', $request->tagId)->where('userid', $user->id)->first();
        if (empty($tagRow)) {
            return ['status' => 'error', 'message' => 'The requested tag does not exist'];
        }
        DB::update('update motivation_tags set tag_name=? where id=?', [$request->tagName, $request->tagId]);
        $allTags = $this->getAllAvailableTagsForUser($user->id);
        return ['status' => 'success', 'Tag Successfully Edited', 'allTags' => $allTags];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MotivationTags $motivationTags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MotivationTags $motivationTags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MotivationTags $motivationTags
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotivationTags $motivationTags)
    {

    }

    public function deleteTag(Request $request)
    {
        $user = Auth::user();
        $tagId = $request->tagId;
        if (empty($tagId) || !is_numeric($tagId) || $tagId < 1) {
            return ['status' => 'error', 'message' => 'Tag Id is required'];
        }
        DB::delete('DELETE FROM motivation_tags WHERE id = ? and userid=?', [$tagId, $user->id]);
        $allTags = $this->getAllAvailableTagsForUser($user->id);
        return ['status' => 'success', 'message' => 'Successfully deleted', 'allTags' => $allTags];
    }
}
