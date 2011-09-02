<?php
/*
 * This file is part of the sfActiveRecordPlugin package.
 * (c) Kimura Youichi <kim.upsilon@bucyou.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * php-activerecord SQL query logger class.
 *
 * @package    sfActiveRecordPlugin
 * @subpackage log
 * @author     Kimura Youichi <kim.upsilon@bucyou.net>
 */
class sfActiveRecordLogger
{
  protected $dispatcher;

  public function __construct(sfEventDispatcher $dispatcher = null)
  {
    if (null === $dispatcher)
    {
      $this->dispatcher = sfProjectConfiguration::getActive()->getEventDispatcher();
    }
    else
    {
      $this->dispatcher = $dispatcher;
    }
  }

  public function log($message, $severity = sfLogger::DEBUG)
  {
    $this->dispatcher->notify(new sfEvent($this, 'application.log', array($message, 'priority' => $severity)));
  }
}
