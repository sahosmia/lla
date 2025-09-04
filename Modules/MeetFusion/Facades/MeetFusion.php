<?php

namespace Modules\MeetFusion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static \Modules\MeetFusion\Drivers\Zoom zoom()
 * @method static \Modules\MeetFusion\Drivers\GoogleMeet google_meet()
 * @method static array supportedConferences()
 */

class MeetFusion extends Facade {

    protected static function getFacadeAccessor(): string
    {
        return 'meetfusion';
    }
}
