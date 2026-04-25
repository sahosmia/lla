<?php

namespace Modules\MeetFusion\Contracts;

interface MeetFusionDriverInterface
{
    public function createMeeting(array $params);
}
