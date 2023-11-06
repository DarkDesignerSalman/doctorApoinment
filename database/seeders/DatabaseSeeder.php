<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Member;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
       $mdata['name'] = 'Member';
       $mdata['email']='member4@gmail.com';
       $mdata['password']=bcrypt(1234);

       Member::create($mdata);

       $cdata['name'] = 'Customer';
       $cdata['email']='customer4@gmail.com';
       $cdata['password']= bcrypt(1234);

       Customer::create($cdata);

       $this->call(userSeeder::class);

    }
}
