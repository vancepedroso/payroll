<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Earning;
use App\Models\Deduction;
use DB;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['ref_no','dept_id','date_from','date_to','type','status'];

    public function SearchTypeId($id)
    {   
      switch ($id) {
        case '1':
            $type = "Monthly";
            break;
        case '2':
            $type = "Semi-Monthly";
            break;
        case '3':
            $type = "Once";
            break;
        default:
            $type = "undefined";
      }
       return $type;
    }

    public function SearchEarningById($id)
    {   
      $earnings = Earning::find($id);
      return $earnings->earning;
    }

    public function SearchDeductionById($id)
    {   
      $deductions = Deduction::find($id);
      return $deductions->deduction;
    }

    public function SearchStatusId($id)
    {   
      switch ($id) {
        case '0':
          $status = ([
            'class' => 'info',
            'status' => 'New'
          ]);
          break;
        case '1':
          $status = ([
            'class' => 'success',
            'status' => 'Calculated'
          ]);
          break;
        default:
          $status = ([
            'class' => 'danger',
            'status' => 'Error'
          ]);
          break;
      }
       return $status;
    }

    public function SearchDepartments() {

      return DB::connection('mysql2')->select("
        SELECT * FROM teams
        ORDER BY team_name
      "); 

    }

    public function SearchDepartmentsById($id) {
      $department = DB::connection('mysql2')->select("SELECT * FROM teams where id = $id");

      return $department[0]->team_name;
    }
}
