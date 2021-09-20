<?php

namespace Drupal\nasa_pod\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\nasa_pod\Service\NasaClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class NasaAstroController.
 */
class NasaPodController extends ControllerBase {

  private $nasaClient;

  public function __construct(NasaClient $nasaClient){

    $this->nasaClient = $nasaClient;
  }

  public static function create(ContainerInterface $container) {
    $nasaClient = $container->get('nasa_client');

    return new static($nasaClient);
  }
  /**
   * Showastropick.
   *
   * @return array
   */
  public function showAstroPic() {
    $pod = $this->nasaClient->getImageDetails();

    $build = [
      '#theme' => 'nasa_pod_detail',
      '#type' => 'markup',
      '#url' => ['#markup' => $pod['url']],
      '#date' => ['#markup' => $pod['date']],
      '#explanation' => ['#markup' => $pod['explanation']],
      '#media_type' => ['#markup' => $pod['media_type']],
    ];
    if($pod['media_type'] == 'image'){
      $build['#image'] = $pod['url'];
    }else{
      $build['#video'] = $pod['url'];
    }

    return $build;
  }

}
