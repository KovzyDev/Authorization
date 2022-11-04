<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users_Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $paginateVar = 10;
    public $addresses_count;
    public $cards_count;


    public function getCardsList()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'history' => [
                'cards' => '',
            ],
        ]);
    }

    public function getAddressesList()
    {
        $this->addresses_count = Users_Addresses::where('user_id', '=', Auth::user()->id)
            ->count();

        $addresses = Users_Addresses::where('user_id', '=', Auth::user()->id)
            ->skip($this->addresses_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();

        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'history' => [
                'addresses' => $addresses,
            ],
        ]);
    }

    public function editUserProfile()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    public function addAddresses(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90.0,90.0',
            'longitude' => 'required|numeric|between:-180.0,180.0',
            'address' => 'required|string',
            'comment' =>  'nullable|string',
        ]);

        $address = new Users_Addresses;

        try{
            $address->address = $request->address;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;
            $address->comment = $request->comment;
            $address->save();
        }catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while creating addresses!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'ok'
        ]);
    }

    public function addCards(Request $request)
    {
        //
    }

    public function addUserProfile(Request $request)
    {
        //
    }
}
