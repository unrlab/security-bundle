<?php
/**
 * Created by IntelliJ IDEA.
 * User: dj3
 * Date: 27/12/15
 * Time: 03:04
 */

namespace UnrLab\SecurityBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UnrLab\SecurityBundle\Entity\BaseUser;
use UnrLab\SecurityBundle\Model\SecurityUser;

class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $objectManager;
    private $repository;

    public function __construct(EntityManagerInterface $manager, $repository)
    {
        $this->objectManager = $manager;
        $this->repository = $repository;
    }

    /**
     * @param $token
     * @param $repository
     * @return BaseUser
     */
    public function loadUserByToken($token, $repository)
    {
        return $this->objectManager->getRepository($repository)->findOneBy(array('accessToken' => $token));
    }

    public function loadUserByKeyAndUsername($key, $username, $repository)
    {
        return $this->objectManager->getRepository($repository)->findOneBy(array(
            'publicKey' => $key,
            'username'  => $username
        ));
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        return $this->objectManager->getRepository($this->repository)->findOneBy(array('username' => $username));
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class instanceof SecurityUser;
    }
}