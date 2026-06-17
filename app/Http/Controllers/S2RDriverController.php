<?php

namespace App\Http\Controllers;

use App\Models\S2RDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class S2RDriverController extends Controller
{
    public function index()
    {
        return view('admin.s2r-drivers.index');
    }
    /**
     * Datatable Listing
     */
    public function list(Request $request)
    {
        try {

            if ($request->ajax()) {

                $drivers = S2RDriver::latest();

                return DataTables::of($drivers)

                    ->addIndexColumn()

                    ->editColumn('status', function ($row) {

                        return $row->status == 'Active'
                            ? '<span class="badge bg-label-success">Active</span>'
                            : '<span class="badge bg-label-danger">Inactive</span>';
                    })

                    ->addColumn('action', function ($row) {

                        return '
                            <button type="button"
                                class="btn btn-icon btn-text-secondary rounded-pill waves-effect item-edit editBtn"
                                data-id="' . $row->id . '">
                               <i class="icon-base ti tabler-pencil"></i>
                            </button>

                            <button type="button"
                                class="btn btn-icon btn-text-secondary rounded-pill waves-effect item-edit deleteBtn"
                                data-id="' . $row->id . '">
                                <i class="icon-base ti tabler-trash"></i>
                            </button>
                        ';
                    })

                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

        } catch (\Exception $e) {

            Log::error('S2R Driver List Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unable to load records.'
            ], 500);
        }
    }

    /**
     * Store Record
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'driver_name' => 'required|string|max:255|unique:s2_r_drivers,driver_name',
                'status'      => 'required|in:Active,Inactive'
            ]);

            S2RDriver::create([
                'driver_name' => trim($validated['driver_name']),
                'slug'        => Str::slug($validated['driver_name']),
                'status'      => $validated['status']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Driver created successfully.'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('S2R Driver Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create driver.'
            ], 500);
        }
    }

    /**
     * Show Single Record
     */
    public function show(string $id)
    {
        try {

            $driver = S2RDriver::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $driver
            ]);

        } catch (\Exception $e) {

            Log::error('S2R Driver Show Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ], 404);
        }
    }

    /**
     * Update Record
     */
    public function update(Request $request, string $id)
    {
        try {

            $driver = S2RDriver::findOrFail($id);

            $validated = $request->validate([
                'driver_name' => 'required|string|max:255|unique:s2_r_drivers,driver_name,' . $driver->id,
                'status'      => 'required|in:Active,Inactive'
            ]);

            $driver->update([
                'driver_name' => trim($validated['driver_name']),
                'slug'        => Str::slug($validated['driver_name']),
                'status'      => $validated['status']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Driver updated successfully.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('S2R Driver Update Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update driver.'
            ], 500);
        }
    }

    /**
     * Delete Record
     */
    public function destroy(string $id)
    {
        try {

            $driver = S2RDriver::findOrFail($id);

            $driver->delete();

            return response()->json([
                'success' => true,
                'message' => 'Driver deleted successfully.'
            ]);

        } catch (\Exception $e) {

            Log::error('S2R Driver Delete Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete driver.'
            ], 500);
        }
    }
}
