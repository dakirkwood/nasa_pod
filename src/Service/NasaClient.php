<?php

namespace Drupal\nasa_pod\Service;

use Drupal\Component\Serialization\Json;

/**
 * Class NasaClient.
 */
class NasaClient {

  /**
   * @var \GuzzleHttp\Client
   */

  protected $client;

  /**
   * UntEventsClient constructor
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */

  public function __construct(\Drupal\Core\Http\ClientFactory $http_client_factory){
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'https://api.nasa.gov'
    ]);
  }

  /**
   * Show just the media of NASA's Pic of the Day
   *
   * @param string $apiKey
   *
   * @return array
   */
  public function getImage($apiKey = 'bZhHJftjIdrpFAeN1azSEBuLPg0vwEhmRxCwdzoK'){
    $response = $this->client->get('planetary/apod', [
      'query' => [
        'api_key' => $apiKey,
      ],
    ]);
    return Json::decode($response->getBody());
  }

  /**
   * Show all of the details of NASA's Pic of the Day
   *
   * @param string $apiKey
   *
   * @return array
   */
  public function getImageDetails($apiKey = 'bZhHJftjIdrpFAeN1azSEBuLPg0vwEhmRxCwdzoK'){
    $response = $this->client->get('planetary/apod', [
      'query' => [
        'api_key' => $apiKey,
      ],
    ]);

    return Json::decode($response->getBody());

  }

}
