<?php

namespace Devpro\Tests\Common\DataFixtures;

include_once __DIR__.'/../../Entity/DummyEntity.php';

/**
 * Test CsvFixtureHelper.
 *
 * @package    Devpro
 * @subpackage Tests
 * @author     Bertrand THOMAS <bertrand@iocean.fr>
 */
class CsvFixtureHelperTest extends \PHPUnit_Framework_TestCase
{
  public function testCreateEntitiesCasNominal()
  {
    $fixtureHelper = $this->getMockClass('Devpro\Common\DataFixtures\CsvFixtureHelper', array('readFile'));
    $fixtureHelper::staticExpects($this->any())
      ->method('readFile')
      ->with($this->equalTo('tmp/dummy.txt'))
      ->will($this->returnValue(array('Name;', 'Toto;', 'Titi;')));

    $result = $fixtureHelper::createEntities('Devpro\Tests\Entity\DummyEntity', array('Name'), 'tmp/dummy.txt');

    $this->assertEquals(2,                                 count($result));
    $this->assertEquals('Devpro\Tests\Entity\DummyEntity', get_class($result[0]));
    $this->assertEquals('Toto',                            $result[0]->getName());
    $this->assertEquals('Devpro\Tests\Entity\DummyEntity', get_class($result[1]));
    $this->assertEquals('Titi',                            $result[1]->getName());
  }
}
