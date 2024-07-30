<?php

namespace App\Observers;

use App\Models\Follower;
use Illuminate\Support\Str;

class FollowerObserver
{
    /**
    * Handle the Product "created" event.
    *
    * @param  \App\Models\Follower $follower
    * @return void
    */
    public function creating(Follower $follower)
    {
        $follower->uuid = (string) Str::uuid();
    }

    /**
     * Handle the Follower "created" event.
     */
    public function created(Follower $follower): void
    {
        //
    }

    /**
     * Handle the Follower "updated" event.
     */
    public function updated(Follower $follower): void
    {
        //
    }

    /**
     * Handle the Follower "deleted" event.
     */
    public function deleted(Follower $follower): void
    {
        //
    }

    /**
     * Handle the Follower "restored" event.
     */
    public function restored(Follower $follower): void
    {
        //
    }

    /**
     * Handle the Follower "force deleted" event.
     */
    public function forceDeleted(Follower $follower): void
    {
        //
    }
}
