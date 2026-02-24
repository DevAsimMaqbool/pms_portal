<?php

namespace App\Imports;

use App\Models\ProgramProfitability;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProgramProfitabilityImport implements ToCollection, WithHeadingRow
{
    protected $indicatorId;
    protected $formStatus;

    public function __construct($indicatorId, $formStatus)
    {
        $this->indicatorId = $indicatorId;
        $this->formStatus = $formStatus;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {

            // ✅ Validate each row
            $validator = Validator::make($row->toArray(), [
                'faculty_id'     => 'required|integer',
                'department_id'     => 'required|integer',
                'program_id'     => 'required|integer',
                'program_level'  => 'required|in:UG,PG',
                'profitability' => 'nullable',
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

            // 🔁 Optional: Prevent duplicate entry
            $exists = ProgramProfitability::where('faculty_id', $row['faculty_id'])->where('department_id', $row['department_id'])
                ->where('program_id', $row['program_id'])->where('program_level', $row['program_level'])
                ->where('indicator_id', $this->indicatorId)
                ->exists();

            if ($exists) {
                continue;
            }

            // ✅ Save data
            ProgramProfitability::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,

                'department_id' => $row['department_id'],
                'faculty_id' => $row['faculty_id'],
                'program_id' => $row['program_id'],
                'program_level' => $row['program_level'],
                'profitability' => $row['profitability'],

                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
