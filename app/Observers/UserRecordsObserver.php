<?php

namespace App\Observers;

use App\Models\UserRecords;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserRecordsObserver
{
    /**
     * Handle the UserRecords "created" event.
     *
     * @param \App\Models\UserRecords $userRecords
     * @return void
     */
    public function created(UserRecords $userRecords)
    {
        try {
            $mail_text = '';
            foreach ($userRecords->toArray() as $record => $value) {
                $mail_text .= $record . ': ' . $value."\r\n\r\n";
            }
            Mail::raw($mail_text, function ($message) {
                $message->to(env('MAIL_FROM_ADDRESS'))
                        ->subject('Новая запись');
            });
            Log::info('Email sent success');
        } catch (\Exception $e) {
            Log::info('Email sent error: ' . $e->getMessage());
        }
    }

    /**
     * Handle the UserRecords "updated" event.
     *
     * @param \App\Models\UserRecords $userRecords
     * @return void
     */
    public function updated(UserRecords $userRecords)
    {
        //
    }

    /**
     * Handle the UserRecords "deleted" event.
     *
     * @param \App\Models\UserRecords $userRecords
     * @return void
     */
    public function deleted(UserRecords $userRecords)
    {
        //
    }

    /**
     * Handle the UserRecords "restored" event.
     *
     * @param \App\Models\UserRecords $userRecords
     * @return void
     */
    public function restored(UserRecords $userRecords)
    {
        //
    }

    /**
     * Handle the UserRecords "force deleted" event.
     *
     * @param \App\Models\UserRecords $userRecords
     * @return void
     */
    public function forceDeleted(UserRecords $userRecords)
    {
        //
    }
}
