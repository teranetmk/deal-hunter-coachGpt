<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CashBuyer;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
use App\Imports\CashBuyersImport;

class CashBuyerController extends Controller
{

    public function saveCashBuyer(Request $request)
    {
        $ADMIN_USER_IDS = [1];
        $user = Auth::user();
        // $this->validate($request, [
        //     'profile_pic' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        // ]);

        $extensions = [
            'image/png' => '.png',
            'image/jpeg' => '.jpeg'
        ];

        $profile_pic = null;
        if(!empty($request->profile_pic)){
            $interventionImg = Image::make($request->file('profile_pic'));
            $profile_pic = 'profile_pic_'.time().$extensions[$interventionImg->mime()];
            $interventionImg->save(public_path('uploads').'/'.$profile_pic);
            $image = $request->file('profile_pic');
            $input['file'] = time().'.'.$image->getClientOriginalExtension();
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'profile_pic' => $profile_pic,
            'email' => $request->email,
            'contact_no' => $request->contact_no ?? null,
            'min_price_range' => $request->min_price_range,
            'max_price_range' => $request->max_price_range,
            'min_profit_deal' => $request->min_profit_deal,
            'state' => $request->state,
            'city' => $request->city,
            'zip' => $request->zip,
            'property_type' => $request->property_type,
            'beds' => $request->beds,
            'baths' => $request->baths,
            'user_id' => $user->id,
        ];

        if (in_array($user->id, $ADMIN_USER_IDS, true)) {
            CashBuyer::create($data);
            return redirect()->route('cash.buyers');
        } else {
            $result = array_filter($data);
            CashBuyer::updateOrCreate(['user_id' => $user->id],$result);
            return redirect()->route('cash.buyers');
        }
    }

    public function update(Request $request, $id)
    {
        $ADMIN_USER_IDS = [1];
        $user = Auth::user();
        $extensions = [
            'image/png' => '.png',
            'image/jpeg' => '.jpeg'
        ];

        $profile_pic = null;
        if(!empty($request->profile_pic)){
            $interventionImg = Image::make($request->file('profile_pic'));
            $profile_pic = 'profile_pic_'.time().$extensions[$interventionImg->mime()];
            $interventionImg->save(public_path('uploads').'/'.$profile_pic);
            $image = $request->file('profile_pic');
            $input['file'] = time().'.'.$image->getClientOriginalExtension();
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'profile_pic' => $profile_pic,
            'email' => $request->email,
            'contact_no' => $request->contact_no ?? null,
            'min_price_range' => $request->min_price_range,
            'max_price_range' => $request->max_price_range,
            'min_profit_deal' => $request->min_profit_deal,
            'state' => $request->state,
            'city' => $request->city,
            'zip' => $request->zip,
            'property_type' => $request->property_type,
            'beds' => $request->beds,
            'baths' => $request->baths,
            'user_id' => $user->id,
        ];

        // Remove empty array values from the data
        $result = array_filter($data);
        CashBuyer::where('id', $id)->update($result);
        return redirect()->route('cash.buyers');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        CashBuyer::where('id', $request->id)->delete();
    }

    public function importCashBuyers(Request $request){
        \Excel::import(new CashBuyersImport, $request->file);
        return redirect()->route('cash.buyers')->with('success', 'Cash Buyers Imported Successfully');
    }

}
