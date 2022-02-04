<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

  Route::get('/', 'HomeController@index')->name('home');

  // Permissions
  Route::resource('permissions', 'PermissionsController');

  // Roles
  Route::resource('roles', 'RolesController');

  // Users
  Route::resource('users', 'UsersController');

  // Logs
  Route::get('logs/destroy', 'LogsController@massDestroy')->name('logs.massDestroy');
  Route::get('logs', 'LogsController@index')->name('logs.index');

  // Employee
  Route::resource('employees', 'EmployeeController');

  // Employee Earnings
  Route::resource('employeeEarnings', 'EmployeeEarningsController');

  // Employee Deductions
  Route::resource('employeeDeduction', 'EmployeeDeductionController');

  // Incentives
  Route::resource('incentives', 'IncentiveController');

  // Payroll
  Route::post('payroll/calculate/{id}', 'PayrollController@calculate')->name('payroll.calculate');
  Route::resource('payroll', 'PayrollController');

  // Payroll Items
  Route::resource('payrollitems', 'PayrollItemsController');

  // Earnings
  Route::resource('earnings', 'EarningController');

  // Deduction
  Route::resource('deductions', 'DeductionController');

  // Employee
  Route::resource('employees', 'EmployeeController');

});