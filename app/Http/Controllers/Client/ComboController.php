<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;

class ComboController extends Controller
{
    public function index(Request $request)
    {
        $query = Combo::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }
if ($request->filled('price_range')) {
    switch ($request->price_range) {
        case 'under_2m':
            $query->where('real_price', '<', 2000000);
            break;
            
        case '2m_5m':
            $query->whereBetween('real_price', [2000000, 5000000]);
            break;
            
        case 'over_5m':
            $query->where('real_price', '>', 5000000);
            break;
    }
}


        $combos = $query->latest()->get();
        return view('client.combos.index', compact('combos'));
    }

    public function show($id)
    {
        $combo = Combo::findOrFail($id);
        return view('client.combos.show', compact('combo'));
    }
}