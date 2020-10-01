<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $User = [
            [
                "name" => "vle_admin",
                "email" => "giriprasath7768@gmail.com",
                "password" => Hash::make("vle@7729"),
                "user_id" => "",
                "user_type" => "super_admin",
                "mobile_number" => "9994785467",
            ],[
                "name" => "Gopi",
                "email" => "gopi@gmail.com",
                "password" => Hash::make("123456"),
                "user_id" => "",
                "user_type" => "super_admin",
                "mobile_number" => "9876543210",
            ],[
                "name" => "Vijay",
                "email" => "vijay@gmail.com",
                "password" => Hash::make("123456"),
                "user_id" => "",
                "user_type" => "super_admin",
                "mobile_number" => "0123456789",
            ],[
                "name" => "Narmatha",
                "email" => "narmatha@gmail.com",
                "password" => Hash::make("123456"),
                "user_id" => "",
                "user_type" => "super_admin",
                "mobile_number" => "9874563210",
            ],[
                "name" => "Rubesh",
                "email" => "rubesh@gmail.com",
                "password" => Hash::make("123456"),
                "user_id" => "",
                "user_type" => "super_admin",
                "mobile_number" => "0123654789",
            ]
        ];

        $RolesLists = [
            ['name' => 'super_admin','is_default'=>1,'created_at'=>now(),'updated_at'=>now(),'guard_name'=>'web'],
            ['name' => 'Admin','is_default'=>0,'created_at'=>now(),'updated_at'=>now(),'guard_name'=>'web'],
            ['name' => 'Staff','is_default'=>0,'created_at'=>now(),'updated_at'=>now(),'guard_name'=>'web'],
            ['name' => 'Student','is_default'=>0,'created_at'=>now(),'updated_at'=>now(),'guard_name'=>'web'],
        ];

        $questionType = [
            ['question_name' => '1 Mark','question_type'=>1,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '2 Mark','question_type'=>2,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '3 Mark','question_type'=>3,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '4 Mark','question_type'=>4,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '5 Mark','question_type'=>5,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '6 Mark','question_type'=>6,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '7 Mark','question_type'=>7,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '8 Mark','question_type'=>8,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '9 Mark','question_type'=>9,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '10 Mark','question_type'=>10,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '11 Mark','question_type'=>11,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '12 Mark','question_type'=>12,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '13 Mark','question_type'=>13,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '14 Mark','question_type'=>14,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '15 Mark','question_type'=>15,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '16 Mark','question_type'=>16,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '17 Mark','question_type'=>17,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '18 Mark','question_type'=>18,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '19 Mark','question_type'=>19,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_name' => '20 Mark','question_type'=>20,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
        ];

        $segregation = [
            ['question_type_id' => '1','segregation'=>'True or False' ,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['question_type_id' => '1','segregation'=>'Choose the best answer' ,'is_default'=>1,'created_at'=>now(),'updated_at'=>now()],
        ];


        DB::table('users')->insert($User);

        DB::table('roles')->insert($RolesLists);

        DB::table('question_types')->insert($questionType);

        DB::table('segregations')->insert($segregation);

        $this->call([PermissionTableSeeder::class]);

        User::find(1)->assignRole(1);

        User::find(2)->assignRole(1);

        User::find(3)->assignRole(1);

        User::find(4)->assignRole(1);

        User::find(5)->assignRole(1);
    }
}
