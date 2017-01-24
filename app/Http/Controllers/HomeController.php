<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use LabEquipment\Lab;
use LabEquipment\Equipment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::findAll();
        $labs = Lab::findAll();
        $equipments = Equipment::findAll();
        return view('admin.admin', compact('users', 'labs', 'equipments'));
    }
}
