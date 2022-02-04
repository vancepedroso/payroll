<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id','bank','account','rate_per_day','rdot_per_day','sss','philhealth','pagibig'];

    public function SearchEmployeeExist($id){

      $employee = Employee::where('emp_id','=',$id)
      ->exists();

      if ($employee) {

        return true;

      } else {

        return false;

      }
      

    }

    public function SearchEmployeeEmpId($id){

      $employee = Employee::where('emp_id','=',$id)->first();

      if ($employee) {

        return $employee->id;

      } else {

        return false;

      }
      

    }

    public function SearchType()
    {
      return [
        1 => "Monthly",
        2 => "Semi-Monthly",
        3 => "Once",
      ];
    }

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

    public function SearchEmployees() {

      return DB::connection('mysql2')->select("
        SELECT users.* FROM users
        LEFT JOIN role_user ON role_user.user_id = users.id
        WHERE role_user.role_id IN (2,4)
        ORDER BY users.first_name
      "); 

    }

    public function SearchEmployeeById($id) {
      $employee = DB::connection('mysql2')->select("SELECT * FROM users where id = $id");

      return $employee[0]->first_name.' '.$employee[0]->last_name;
    }

    public function SearchEmployeeId($id) {

      $employee = DB::connection('mysql2')->select("SELECT * FROM users where id = $id");

      return substr($employee[0]->created_at, 0, 4).'-'.sprintf("%04d", $employee[0]->id);

    }
}