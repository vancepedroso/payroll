<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItems extends Model
{
    use HasFactory;

    protected $fillable = [
      'payroll_id',
      'emp_id',
      'present',
      'absent',
      'absent_amount',
      'late',
      'late_amount',
      'undertime',
      'undertime_amount',
      'earning_amount',
      'earnings',
      'deduction_amount',
      'deductions',
      'overtime',
      'overtime_amount',
      'rdot',
      'total_regular_wdays',
      'total_wdays',
      'total_whours',
      'training_days',
      'training_hours',
      'perfect_attendance_date',
      'gross_pay',
      'allowance',
      'night_differential',
      'incentives',
      'perfect_attendance_team',
      'perfect_attendance',
      'holidays',
      'holiday_date',
      'holiday_amount',
      'regularization',
      'one_year',
      'referral',
      'appraisal',
      'dispute',
      'suspension',
      'salary_loans',
      'benefits',
      'net'
    ];  
}
