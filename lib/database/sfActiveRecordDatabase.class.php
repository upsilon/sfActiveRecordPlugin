<?php
/*
 * This file is part of the sfActiveRecordPlugin package.
 * (c) Kimura Youichi <kim.upsilon@bucyou.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A symfony database driver for php-activerecord.
 *
 * @package    sfActiveRecordPlugin
 * @subpackage database
 * @author     Kimura Youichi <kim.upsilon@bucyou.net>
 */
class sfActiveRecordDatabase extends sfDatabase
{
  public function initialize($parameters = null)
  {
    parent::initialize($parameters);

    $cfg = ActiveRecord\Config::instance();

    $name = $this->getParameter('name');

    $connections = $cfg->get_connections();
    $connections[$name] = $this->getParameter('dsn');
    $cfg->set_connections($connections);
  }

  public function connect()
  {
    ActiveRecord\ConnectionManager::get_connection($this->getParameter('name'));
  }

  public function shutdown()
  {
    ActiveRecord\ConnectionManager::drop_connection($this->getParameter('name'));
  }
}
