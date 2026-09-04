<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateModals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $userId,
        public $activeRoleId,
        public $currentYearId,
        public $activeRoleName,
        )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

         if (in_array($this->activeRoleName, [
            'Teacher',
            'Assistant Professor',
            'Associate Professor',
            'Professor',
        ])) {
            $data = NumberOfKnowledgeProduct($this->userId, $this->activeRoleId, $this->currentYearId);
            $scopusData = ScopusPublicationsNew($this->userId, $this->activeRoleId, 128, 2, 5,$this->currentYearId);
            $data2= calculateJournalQuartile($this->userId, $this->activeRoleId, 128,$this->currentYearId);
            $data1= calculateInternationalScore($this->userId, $this->activeRoleId, 128, $this->currentYearId);
            $data3 = MultidisciplinaryProjects($this->userId, $this->activeRoleId, 136, $this->currentYearId);
            $noofGrantsWon = noofGrantsWon($this->userId, $this->activeRoleId, 'Submitted', 135, $this->currentYearId);
        }
         if (in_array($this->activeRoleName, [
            'Teacher',
            'Assistant Professor',
            'Associate Professor',
            'Professor',
            'Program Leader UG',
            'Program Leader PG'
        ])) {
            $feedbacks = ResearchTasksAssignedbyDeanHOD($this->userId, $this->activeRoleId ,$this->currentYearId);
        }
    }
}
