<?php


namespace App\Actions\Statistics;


use App\Models\LinkStatistic;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class ViewLinkStatistics
{
    public function get( LinkStatistic $statistic )
    {
        $agent = $this->createAgent( $statistic );

        return [
            'referer'    => $statistic->referer,
            'shortlink'  => Str::finish( config( 'app.url' ), '/' ) . $statistic->slug,
            'to'         => $statistic->to,
            'ip_address' => $statistic->ip_address,
            'success'    => $statistic->success,
            'agent'      => [
                'platform' => [
                    'name'    => $agent->platform(),
                    'version' => $agent->version( $agent->platform() )
                ],
                'browser'  => [
                    'name'    => $agent->browser(),
                    'version' => $agent->version( $agent->browser(), )
                ],
                'device'   => [
                    'name'    => $agent->device(),
                    'type' => $agent->deviceType()
                ],
            ],
        ];
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param LinkStatistic $statistic
     *
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent( LinkStatistic $statistic )
    {
        return tap( new Agent, function ( Agent $agent ) use ( $statistic ) {
            $agent->setUserAgent( $statistic->user_agent );
        } );
    }
}
