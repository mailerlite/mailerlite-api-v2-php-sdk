<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Api\Campaigns;

class CampaignsTest extends MlTestCase
{
    protected $campaignsApi;

    protected function setUp()
    {
        $this->campaignsApi = (new MailerLite(API_KEY))->campaigns();
    }

    /** @test **/
    public function create_campaign()
    {
        $campaignData = [
            'subject' => 'Regular Campaign Subject',
            'type' => 'regular',
            'groups' => [2984475, 3237221] // TODO: improve this with creating new groups
        ];

        $campaign = $this->campaignsApi->create($campaignData);

        $this->assertTrue($campaign->campaign_type == $campaignData['type']);

        $this->campaignsApi->delete($campaign->id);
    }

}