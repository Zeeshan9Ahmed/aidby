<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookService;
use App\Models\Category;
use App\Models\Content;
use App\Models\EmergencyContact;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\returnSelf;

class ServiceController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $categories = Category::orderBy('title')->where('parent_id', null)->get();
        
        $services = Service::with('service_provider','service_category','service_sub_category')
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->get();
        
        return view('service.home.index', compact('categories','services'));
    }

    public function deleteServices (Request $request) 
    {

        $ids = json_decode($request->ids);
        BookService::whereIn('service_id', $ids)->delete();
        $services = Service::destroy($ids);
        return $this->successResponse("Services deleted.");
    }
    /** Complete profile form */
    public function completeProfileForm()
    {
        $content = Content::get();
        $contacts = EmergencyContact::where('user_id', auth()->id())->get();
    
        return view('service.profile.complete-profile', compact('content','contacts'));    
    }


    /** Complete profile */
    public function completeProfile(Request $request)
    {
        
        $request->validate([
            'profile_image'       =>    'mimes:jpeg,png,jpg'
        ]);

        $completeProfile = collect(request()->all())->filter()->except('_token')->toArray();

        if($request->hasFile('profile_image')){
            $profile_image = $request->profile_image->store('public/profile_image');
            $path = Storage::url($profile_image);
            $completeProfile['profile_image'] = $path;
        }

        if($request->hasFile('driving_license')){
            $profile_image = $request->driving_license->store('public/service_provider_images');
            $path = Storage::url($profile_image);
            $completeProfile['driving_license'] = $path;
        }

        if($request->hasFile('drug_test_report')){
            $profile_image = $request->drug_test_report->store('public/service_provider_images');
            $path = Storage::url($profile_image);
            $completeProfile['drug_test_report'] = $path;
        }

        if($request->hasFile('certification')){
            $profile_image = $request->certification->store('public/service_provider_images');
            $path = Storage::url($profile_image);
            $completeProfile['certification'] = $path;
        }

        $completeProfile['is_profile_complete'] = '1';
        $update_user = User::whereId(auth()->user()->id)->update($completeProfile);
        
        if($update_user){
            session()->flash('success', auth()->user()->is_profile_complete==1?"Profile updated successfully": 'Profile complete successfully');
            return $this->successDataResponse('Profile complete successfully.', url('service/my-profile'), 200);
        }else{
            return $this->errorResponse('Something went wrong.', 400);
        }  
    }
    
    /** Get sub categories */
    public function getSubCategories($id)
    {
        return Category::orderBy('title')->where('parent_id', $id)->get();
    }

    public function addService (Request $request) 
    {
        $request->validate([
            'category_id'                  =>  'required|exists:categories,id',
            'sub_category_id'              =>  'required|exists:categories,id',
            // 'per_hour_rate'             =>  'required',
            'fixed_price'               =>  'required',
            // 'license'                   =>  'required|in:0,1',
            'description'               =>  'required',
        ]);


        $service = Service::create($request->except('_token')+['user_id' => auth()->id()]);
        
        // $service = Service::with('service_provider','service_category','service_sub_category')->whereId($service->id)->first();
        session()->flash('success', 'Service added successfully');

        return $this->successDataResponse("Service added successfully", $service, 200);
    }

    public function serviceRequestForm () {
        $requests = collect(DB::select('(select 
                                    book_services.id,
                                     users.first_name, 
                                     users.last_name, 
                                     users.email, 
                                     users.profile_image, 
                                     start_date as start_date,
                                     end_date,
                                     time as time ,
                                     services.per_hour_rate,
                                     services.fixed_price,
                                      "NORMAL" as type, 
                                      payment_method ,
                                      additional_information, 
                                    (select title   from categories where id = services.sub_category_id  LIMIT 1  
                                    ) as sub_category ,
                                    (select title   from categories where id = services.category_id  LIMIT 1  
                                    ) as category ,
                                    (select services.per_hour_rate from services where services.id = book_services.service_id ) as hourly_rate
                                    from book_services 
                                    join users on users.id = book_services.user_id
                                    inner join services on services.id = book_services.service_id 
                                    where user_service_id = '.auth()->id().' AND status = "pending" AND start_date >= CURDATE()
                                    
                                )
                                UNION
                                (select 
                                    bookings.id ,
                                    users.first_name,
                                    users.last_name, 
                                    users.email, 
                                     users.profile_image,
                                    bookings.date as start_date,
                                    bookings.date as end_date,
                                    bookings.time,
                                    bookings.per_hour_rate as per_hour_rate,
                                    0 as fixed_price, 
                                    "URGENT" as type, 
                                    bookings.payment_method ,
                                    additional_information,
                                    (select title from categories where id = bookings.sub_category_id)
                                    as sub_category ,
                                    (select title from categories where id = bookings.category_id)
                                    as category ,
                                    bookings.per_hour_rate as hourly_rate
                                    from bookings JOIN users on users.id = bookings.user_id
                                    where status = "pending" AND date = CURDATE()
                                    )
                                
                                '));

                            // dd($services);
                                // per_hour_rate, fixed_price , start_date , end_date , time , 
        // return $services;
        // $requests = BookService::
        //                     with('service_creator:id,first_name,last_name,email,profile_image',
        //                     'service.service_sub_category')
        //                     ->where(['status' => 'pending'])
        //                     ->where('start_date','>=', Carbon::today())
        //                     ->where('user_service_id', auth()->id())
        //                     // ->whereRaw('id in (select record_id from notifications where receiver_id = "'.auth()->id().'" and type= "book_service")')
        //                     ->get();
        // return $requests;
        return view('service.requests.index', compact('requests'));    

    }

    public function serviceRequestStatus (Request $request ) {
        // dd($request->all());
        $service_type = $request->service_type;
        $id = $request->id;
        $type = $request->type;
        $url = "";
        if ($type == "accept") {
            $url = url('service/bookings');
            session()->flash('success', 'Request accepted successfully');

        }

        if ($service_type == "URGENT") {
            $booking = Booking::whereId($id)->first();
            if ($type== "accept" && $booking->status !="pending" ) {
                return $this->errorResponse("this service has been booked", 400);
            }
            $title = "Urgent Booking Request";
            $description = "";
            if ($type == "accept" ) {
                $booking->status = "in-progress";
                $description = auth()->user()->first_name . ' ' . auth()->user()->last_name . ' accepted your request.';
                
            } else {
                $booking->status = "rejected";
                $description = auth()->user()->first_name . ' ' . auth()->user()->last_name . ' rejected your request.';
            }
            // Notification 
            $this->sendNotification(auth()->id(), $booking->user_id, $title, $description, $booking->id, 'book_service');
            $booking->save();
            return $this->successDataResponse("Rejected successfully", $url, 200);
        }


        if ($service_type == "NORMAL") {
            $booking = BookService::whereId($id)->first();

            
            if ($type== "accept" && $booking->status =="pending" ) {
                $booking->status = "in-progress";
                $booking->save();
                // Notification 
                $this->sendNotification(auth()->id(), $booking->user_id, 'Hired Request', auth()->user()->first_name . ' ' . auth()->user()->last_name . ' accepted your request.', $booking->id, 'book_service' );

                return $this->successDataResponse("Request Accepted Succesfully",$url, 200);
            }
            
            
            if ($type== "reject" && $booking->status =="pending" ) {
                $booking->status = "rejected";
                $booking->save();

                // Notification 
                $this->sendNotification(auth()->id(), $booking->user_id, 'Hired Request', auth()->user()->first_name . ' ' . auth()->user()->last_name . ' rejected your request.', $booking->id, 'book_service' );

                return $this->successDataResponse("Request rejected succesfully",$url, 400);
            }

            return $this->errorResponse("this service has been booked", 400);

        }

        



    } 


    public function markCompleteService (Request $request) {
        // ->update(['status' => 'completed']);
        if ($request->type == "normal") {
            $booking = BookService::whereId($request->id)->first();
            $booking->status = "completed";
            $booking->save();
           
            
        } else {
            $booking = Booking::whereId($request->id)->first();
            $this->sendNotification(auth()->id(), $booking->user_id, 'Urgent Booking Request',auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has completed your request.', $booking->id, 'book_service' );
            $booking->status = "completed";
            $booking->completed_by = auth()->id();
            $booking->save();
        }

        
        return $this->successResponse("Mark as completed successfully",200);
    }
    public function sendNotification ($sender_id, $receiver_id, $title, $description, $record_id , $type) {
        $notification = [
            'sender_id'     => $sender_id,
            'receiver_id'   => $receiver_id,
            'title'         => $title,
            'description'   => $description,
            'record_id'     => $record_id,
            'type'          => $type,
            'created_at'    => now(),
            'updated_at'    => now()
        ];
        in_app_notification($notification);
    }
    public function serviceDetail ($type,$id) {

        //urgent in bookings 
        //normal in booking service  
        if ($type ==  "normal") {

            $service = BookService::
                                with('service_creator',
                                    'service.service_category',
                                    'service.service_sub_category',
                                    'problem_images:id,attachment,record_id'
                                    )
                                    ->whereId($id)->firstOrFail();
            return view('service.booking.normal-service-detail', compact('service','type'));    
        }else if ($type == "urgent") {

            $service = Booking::
                                with('user',
                                    'category',
                                    'sub_category',
                                    'problem_images:id,attachment,record_id'
                                    )
                                    ->
                                    whereId($id)->firstOrFail();
                                    // return $service;
            return view('service.booking.service-detail', compact('service','type'));
        }

        return redirect()->back();

    } 

    /** Create review */
    public function createReview(Request $request)
    {        
        $created = Rating::create($request->except('_token')+['created_by' => auth()->id()]);

        if ($created) {
            return back()->with('success', 'Review submitted successfully.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function saveSoSMessage (Request $request) {
        auth()->user()->sos_message = $request->message;
        auth()->user()->save();
        return $this->successResponse("Message saved successfully",200);

    }
    public function notifications () {
        $notifications = Notification::with('sender:id,first_name,last_name')->where('receiver_id', auth()->id())->latest()->get();
        return $this->successDataResponse("Notifications", $notifications, 200);

    }
    

    public function updateUnreadNotifications () {
        Notification::where('receiver_id', auth()->id())->update(['seen' => '1']);
        return $this->successResponse("Notifications",200);

    }
    public function logout () {
        
        Auth::logout();
        session()->flash('success', 'Logout Successfully');
        return redirect()->route('login');
    }


    
}
