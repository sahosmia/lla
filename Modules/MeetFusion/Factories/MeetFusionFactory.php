<?php

namespace Modules\MeetFusion\Factories;

use Modules\MeetFusion\Drivers\Zoom;
class MeetFusionFactory {
     
    /**
      * @return \Modules\MeetFusion\Drivers\Zoom
    */

    public function zoom(): Zoom{
        return new Zoom();
    }


    /**
     * @return array $supportedConferences
     */
     public function supportedConferences() : array{
        return [
            'zoom' => [
                'keys' => [
                    'account_id' => __('meetfusion::meetfusion.join_meeting'),
                    'client_id' => '',
                    'client_secret' => '',
                ],
                'status' => 'off'
            ],
        ];
    }
}
