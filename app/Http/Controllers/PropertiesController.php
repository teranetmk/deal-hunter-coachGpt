<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;

class PropertiesController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function show(Properties $properties)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function edit(Properties $properties)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Properties $properties)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function destroy(Properties $properties)
    {
        //
    }

    public function leasUpdate(Request $request, $id)  {
        $updatedProperty = Properties::where('id', $id)->update([
            'PropertyAddress'   => $request["data"]["PropertyAddress"] ,
            'PropertyCity'      => $request["data"]["PropertyCity"] ,
            'PropertyState'     => $request["data"]["PropertyState"] ,
            'PropertyZipCode'   => $request["data"]["PropertyZipCode"] ,
            // 'OwnerName'         => $request["data"]["OwnerName"] ,
            'OwnerEmailAddress' => $request["data"]["OwnerEmailAddress"] ,
            'OwnerPhoneNumber'  => $request["data"]["OwnerPhoneNumber"] ,
            'MailingAddress'    => $request["data"]["MailingAddress"] ,
            'MailingCity'       => $request["data"]["MailingCity"] ,
            'MailingState'      => $request["data"]["MailingState"] ,
            'MailingZipCode'    => $request["data"]["MailingZipCode"] ,
            'insta_offer'    => $request["data"]["insta_offer"] ,
            'insta_price'    => $request["data"]["insta_price"] ,
        ]);
        return response()->json(["status" => "success", "message" => "Data updated.", "property" => Properties::find($id)]);
    }
}
