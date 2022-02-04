<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deduction;

class DeductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $deductions = [
        [
          'id'          => 1,
          'deduction'   => 'Salary Loans',
          'description' => ''
        ],
        [
          'id'          => 2,
          'deduction'   => 'SSS/Philhealth/Pagibig',
          'description' => ''
        ],
      ];

      Deduction::insert($deductions);
    }
}
