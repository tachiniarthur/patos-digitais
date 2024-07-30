<?php

namespace App\Observers;

use App\Models\Reaction;
use Illuminate\Support\Str;

class ReactionObserver
{
    /**
    * Handle the Product "created" event.
    *
    * @param  \App\Models\Reaction $reaction
    * @return void
    */
    public function creating(Reaction $reaction)
    {
        $reaction->uuid = (string) Str::uuid();
    }

    /**
     * Handle the Reaction "created" event.
     */
    public function created(Reaction $reaction): void
    {
        //
    }

    /**
     * Handle the Reaction "updated" event.
     */
    public function updated(Reaction $reaction): void
    {
        //
    }

    /**
     * Handle the Reaction "deleted" event.
     */
    public function deleted(Reaction $reaction): void
    {
        //
    }

    /**
     * Handle the Reaction "restored" event.
     */
    public function restored(Reaction $reaction): void
    {
        //
    }

    /**
     * Handle the Reaction "force deleted" event.
     */
    public function forceDeleted(Reaction $reaction): void
    {
        //
    }
}
