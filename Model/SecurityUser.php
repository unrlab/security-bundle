<?php
/**
 * Created by IntelliJ IDEA.
 * User: dj3
 * Date: 27/12/15
 * Time: 03:09
 */

namespace UnrLab\SecurityBundle\Model;


use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    public function __construct($username, $publicKey)
    {
        $this->username = $username;
        $this->publicKey = $publicKey;
    }
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return null
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return md5(microtime());
    }

    /**
     * @return string
     */
    public function generateAccessToken()
    {
        $this->accessToken = strtoupper(hash_hmac('sha512', $this->username, $this->getSalt(), false));

        return $this->getAccessToken();
    }

    /**
     * @return string
     */
    public function generatePublicKey()
    {
        return strtoupper(hash_hmac('sha256', $this->username, $this->getSalt(), false));
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     * @return null
     */
    public function eraseCredentials()
    {
        return null;
    }
}