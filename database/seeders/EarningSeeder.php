<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Earning;

class EarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $earnings = [
        [
          'id'          => 1,
          'earning'   => 'Allowance',
          'description' => ''
        ],
        [
          'id'          => 2,
          'earning'   => 'Night Differential',
          'description' => ''
        ],
        [
          'id'          => 3,
          'earning'   => 'Team Perfect Attendance',
          'description' => ''
        ],
        [
          'id'          => 4,
          'earning'   => 'Perfect Attendance',
          'description' => ''
        ],
        [
          'id'          => 5,
          'earning'   => 'Regularization',
          'description' => ''
        ],
        [
          'id'          => 6,
          'earning'   => 'One-year Tenureship',
          'description' => ''
        ],
        [
          'id'          => 7,
          'earning'   => 'Referral',
          'description' => ''
        ],
      ];

      Earning::insert($earnings);
    }
}
