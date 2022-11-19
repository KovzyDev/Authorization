<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Payment\Payze;
use App\Models\User;
use App\Models\Users_Addresses;
use App\Models\Add_Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends ApiController
{
    public $paginateVar = 10;
    public $addresses_count;
    public $cards_count;

    function __construct()
    {
        $this->middleware('auth');
    }

    public function getCardsList()
    {
        return $this->respond([
            'status' => 'success',
            'history' => [
                'cards' => [],
            ],
        ]);
    }

    public function getAddressesList()
    {
        $addresses = Users_Addresses::where('user_id', '=', Auth::user()->id)
            ->paginate(10);

            // dd(get_class_methods($addresses));

        if($addresses->isEmpty()) {
            return $this->respondNotFound('Address does not exist.');
        }

        return $this->respond([
            'status' => 'success',
            'history' => [
                'addresses' => $addresses,
            ],
        ]);
    }

    public function user()
    {
        // ...
    }

    public function editUserProfile()
    {
        $user = auth()->user();
        return $this->respond([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90.0,90.0',
            'longitude' => 'required|numeric|between:-180.0,180.0',
            'address' => 'required|string',
            'comment' =>  'nullable|string',
        ]);

        $address = new Users_Addresses;

        try{
            $address->user_id = Auth::user()->id;
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

        return $this->respondCreated('Address successfully created.');
    }

    public function addCards(Request $request)
    {
        $config = (object)config('paymentconfig.payze');
       
        $payze = new Payze($config);
        $result = $payze->saveCard($config);

        // dd($result);
    }

    public function addUserProfile(Request $request)
    {
        //
    }
}
