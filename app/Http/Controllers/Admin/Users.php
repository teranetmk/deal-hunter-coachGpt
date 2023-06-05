<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {

        $allUsers = User::all();
        return Inertia::render('Admin/Users', ["users" => $allUsers]);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|string|email|max:255|unique:' . User::class,
            'phone'              => 'required|string|',
            'phone_country_code' => 'required|string',
            'password'           => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'phone_country_code' => $request->phone_country_code,
            'password'           => Hash::make($request->password),
        ]);

        event(new Registered($user));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $userId = $request->id;
        $userLists = Lists::where('userid', $userId)->get();
        $listIds = [];
        foreach ($userLists as $list) {
            $listIds[] = $list->id;
        }
        if (count($listIds) > 0) {
            DB::delete('delete from lists_tags_assocs where list_id in ?', ["(" . implode(", ", $listIds) . ")"]);
            DB::delete('delete from lists_properties_assocs where list_id in ?', ["(" . implode(", ", $listIds) . ")"]);
            Lists::destroy($listIds);
        }

        Properties::where('userid', $userId)->delete();

        User::destroy([$userId]);
    }

    public function updateUnlock(Request $request){
        User::where('id', $request->id)->update(['is_premium'=> $request->status]);
    }

    public function updateCredit(Request $request){
        $user = User::find($request->id);
        $user->total_credits = $user->total_credits + $request->amount;
        $user->save();
    }
}
