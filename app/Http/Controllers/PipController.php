<?php

namespace App\Http\Controllers;

use App\Models\Pip;
use App\Models\PipAssignUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $employeeId = Auth::user()->employee_id;

            if ($request->ajax()) {

                
                $pips = Pip::with('assignUsers.user')
                    ->where('created_by', $employeeId)
                    ->latest()
                    ->get();    
                return response()->json($pips);
            }

            $facultyMembers = User::with('roles')
                ->where('manager_id', $employeeId)
                ->get([
                    'id',
                    'name',
                    'department',
                    'job_title'
                ]);

            return view('admin.table.pip', compact('facultyMembers'));

        } catch (\Exception $e) {

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

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
        DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [

                'description'=>'required',

                'status'=>'required|in:not_started,inprogress,completed',

                'faculty_member_id'=>'required|array',

                'faculty_member_id.*'=>'exists:users,id',

                'document'=>'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'

            ]);

            if($validator->fails()){

                return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                ],422);

            }

            $employeeId = Auth::user()->employee_id;

            $data = [

                'description'=>$request->description,

                'status'=>$request->status,

                'created_by'=>$employeeId,

                'updated_by'=>$employeeId

            ];

            if($request->hasFile('document')){

                $data['document']=$request
                    ->file('document')
                    ->store('pip','public');

            }

            $pip = Pip::create($data);

            foreach($request->faculty_member_id as $user){

                PipAssignUser::create([

                    'pip_id'=>$pip->id,

                    'user_id'=>$user,

                    'status'=>$request->status

                ]);

            }

            DB::commit();

            return response()->json([

                'status'=>true,

                'message'=>'PIP Created Successfully.'

            ]);

        } catch (\Exception $e){

            DB::rollBack();

            return response()->json([

                'status'=>false,

                'message'=>$e->getMessage()

            ],500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{

            $pip = Pip::with('assignUsers')
                ->findOrFail($id);

            $pip->faculty_member_id = $pip
                ->assignUsers
                ->pluck('user_id');

            return response()->json($pip);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
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
     public function update(Request $request,$id)
    {
        DB::beginTransaction();

        try{

            $validator=Validator::make($request->all(),[

                'description'=>'required',

                'status'=>'required|in:not_started,inprogress,completed',

                'faculty_member_id'=>'required|array',

                'faculty_member_id.*'=>'exists:users,id',

                'document'=>'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'

            ]);

            if($validator->fails()){

                return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                ],422);

            }

            $employeeId=Auth::user()->employee_id;

            $pip=Pip::findOrFail($id);

            $data=[

                'description'=>$request->description,

                'status'=>$request->status,

                'updated_by'=>$employeeId

            ];

            if($request->hasFile('document')){

                if($pip->document &&
                    Storage::disk('public')->exists($pip->document)){

                    Storage::disk('public')
                        ->delete($pip->document);

                }

                $data['document']=$request
                    ->file('document')
                    ->store('pip','public');

            }

            $pip->update($data);

            PipAssignUser::where('pip_id',$pip->id)->delete();

            foreach($request->faculty_member_id as $user){

                PipAssignUser::create([

                    'pip_id'=>$pip->id,

                    'user_id'=>$user,

                    'status'=>$request->status

                ]);

            }

            DB::commit();

            return response()->json([

                'status'=>true,

                'message'=>'PIP Updated Successfully.'

            ]);

        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try{

            $pip=Pip::findOrFail($id);

            if($pip->document &&
                Storage::disk('public')->exists($pip->document)){

                Storage::disk('public')
                    ->delete($pip->document);

            }

            PipAssignUser::where(
                'pip_id',
                $pip->id
            )->delete();

            $pip->delete();

            DB::commit();

            return response()->json([

                'status'=>true,

                'message'=>'PIP Deleted Successfully.'

            ]);

        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }

     /**
     * Display a listing of the resource.
     */
    public function getDate(Request $request)
    {
        try {

            $employeeId = Auth::user()->employee_id;

            if ($request->ajax()) {

            $pips = Pip::with('assignUsers.user')
                ->whereHas('assignUsers', function ($query) use ($employeeId) {
                    $query->where('user_id', $employeeId);
                })
                ->latest()
                ->get();

            return response()->json($pips);
        }


        } catch (\Exception $e) {

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }
    public function updateStatus(Request $request, $id)
    {
        try {

            $employeeId = Auth::user()->employee_id;

            $assignUser = PipAssignUser::where('pip_id', $id)
                ->where('user_id', $employeeId)
                ->firstOrFail();

            $assignUser->status = $request->status;

            $assignUser->save();

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

}
