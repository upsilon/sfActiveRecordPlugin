<?php
/*
 * This file is part of the sfActiveRecordPlugin package.
 * (c) Kimura Youichi <kim.upsilon@bucyou.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfWebDebugPanelActiveRecord extends sfWebDebugPanel
{
  public function getTitle()
  {
    if ($sqlLogs = $this->getSqlLogs())
    {
      return '<img src="'.$this->webDebug->getOption('image_root_path').'/database.png" alt="SQL queries" /> '.count($sqlLogs);
    }
  }

  public function getPanelTitle()
  {
    return 'SQL queries';
  }

  public function getPanelContent()
  {
    return '
      <div id="sfWebDebugDatabaseLogs">
        <h3>php-activerecord version: '.PHP_ACTIVERECORD_VERSION_ID.'</h3>
        <ol>'.implode("\n", $this->getSqlLogs()).'</ol>
      </div>
    ';
  }

  static public function listenToAddPanelEvent(sfEvent $event)
  {
    $event->getSubject()->setPanel('db', new self($event->getSubject()));
  }

  protected function getSqlLogs()
  {
    $html = array();

    foreach ($this->webDebug->getLogger()->getLogs() as $log)
    {
      if ('sfActiveRecordLogger' != $log['type'])
      {
        continue;
      }

      $query = $this->formatSql(htmlspecialchars($log['message'], ENT_QUOTES, sfConfig::get('sf_charset')));
      $backtrace = isset($log['debug_backtrace']) && count($log['debug_backtrace']) ? '&nbsp;'.$this->getToggleableDebugStack($log['debug_backtrace']) : '';

      $html[] = sprintf('
        <li>
          <p class="sfWebDebugDatabaseQuery">%s</p>
          <div class="sfWebDebugDatabaseLogInfo">%s</div>
        </li>',
        $query,
        $backtrace
      );
    }

    return $html;
  }
}
