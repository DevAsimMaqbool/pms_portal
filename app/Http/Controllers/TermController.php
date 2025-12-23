<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class TermController extends Controller
{
     public function index()
    {
        return view('admin.terms.index');
    }

    // DataTables AJAX
    public function getTerms(Request $request)
    {
        if ($request->ajax()) {
            $data = Term::latest()->get();
            return FacadesDataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_text', function($row){
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editTerm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteTerm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required|in:Spring,Fall',
            'start_year' => 'required|integer|min:1900',
            'end_year' => 'required|integer|min:1900|gte:start_year',
            'status' => 'required|in:0,1',
        ]);

        Term::create([
            'term' => $request->term,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success'=>'Term added successfully.']);
    }

    public function edit($id)
    {
        $term = Term::findOrFail($id);
        return response()->json($term);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'term' => 'required|in:Spring,Fall',
            'start_year' => 'required|integer|min:1900',
            'end_year' => 'required|integer|min:1900|gte:start_year',
            'status' => 'required|in:0,1',
        ]);

        $term = Term::findOrFail($id);
        $term->update([
            'term' => $request->term,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['success'=>'Term updated successfully.']);
    }

    public function destroy($id)
    {
        Term::findOrFail($id)->delete();
        return response()->json(['success'=>'Term deleted successfully.']);
    }
}
