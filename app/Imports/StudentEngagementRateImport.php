<?php

namespace App\Imports;

use App\Models\StudentEngagementRate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentEngagementRateImport implements ToCollection, WithHeadingRow
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

             // Convert event_location string to array
            $eventLocation = null;
            if (!empty($row['event_location'])) {
                $eventLocation = array_map('trim', explode(',', $row['event_location']));
            }

            // ✅ Validate each row
            $validator = Validator::make($row->toArray(), [
                // Engagement
                    'nature_of_event' => 'required|string',
                    'other_event_detail' => 'nullable|string',
                    'event_location' => 'nullable|string',
                    'scope_of_the_event' => 'required|string',

                    // Event Details
                    'title_of_the_event' => 'nullable|string',
                    'brief_description_of_activity' => 'nullable|string',
                    'event_start_date' => 'required',
                    'event_end_date'   => 'required',

                    // Program Info
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',

                    // Participation
                    'participation_target' => 'nullable|integer',
                    'number_of_students_participated' => 'nullable|integer',
                    'employer_satisfaction' => 'required',
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }


           

            // ✅ Save data
            StudentEngagementRate::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,

                'nature_of_event' => $row['nature_of_event'],
                'other_event_detail' => $row['other_event_detail'],
                'event_location' => $eventLocation,
                'scope_of_the_event' => $row['scope_of_the_event'],

                // Event Details
                'title_of_the_event' => $row['title_of_the_event'],
                'brief_description_of_activity' => $row['brief_description_of_activity'],
                'event_start_date' => is_numeric($row['event_start_date'])
                    ? Date::excelToDateTimeObject($row['event_start_date'])->format('Y-m-d')
                    : $row['event_start_date'],
                'event_end_date' => is_numeric($row['event_end_date'])
                    ? Date::excelToDateTimeObject($row['event_end_date'])->format('Y-m-d')
                    : $row['event_end_date'],    

                // Program Info
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'program_id' => $row['program_id'],

                // Participation
                'participation_target' => $row['participation_target'],
                'number_of_students_participated' => $row['number_of_students_participated'],
                'employer_satisfaction' => $row['employer_satisfaction'],

                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
