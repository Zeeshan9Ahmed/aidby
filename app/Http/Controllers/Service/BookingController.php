<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function bookingIndex()
    {
        $services = DB::select('(select 
                                    book_services.id,
                                     users.first_name, 
                                     users.last_name, 
                                     start_date as date ,
                                      "NORMAL" as type, 
                                      payment_method , 
                                    (select title   from categories where id = 
                                        (select sub_category_id from services where id = book_services.service_id )  LIMIT 1  
                                    ) as title ,
                                    (select services.fixed_price from services where services.id = book_services.service_id ) as hourly_rate
                                    from book_services 
                                    join users on users.id = book_services.user_id
                                    where user_service_id = "' . auth()->id() . '" AND book_services.status = "in-progress"
                                )
                                UNION
                                (select 
                                    bookings.id ,
                                    users.first_name,
                                    users.last_name, 
                                    bookings.date as date , 
                                    "URGENT" as type, 
                                    bookings.payment_method ,
                                    (select title from categories where id = bookings.sub_category_id)
                                    as title ,
                                    bookings.per_hour_rate as hourly_rate
                                    from bookings JOIN users on users.id = bookings.user_id
                                    where status = "in-progress"
                                )
                                
                                ');
        $completed_services = DB::select('(select 
                                book_services.id,
                                 users.first_name, 
                                 users.last_name,
                                 users.id as user_id, 
                                 start_date as date ,
                                  "NORMAL" as type, 
                                  payment_method , 
                                (select title   from categories where id = 
                                    (select sub_category_id from services where id = book_services.service_id )  LIMIT 1  
                                ) as title ,

                                (select rating from ratings as rt where rt.record_id = book_services.id and rt.type = "book_service" and rt.created_by = "' . auth()->id() . '") as avg_rating,

                                (select services.fixed_price from services where services.id = book_services.service_id ) as hourly_rate
                                from book_services 
                                join users on users.id = book_services.user_id
                                where user_service_id = "' . auth()->id() . '" AND book_services.status = "completed"
                            )
                            UNION
                            (select 
                                bookings.id ,
                                users.first_name,
                                users.last_name, 
                                users.id as user_id, 
                                bookings.date as date , 
                                "URGENT" as type, 
                                bookings.payment_method ,
                                (select title from categories where id = bookings.sub_category_id)
                                as title ,
                                (select rating from ratings as rt where rt.record_id = bookings.id and rt.type = "booking" and rt.created_by = "' . auth()->id() . '") as avg_rating,

                                bookings.per_hour_rate as hourly_rate
                                from bookings JOIN users on users.id = bookings.user_id
                                where status = "completed"
                            )
                            
                            ');
        // return $completed_services;
        return view('service.booking.index', compact('services','completed_services'));
    }
}
