<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{
    Address,
    Chat,
    Blog,
    User,
    Vital,
    Rating,
    Service,
    Booking,
    Content,
    Category,
    Attachment,
    BookService,
    Notification,
    PaymentReceipt,
    EmergencyContact
};
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $categories = Category::orderBy('title')->where('parent_id', null)->get();
        $services = Service::join('users', 'users.id', 'services.user_id')->select('users.city')->groupBy('users.city')->select('users.city')->get();
        
        return view('user.home.index', compact('categories', 'services'));
    }

    /** My profile */
    public function myProfile()
    {
        $authId = auth()->id();
        $bookings = Booking::latest()->where('bookings.user_id', auth()->user()->id)
        ->select(
            'bookings.*',
            DB::raw('(select rating from ratings as rt where rt.record_id = `bookings`.`id` and rt.type = "booking" and rt.created_by = '. $authId .') as avg_rating')
        )->get();

        $bookServices = BookService::with('service')->where('book_services.user_id', auth()->user()->id)
        ->select(
            'book_services.*',
            DB::raw('(select rating from ratings as rt where rt.record_id = `book_services`.`id` and rt.type = "book_service" and rt.created_by = '. $authId .') as avg_rating')
        )->latest()->get();
        
        return view('user.profile.my-profile', compact('bookings', 'bookServices'));
    }

    public function myBooking()
    {
        $authId = auth()->id();
        $bookings = Booking::latest()->where('bookings.user_id', auth()->user()->id)
        ->select(
            'bookings.*',
            DB::raw('(select rating from ratings as rt where rt.record_id = `bookings`.`id` and rt.type = "booking" and rt.created_by = '. $authId .') as avg_rating')
        )->get();

        $bookServices = BookService::with('service')->where('book_services.user_id', auth()->user()->id)
        ->select(
            'book_services.*',
            DB::raw('(select rating from ratings as rt where rt.record_id = `book_services`.`id` and rt.type = "book_service" and rt.created_by = '. $authId .') as avg_rating')
        )->latest()->get();
        
        return view('user.profile.my-booking', compact('bookings', 'bookServices')); 
    }

    /** Complete profile form */
    public function completeProfileForm()
    {
        $content = Content::get();
        $contacts = EmergencyContact::where('user_id', auth()->id())->get();
        return view('user.profile.complete-profile', compact('content', 'contacts'));
    }

    /** Complete profile */
    public function completeProfile(Request $request)
    {
        $request->validate([
            'profile_image'       =>    'mimes:jpeg,png,jpg'
        ]);

        $completeProfile = $request->except('_token');

        if ($request->hasFile('profile_image')) {
            $profile_image = $request->profile_image->store('public/profile_image');
            $path = Storage::url($profile_image);
            $completeProfile['profile_image'] = $path;
        }

        $completeProfile['is_profile_complete'] = '1';
        $update_user = User::whereId(auth()->user()->id)->update($completeProfile);

        if ($update_user) {
            session()->flash('success', 'Profile complete successfully');
            return $this->successResponse('Profile complete successfully.');
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }

    /** Get categories */
    public function getCategories()
    {
       return Category::orderBy('title')->where('parent_id', null)->get();
    }

    /** Get sub categories */
    public function getSubCategories($id)
    {
        return Category::orderBy('title')->where('parent_id', $id)->get();
    }

    /** Book now */
    public function bookNow(Request $request)
    {
        $request->validate([
            'category'                  =>  'required|exists:categories,id',
            'sub_category'              =>  'required|exists:categories,id',
            'per_hour_rate'             =>  'required|numeric',
            'time'                      =>  'required',
            // 'license'                   =>  'required|in:0,1',
            'rating'                    =>  'required|between:1,5',
            'payment_method'            =>  'required|in:cash,card',
            'additional_information'    =>  'required'
        ]);

        try{
            // Card payment
            if($request->payment_method == 'card'){

                $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

                // Card list
                $card_list = $stripe->customers->allSources(
                    auth()->user()->customer_id, ['object' => 'card']
                );

                // Charge create
                if(count($card_list->data) > 0){
                    $charge = $stripe->charges->create([
                        'customer'     =>  auth()->user()->customer_id,
                        'amount'       =>  $request->per_hour_rate * 100,
                        'currency'     =>  'USD',
                        'source'       =>  $card_list->data[0]->id,
                        'description'  => 'Booking Fee'
                    ]);

                    if($charge){
                        $paymentReceipt = new PaymentReceipt();
                        $paymentReceipt->user_id = auth()->user()->id;
                        $paymentReceipt->receipt_id = $charge->id;
                        $paymentReceipt->amount = $request->per_hour_rate;
                        $paymentReceipt->receipt_url = $charge->receipt_url;
                        $paymentReceipt->description = 'Booking Fee';
                    }
                } else{
                    return $this->errorResponse('Please add card.', 200);
                }
            }
            // End

            $booking = new Booking;
            $booking->category_id = $request->category;
            $booking->sub_category_id = $request->sub_category;
            $booking->date = date('Y-m-d');
            $booking->time = $request->time;
            $booking->per_hour_rate = $request->per_hour_rate;
            $booking->license = $request->license;
            $booking->rating = $request->rating;
            $booking->payment_method = $request->payment_method;
            $booking->additional_information = $request->additional_information;
            $booking->user_id = auth()->user()->id;

            if ($booking->save()) {
                // Card payment
                if($request->payment_method == 'card'){
                    $paymentReceipt->record_id = $booking->id;
                    $paymentReceipt->type = 'booking';
                    $paymentReceipt->save();
                }
                // End

                if ($request->hasFile('images')) {
                    foreach ($request->images as $reqImage) {
                        $image = $reqImage->store('public/booking');
                        $path = Storage::url($image);
                        $attachmentData['attachment'] = $path;
                        $attachmentData['attachment_type'] = explode('/', $reqImage->getClientMimeType())[0];
                        $attachmentData['record_id'] = $booking->id;
                        $attachmentData['type'] = 'booking';
                        Attachment::create($attachmentData);
                    }
                }

                
                // Notification 
                $userIds = User::join('services', 'services.user_id', 'users.id')
                ->where('services.sub_category_id', $request->sub_category)
                ->groupBy('users.id')->select('users.id as user_id')
                ->pluck('user_id');
                
                if(count($userIds) > 0){
                    foreach($userIds as $userId){
                        $notification = [
                            'sender_id'     => auth()->user()->id,
                            'receiver_id'   => $userId,
                            'title'         => 'Urgent Booking Request',
                            'description'   => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' created a service request.',
                            'record_id'     => $booking->id,
                            'type'          => 'booking',
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                        in_app_notification($notification);
                    }
                }

                session()->flash('success', 'Booking created successfully');
                return $this->successResponse('Booking created successfully.');
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } catch(\Exception $exception){
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Get cards */
    public function getCards()
    {
        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

        $card_list = $stripe->customers->allSources(
            auth()->user()->customer_id,
            ['object' => 'card']
        );

        return $card_list;
    }

    /** Add card */
    public function addCard(Request $request)
    {
        $this->validate($request, [
            'card_holder_name'        =>  'required',
            'card_number'             =>  'required',
            'expiry_month_year'       =>  'required',
            'cvc'                     =>  'required'
        ]);

        try {
            $expiry_month_year = explode('/', $request->expiry_month_year);
            $month  = $expiry_month_year[0];
            $year = $expiry_month_year[1];

            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
            // Card token
            $card_token_response = $stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $request->cvc
                ],
            ]);

            if (isset($card_token_response->error)) {
                return [
                    'status'    =>  0,
                    'message'   =>  $card_token_response->error->message
                ];
            } else {
                $card_create_response = $stripe->customers->createSource(
                    auth()->user()->customer_id,
                    ['source' => $card_token_response->id]
                );

                if (isset($card_create_response->error)) {
                    return [
                        'status'    =>  0,
                        'message'   =>  $card_create_response->error->message
                    ];
                } else {
                    session()->flash('success', 'Card added.');

                    return [
                        'status'        =>  1,
                        'message'       =>  'Card added successfully.'
                    ];
                }
            }
        } catch (\Exception $exception) {
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }

    /** Delete card */
    public function deleteCard(Request $request)
    {
        $this->validate($request , [
            'card_id'  =>  'required'
        ]);

        try{
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

            $deleteResponse = $stripe->customers->deleteSource(
                auth()->user()->customer_id,
                $request->card_id,
                []
            );

            if(isset($deleteResponse->deleted)){
                return [
                    'status'    =>  1,
                    'message'   =>  'Card deleted successfully.'
                ];
            }
            else{
                return [
                    'status'     =>  0,
                    'message'    =>  'Something went wrong.'
                ];
            }
        }catch (\Exception $exception){
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }

    /** Category service */
    public function categoryServices($id)
    {
        $category = Category::whereId($id)->with('services', function($q){
            return $q->select('services.*', DB::raw('(select avg(rating) from ratings as rt where rt.record_id = `services`.`id` and rt.type = "book_service") as avg_rating'));
        })->firstOrFail();

        return view('user.home.category-service', compact('category'));
    }

    /** Book service form*/
    public function bookServiceForm($id)
    {
        $service = Service::whereId($id)->with('service_provider')->firstOrFail();
        return view('user.home.book-service', compact('service'));
    }

    /** Book service */
    public function bookService(Request $request)
    {
        $this->validate($request , [
            'start_date'              =>  'required|date_format:Y-m-d|after_or_equal:today',
            'end_date'                =>  'required|date_format:Y-m-d|after_or_equal:start_date',
            'time'                    =>  'required|date_format:H:i',
            'additional_information'  =>  'required',
            'payment_method'          =>  'required|in:cash,card',
            'service_id'              =>  'required|exists:services,id'
        ]);

        try{
            $service = Service::whereId($request->service_id)->first();

            // Card payment
            if($request->payment_method == 'card'){

                $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

                // Card list
                $card_list = $stripe->customers->allSources(
                    auth()->user()->customer_id, ['object' => 'card']
                );

                // Charge create
                if(count($card_list->data) > 0){
                    $charge = $stripe->charges->create([
                        'customer'     =>  auth()->user()->customer_id,
                        'amount'       =>  $service->fixed_price * 100,
                        'currency'     =>  'USD',
                        'source'       =>  $card_list->data[0]->id,
                        'description'  =>  'Service Booking Fee'
                    ]);

                    if($charge){
                        $paymentReceipt = new PaymentReceipt();
                        $paymentReceipt->user_id = auth()->user()->id;
                        $paymentReceipt->receipt_id = $charge->id;
                        $paymentReceipt->amount = $service->fixed_price;
                        $paymentReceipt->receipt_url = $charge->receipt_url;
                        $paymentReceipt->description = 'Service Booking Fee';
                    }
                } else{
                    return $this->errorResponse('Please add card.', 200);
                }
            }
            // End

            $bookService = new BookService;
            $bookService->user_id = auth()->user()->id;
            $bookService->start_date = $request->start_date;
            $bookService->end_date = $request->end_date;
            $bookService->time = $request->time;
            $bookService->additional_information = $request->additional_information;
            $bookService->payment_method = $request->payment_method;
            $bookService->service_id = $request->service_id;
            $bookService->user_service_id = $service->user_id;
            $bookService->is_other_address = $request->is_other_address;
            $bookService->location = $request->other_address;
            $bookService->latitude = $request->latitude;
            $bookService->longitude = $request->longitude;
            $bookService->state = $request->other_state;
            $bookService->city = $request->other_city;
            
            if($bookService->save()){

                // Card payment
                if($request->payment_method == 'card'){
                    $paymentReceipt->record_id = $bookService->id;
                    $paymentReceipt->type = 'book_service';
                    $paymentReceipt->save();
                }
                // End

                if ($request->hasFile('images')) {
                    foreach ($request->images as $reqImage) {
                        $image = $reqImage->store('public/book_service');
                        $path = Storage::url($image);
                        $attachmentData['attachment'] = $path;
                        $attachmentData['attachment_type'] = explode('/', $reqImage->getClientMimeType())[0];
                        $attachmentData['record_id'] = $bookService->id;
                        $attachmentData['type'] = 'book_service';
                        Attachment::create($attachmentData);
                    }
                }

                // Notification 
                $notification = [
                    'sender_id'     => auth()->user()->id,
                    'receiver_id'   => $service->user_id,
                    'title'         => 'Hired Request',
                    'description'   => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' booked your service.',
                    'record_id'     => $bookService->id,
                    'type'          => 'book_service',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
                in_app_notification($notification);

                session()->flash('success', 'Service booked successfully');
                return $this->successResponse('Service booked successfully.');
            } else {
                return $this->errorResponse('Something went wrong.', 400);
            }
        } catch(\Exception $exception){
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Search */
    public function search(Request $request)
    {
        $this->validate($request, [
            'search_key'     =>  'required'
        ]);

        $categories = Category::whereNotNull('parent_id')->where('title', 'LIKE', '%'.$request->search_key.'%')->orderBy('title')->take(10)->get();

        if(count($categories) > 0){
            return  [
                'status'  => 1,
                'message' => 'Search result found.',
                'data'    => $categories
            ];
        }
        else{
            return  [
                'status'  => 0,
                'message' => 'Search result not found.',
            ];
        }
    }

    /** Service city */
    public function serviceCity($city)
    {
        $city = str_replace('-', ' ', $city);
        $userIds = User::where('city', 'LIKE', '%'.$city.'%')->select('id')->get();
        $services = Service::whereIn('user_id', $userIds)->latest()
        ->select(
            'services.*',
            DB::raw('(select avg(rating) from ratings as rt where rt.record_id = `services`.`id` and rt.type = "book_service") as avg_rating')
            )
        ->get();

        return view('user.home.services', compact('services', 'city'));
    }

    /** Vital index */
    public function vitalIndex()
    {
        $vitals = Vital::where('user_id', auth()->id())->latest()->get();
        $isAddVital = Vital::where('user_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->exists();
        return view('user.home.vital', compact('vitals', 'isAddVital'));
    }

    
    /** Vital data */
    public function vitalData()
    {
        return Vital::where('user_id', auth()->id())->get();
    }

    /** Vital store */
    public function vitalStore(Request $request)
    {
        $isAddVital = Vital::where('user_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->exists();

        if($isAddVital){
            return $this->errorResponse('You already add vital for current day.', 400);
        }

        $this->validate($request, [
            'heart_rate'         =>  'required|numeric',
            'blood_pressure'     =>  'required',
            'pain'               =>  'required|max:50',
            'hydration'          =>  'required',
            'weight'             =>  'required|numeric'
        ]);

        $data = $request->only('heart_rate', 'blood_pressure', 'pain', 'hydration', 'weight') + ['user_id' => auth()->user()->id]; 
        $created = Vital::create($data);
        
        if ($created) {
            session()->flash('success', 'Vital created successfully');
            return $this->successResponse('Vital created successfully.');
        } else {
            return $this->errorResponse('Something went wrong.', 400);
        }
    }

    /** Blog list */
    public function blogList($myBlog = null)
    {
        $categories = Category::orderBy('title')->where('parent_id', null)->get();
        $blogs = Blog::with('user:id,first_name,last_name,email,profile_image', 'category:id,title','sub_category:id,title')
            ->when($myBlog != null && $myBlog == 'my_blog', function($q){
                return $q->where('user_id', auth()->id());
            })->latest()->get();
        
        if($myBlog != null){
            $title = 'My Blogs';
        } else{
            $title = 'Blogs';
        }

        return view('user.blog.index', compact('categories', 'blogs', 'myBlog', 'title') );
    }

    /** Create blog */
    public function createBlog(Request $request) 
    {
        $data = $request->only(['category_id','sub_category_id', 'description']) + ['user_id' => auth()->id()];
        if($request->hasFile('blog_image')){
            $blog_image = $request->blog_image->store('public/blog_image');
            $path = Storage::url($blog_image);
            $data['blog_image'] = $path;
        }
        Blog::create($data);
        session()->flash('success', 'Blog added successfully');
        return $this->successResponse("Blog added successfully", 200);
    }

    /** Blog details */
    public function blogDetail($id = null) 
    {
        $blog = Blog::whereId($id)->with('user:id,first_name,last_name,email,profile_image','category:id,title', 'sub_category:id,title')->firstOrFail();
        return view('user.blog.detail', compact('blog'));
    }

    /** Edit blog */
    public function editBlog(Request $request) 
    {
        $blogData = $request->only(['category_id','sub_category_id','description']);
        if($request->hasFile('blog_image')){
            $blog_image = $request->blog_image->store('public/blog_image');
            $path = Storage::url($blog_image);
            $blogData['blog_image'] = $path;
        }
        $blog = Blog::whereId($request->id)->update($blogData);
        
        session()->flash('success', 'Blog updated successfully');
        return $this->successResponse("Blog updated successfully", 200);
    }

    /** Delete blog */
    public function deleteBlog($id) 
    {
        Blog::whereId($id)->delete();
        return $this->successResponse("Blog deleted successfully", 200);
    }

    public function chatIndex($receiverId = null)
    {
        $user_id = auth()->user()->id;

        $get_chat_list_1 = DB::table('chats')->select(
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.profile_image',
            DB::raw('(select message from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as message'),
            DB::raw('(select deleted_by from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as deleted_by'),
            DB::raw('(select count(id) from chats as st where st.sender_id = `users`.`id` and st.receiver_id = '. $user_id .' and st.read_at is NULL) as read_count'),
            'chats.created_at',
            'chats.id as chat_id'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.receiver_id')
        ->where('chats.sender_id', $user_id);

        $get_chat_list_2 = DB::table('chats')->select(
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.profile_image',
            DB::raw('(select message from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as message'),
            DB::raw('(select deleted_by from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as deleted_by'),
            DB::raw('(select count(id) from chats as st where st.sender_id = `users`.`id` and st.receiver_id = '. $user_id .' and st.read_at is NULL) as read_count'),
            'chats.created_at',
            'chats.id as chat_id'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
        ->where('chats.receiver_id', $user_id)
        ->union($get_chat_list_1);

        $chatLists = DB::query()->fromSub($get_chat_list_2, 'p_pn')
            ->select('user_id', 'first_name', 'last_name', 'profile_image', 'message', 'deleted_by', 'chat_id', 'created_at', 'read_count')
            ->groupBy('user_id')->orderBy('created_at','desc')->get();
                        
        return view('user.chat.index', compact('chatLists', 'receiverId'));
    }

    /** Create review */
    public function createReview(Request $request)
    {        
        $created = Rating::create($request->except('_token')+['user_id' => auth()->id()]+['created_by' => auth()->id()]);

        if ($created) {
            return back()->with('success', 'Review submitted successfully.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /** Save sos message */
    public function saveSoSMessage(Request $request) 
    {
        auth()->user()->sos_message = $request->message;
        auth()->user()->save();
        return $this->successResponse("Message saved successfully", 200);
    }

    /** Save contact */
    public function saveContacts(Request $request) 
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

    /** Delete contact */
    public function deleteContact(Request $request) 
    {
        EmergencyContact::destroy($request->id);
        return $this->successResponse('Contact removed Successfully.');
    }

    /** Read message */
    public function readMessage()
    {
        return Chat::where('receiver_id', auth()->user()->id)->where('read_at', null)->update(['read_at' => now()]);
    }

    public function page($slug)
    {
        $content = Content::where('slug', $slug)->firstOrFail();
        return view('user.home.page', compact('content'));
    }

    /** Notifications */
    public function notifications() 
    {
        $notifications = Notification::with('sender:id,first_name,last_name')->where('receiver_id', auth()->id())->latest()->get();
        return $this->successDataResponse("Notifications", $notifications, 200);
    }

    /** Notifications read */
    public function updateUnreadNotifications() 
    {
        Notification::where('receiver_id', auth()->id())->update(['seen' => '1']);
        return $this->successResponse("Notifications",200);
    }
}
