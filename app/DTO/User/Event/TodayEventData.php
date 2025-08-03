<?php

namespace App\DTO\User\Event;

use Spatie\DataTransferObject\DataTransferObject;

class TodayEventData extends DataTransferObject
{
    public int $userID;
}
