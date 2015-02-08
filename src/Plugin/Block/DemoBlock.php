<?php
/**
 * @file
 * Contains \Drupal\demo\Plugin\Block\DemoBlock.
 */

namespace Drupal\demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

  /**
   * Provides a 'Demo' block.
   *
   * @Block(
   *   id = "demo_block",
   *   admin_label = @Translation("Demo block"),
   * )
   */
class DemoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (isset($config['demo_block_settings']) && !empty($config['demo_block_settings'])) {
      $name = $config['demo_block_settings'];
    }
    else {
      $name = $this->t('to no one');
    }

    return array(
        '#markup' => $this->t('Hello @name!', array('@name' => $name)),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    return $account->hasPermission('access content');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface &$form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['demo_block_settings'] = array(
      '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#description' => $this->t('Name of the guy whom you want to greet'),
        '#default_value' => isset($config['demo_block_settings']) ? $config['demo_block_settings'] : '',
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->setConfigurationValue('demo_block_settings', $form_state['values']['demo_block_settings']);

  }
}
