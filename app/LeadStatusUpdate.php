<?php

namespace App;

class LeadStatusUpdate extends BaseModel
{
    public function statusName(){
        return Lead::getStatusText($this->new_status);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
