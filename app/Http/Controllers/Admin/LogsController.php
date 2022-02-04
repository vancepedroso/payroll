<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class LogsController extends Controller
{
  public function index()
  {
    $logs = Logs::orderBy('id','DESC')->get();
    return view('admin.logs.index', compact('logs'));
  }

  public function massDestroy()
  {
    Logs::truncate();
    Logs::create([
      'action' => 'Cleared Logs',
      'user_id' => auth()->user()->id
    ]);
    return $this->index();
  }
}