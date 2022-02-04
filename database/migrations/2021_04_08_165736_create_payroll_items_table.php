<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->string('payroll_id')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('present')->nullable();
            $table->string('absent')->nullable();
            $table->string('late')->nullable();
            $table->string('undertime')->nullable();
            $table->string('overtime')->nullable();
            $table->string('earning_amount')->nullable();
            $table->string('holidays')->nullable();
            $table->string('holiday_date')->nullable();
            $table->string('earnings')->nullable();
            $table->string('deduction_amount')->nullable();
            $table->string('deductions')->nullable();
            $table->string('rdot')->nullable();
            $table->string('total_regular_wdays')->nullable();
            $table->string('total_wdays')->nullable();
            $table->string('total_whours')->nullable();
            $table->string('training_days')->nullable();
            $table->string('training_hours')->nullable();
            $table->string('perfect_attendance_date')->nullable();
            //Earnings
            $table->string('gross_pay')->nullable();
            $table->string('allowance')->nullable();
            $table->string('night_differential')->nullable();
            $table->string('incentives')->nullable();
            $table->string('overtime_amount')->nullable();
            $table->string('perfect_attendance_team')->nullable();
            $table->string('perfect_attendance')->nullable();
            $table->string('holiday_amount')->nullable();
            $table->string('regularization')->nullable();
            $table->string('one_year')->nullable();
            $table->string('referral')->nullable();
            $table->string('appraisal')->nullable();
            $table->string('dispute')->nullable();
            //Deductions
            $table->string('absent_amount')->nullable();
            $table->string('late_amount')->nullable();
            $table->string('undertime_amount')->nullable();
            $table->string('suspension')->nullable();
            $table->string('salary_loans')->nullable();
            $table->string('benefits')->nullable();

            $table->string('net')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_items');
    }
}
