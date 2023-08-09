<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EntriesList;
use App\Models\Entries;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class EntriesListController extends Controller
{
    public function index()
    {
//        $entries = DB::table('entries')->get();
        $entries = Entries::all()->sortByDesc('purchase_date');

        return view('entries.index', compact('entries'));
    }
    public function store(Request $request)
    {
        // Validate and save user data
        $validatedData = $request->validate([
            'stock_name' => 'required|max:255',
            'investment' => 'required',
            'nav_value' => 'required',
            'total_nav' => 'required',
            'purchase_date' => 'required|date_format:d/m/Y',
        ]);
        $validatedMessage = 'Entry created successfully';


        Entries::create($validatedData);
        return response()->json(['message' => $validatedMessage]);
    }
    public function update(Request $request, $id)
    {
        // Validate and update user data
    }
    public function filter($request){
        $entries = DB::table('entries')->
        where('type','=',$request->get('type'))
            ->get();
    }
    public function destroy($id)
    {
        $user = EntriesList::findOrFail($id);
        $user->delete();
        return redirect('/entries');
    }


}
