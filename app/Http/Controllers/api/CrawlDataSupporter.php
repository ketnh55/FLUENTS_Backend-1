<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 5/19/2019
 * Time: 9:41 AM
 */

namespace App\Http\Controllers\api;


use Illuminate\Support\Facades\Input;
use GuzzleHttp\Client;
Trait CrawlDataSupporter
{
    private $CRAWL_DATA_URL = 'https://python-api.fluents.app/api/social-data/add-new-platform';
    private $ERROR_CODE = 500;
    public function crawlSnsData()
    {
        $body = [
            'platform_id' => Input::get('sns_account_id'),
            'sns_access_token' => Input::get('sns_access_token'),
            'social_type' => (int)Input::get('social_type'),
            'secret_token' => Input::get('secret_token')
        ];

        $client = new Client();
        try{
            $response = $client->request('POST', $this->CRAWL_DATA_URL, ['json' => $body]);
            return $response->getStatusCode();
        }
        catch (\Exception $e){
            return $this->ERROR_CODE;
        }


    }
}