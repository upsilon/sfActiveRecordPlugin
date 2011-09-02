<?php
/*
 * This file is part of the sfActiveRecordPlugin package.
 * (c) Kimura Youichi <kim.upsilon@bucyou.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * php-activerecord pager class.
 *
 * @package    sfActiveRecordPlugin
 * @subpackage pager
 * @author     Kimura Youichi <kim.upsilon@bucyou.net>
 */
class sfActiveRecordPager extends sfPager
{
  protected
    $findParams = array();

  public function setFindParams(/* ... */)
  {
    $this->findParams = func_get_args();
  }

  public function getFindParams()
  {
    return $this->findParams;
  }

  public function init()
  {
    $this->resetIterator();

    $this->setNbResults(call_user_func_array(
      array($this->getClass(), 'count'),
      $this->getFindParams()
    ));
  }

  public function getResults()
  {
    return call_user_func_array(
      array($this->getClass(), 'find'),
      array_merge($this->getFindParams(), array('all', 'offset' => ($this->getPage() - 1) * $this->getMaxPerPage(), 'limit' => $this->getMaxPerPage()))
    );
  }

  protected function retrieveObject($offset)
  {
    return call_user_func_array(
      array($this->getClass(), 'find'),
      array_merge($this->getFindParams(), array('offset' => $offset - 1, 'limit' => 1))
    );
  }
}
