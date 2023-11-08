<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use App\Models\Service;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponser;
    public function getProfile () 
    {
        $services = Service::with('service_provider','service_category','service_sub_category')->where('user_id', auth()->id())->get();

        return view('service.profile.my-profile', compact('services'));    

    }

    public function deleteContact (Request $request) 
    {

        EmergencyContact::destroy($request->id);

        return $this->successResponse('Contact removed Successfully.');
        
    }

    public function saveContacts (Request $request) 
    {
        $ids = [];
        foreach ($request->phone_number as $number) {

            $ids[] = EmergencyContact::create([
                'user_id' => auth()->id(),
                'phone_number' => $number
            ])->id;
        }

        return $this->successDataResponse("Number(s) added successfully", $ids, 200);

    }
}
