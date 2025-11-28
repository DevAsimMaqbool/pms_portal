<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndicatorCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug, $id)
    {
         try {
            $indicatorId = $id; // you can rename it if you like

            return view("admin.indicator_crud." . $slug, compact('indicatorId'));

        } catch (\Exception $e) {
            report($e);
            abort(500, 'Oops! Something went wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
