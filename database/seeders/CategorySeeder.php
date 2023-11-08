<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            // _____Main Category
            array(
                'title' => 'Care Giving',
                'parent_id' => null
            ),
            array(
                'title' => 'Hygiene',
                'parent_id' => null
            ),
            array(
                'title' => 'Cooking',
                'parent_id' => null
            ),
            array(
                'title' => 'Cleaning and Organizing',
                'parent_id' => null
            ),
            array(
                'title' => 'Baby Sitting',
                'parent_id' => null
            ),
            array(
                'title' => 'Household Chores',
                'parent_id' => null
            ),
            array(
                'title' => 'Washing',
                'parent_id' => null
            ),
            array(
                'title' => 'Walking',
                'parent_id' => null
            ),
            array(
                'title' => 'Pet Care',
                'parent_id' => null
            ),
            // _____End Category
            // _________________________________________________1
            array(
                'title' => 'Full Caregiving',
                'parent_id' => 1
            ),
            array(
                'title' => 'Feeding Only',
                'parent_id' => 1
            ),
            array(
                'title' => 'Bed Positioning Only',
                'parent_id' => 1
            ),
            array(
                'title' => 'Walking Assistance Only',
                'parent_id' => 1
            ),
            array(
                'title' => 'Accompanying to and from appointments',
                'parent_id' => 1
            ),
            // ____________________________________________________2
            array(
                'title' => 'Shower',
                'parent_id' => 2
            ),
            array(
                'title' => 'Shave',
                'parent_id' => 2
            ),
            array(
                'title' => 'Toileting',
                'parent_id' => 2
            ),
            array(
                'title' => 'Haircut',
                'parent_id' => 2
            ),
            array(
                'title' => 'Speciality Barber/ Hairdresser',
                'parent_id' => 2
            ), 
            // ____________________________________________________3
            array(
                'title' => 'Cooking Breakfast/ Lunch/ Dinner',
                'parent_id' => 3
            ), 
            array(
                'title' => 'Meal Prep Only',
                'parent_id' => 3
            ), 
            array(
                'title' => 'Chef services',
                'parent_id' => 3
            ),
            // _____________________________________________________4
            array(
                'title' => 'Regular Cleaning',
                'parent_id' => 4
            ),
            array(
                'title' => 'Deep Cleaning',
                'parent_id' => 4
            ),
            array(
                'title' => 'Window Cleaning',
                'parent_id' => 4
            ),
            array(
                'title' => 'Carpet Cleaning/Washing Only',
                'parent_id' => 4
            ),
            array(
                'title' => 'Moveout Cleaning',
                'parent_id' => 4
            ),
            array(
                'title' => 'Organizing',
                'parent_id' => 4
            ),
            array(
                'title' => 'Pressure Washing',
                'parent_id' => 4
            ),
            // _____________________________________________________5
            array(
                'title' => 'Baby Sitting',
                'parent_id' => 5
            ),
            array(
                'title' => 'Kids Pick up and Drop off',
                'parent_id' => 5
            ),
            // _____________________________________________________6
            array(
                'title' => 'Meal Preperation Only',
                'parent_id' => 6
            ),
            array(
                'title' => 'Cooking Only',
                'parent_id' => 6
            ),
            array(
                'title' => 'Eating Assistance Only (Feeding)',
                'parent_id' => 6
            ),
            // _____________________________________________________7
            array(
                'title' => 'Wash and Fold',
                'parent_id' => 7
            ),
            array(
                'title' => 'Wash and Press',
                'parent_id' => 7
            ),
            array(
                'title' => 'Dish Washing',
                'parent_id' => 7
            ),
            // _____________________________________________________8
            array(
                'title' => 'Indoor Walking Assistance',
                'parent_id' => 8
            ),
            array(
                'title' => 'Outdoor Walking Assitance',
                'parent_id' => 8
            ),
            array(
                'title' => 'Appointments',
                'parent_id' => 8
            ),
            array(
                'title' => 'Accompanying for Appointments',
                'parent_id' => 8
            ),
            array(
                'title' => 'Baby Sitting',
                'parent_id' => 8
            ),
            array(
                'title' => 'Kids Pick up and Drop off',
                'parent_id' => 8
            ),
            // _____________________________________________________9
            array(
                'title' => 'Dog Walking',
                'parent_id' => 9
            ),
            array(
                'title' => 'Pet Sitting',
                'parent_id' => 9
            ),
            array(
                'title' => 'Pet Grooming',
                'parent_id' => 9
            ),
            array(
                'title' => 'Pet Boarding and Lodging',
                'parent_id' => 9
            ),
        ]);
    }
}
