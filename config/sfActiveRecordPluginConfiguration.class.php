<?php
/*
 * This file is part of the sfActiveRecordPlugin package.
 * (c) Kimura Youichi <kim.upsilon@bucyou.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfActiveRecordPlugin configuration class
 *
 * @package    sfActiveRecordPlugin
 * @subpackage config
 * @author     Kimura Youichi <kim.upsilon@bucyou.net>
 */
class sfActiveRecordPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    sfConfig::set('sf_orm', 'activerecord');

    require_once dirname(__FILE__).'/../lib/vendor/php-activerecord/ActiveRecord.php';

    $cfg = ActiveRecord\Config::instance();
    $cfg->set_model_directory(sfConfig::get('sf_lib_dir').'/model');
    $cfg->set_default_connection('activerecord');

    if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled'))
    {
      $cfg->set_logging(true);
      $cfg->set_logger(new sfActiveRecordLogger($this->dispatcher));
    }

    if (sfConfig::get('sf_web_debug'))
    {
      $this->dispatcher->connect('debug.web.load_panels', array('sfWebDebugPanelActiveRecord', 'listenToAddPanelEvent'));
    }

    $this->dispatcher->notify(new sfEvent($cfg, 'activerecord.configure'));
  }
}
