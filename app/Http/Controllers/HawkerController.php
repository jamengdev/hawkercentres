<?php

namespace App\Http\Controllers;

use App\Models\Hawkers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HawkerController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'hawkers' => Hawkers::all()
        ]);
    }

    public function show(Hawkers $hawker)
    {
        return Inertia::render('Hawker', [
            'hawker' => $hawker,
            'isOpenNow' => $hawker->isOpenNow(),
            'nextScheduledCleaningDate' => $hawker->nextScheduledCleaningDate()->format('d M Y, D')
        ]);
    }
}
