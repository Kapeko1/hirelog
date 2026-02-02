<?php

namespace App\Observers;

use App\Models\ApplicationStatusHistory;
use App\Models\WorkApplication;

class WorkApplicationObserver
{
    /**
     * Handle the WorkApplication "created" event.
     */
    public function created(WorkApplication $workApplication): void
    {
        // Log initial status when application is created
        ApplicationStatusHistory::create([
            'work_application_id' => $workApplication->id,
            'from_status' => null,
            'to_status' => $workApplication->status->value,
            'changed_at' => now(),
        ]);
    }

    /**
     * Handle the WorkApplication "updated" event.
     */
    public function updated(WorkApplication $workApplication): void
    {
        // Check if status has changed
        if ($workApplication->isDirty('status')) {
            $originalStatus = $workApplication->getOriginal('status');

            ApplicationStatusHistory::create([
                'work_application_id' => $workApplication->id,
                'from_status' => $originalStatus,
                'to_status' => $workApplication->status->value,
                'changed_at' => now(),
            ]);
        }
    }

    /**
     * Handle the WorkApplication "deleted" event.
     */
    public function deleted(WorkApplication $workApplication): void
    {
        //
    }

    /**
     * Handle the WorkApplication "restored" event.
     */
    public function restored(WorkApplication $workApplication): void
    {
        //
    }

    /**
     * Handle the WorkApplication "force deleted" event.
     */
    public function forceDeleted(WorkApplication $workApplication): void
    {
        //
    }
}
