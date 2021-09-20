<?php

namespace Drupal\nasa_pod\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'NasaAstroBlock' block.
 *
 * @Block(
 *  id = "nasa_astro_block",
 *  admin_label = @Translation("NASA Astronomy Block"),
 *  context_definitions = {
 *    "node" = @ContextDefinition ("entity:node", label = @Translation ("Node"), required = FALSE,)
 *   }
 * )
 */
class NasaPodBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\nasa_pod\Service\NasaClient
   */
  protected $nasaClient;

  /**
   * UntEvents constructor
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $nasa_client \Drupal\nasa_pod\Service\NasaClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\nasa_pod\Service\NasaClient $nasa_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->nasaClient = $nasa_client;
  }

  /**
   * {@inheritdoc }
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('nasa_client')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $pic = $this->nasaClient->getImage();
    $build = [];
    $build = [
      '#theme' => 'nasa_pod_block',
      '#date' => $pic['date'],
      '#title' => $pic['title'],
      '#url' => $pic['url'],
      '#explanation' => $pic['explanation'],
      '#media_type' => $pic['media_type'],
    ];
    if($pic['media_type'] == 'image'){
      $build['#image'] = $pic['url'];
    }else{
      $build['#video'] = $pic['url'];
    }

    return $build;
  }

}
