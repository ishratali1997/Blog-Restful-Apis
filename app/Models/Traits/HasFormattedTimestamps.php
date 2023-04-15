<?php

namespace App\Models\Traits;

trait HasFormattedTimestamps
{
    protected function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    protected function getUpdatedDateAttribute()
    {
        return $this->updated_at->format('Y-m-d');
    }
}
