<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(15);
        return view('admin.pages.notifications_list.index',compact('notifications'));
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->where('id',$id)->first();
        return view('admin.pages.notifications_list.show',compact('notification'));
    }
}
