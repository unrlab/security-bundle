<?php
/**
 * Created by IntelliJ IDEA.
 * User: dj3
 * Date: 27/12/15
 * Time: 03:03
 */

namespace UnrLab\SecurityBundle\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UnrLab\SecurityBundle\Model\SecurityUser;

class UserProviderTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function getClient()
    {
        if (!$this->client) {
            $this->client = static::createClient(array('env' => 'test'));
        }

        return $this->client;
    }

    protected function mockService($service, $class, array $methodsAndResult)
    {
        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($methodsAndResult as $method => $result) {
            $mock
                ->expects($this->once())
                ->method($method)
                ->will($this->returnValue($result));
        }

        $this->getClient()->getContainer()->set($service, $mock);
    }

    public function testLoadUserByUsernameShouldReturnAValidUser()
    {
        $mockUSer = new SecurityUser('user', 'public_key');
        $this->mockService(
            'unrlab_user.provider',
            'UnrLab\SecurityBundle\Service\UserProvider',
            array('loadUserByUsername' => $mockUSer)
        );
        $user = $this->getClient()->getContainer()->get('unrlab_user.provider')->loadUserByUsername('user');
        $this->assertTrue($user instanceof SecurityUser);
    }

    public function testLoadUserByUsernameShouldReturnNull()
    {
        $this->mockService(
            'unrlab_user.provider',
            'UnrLab\SecurityBundle\Service\UserProvider',
            array('loadUserByUsername' => null)
        );
        $user = $this->getClient()->getContainer()->get('unrlab_user.provider')->loadUserByUsername('user');
        $this->assertNull($user);
    }
}