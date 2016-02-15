<?php

namespace UnrLab\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UnrLab\DomainBundle\Model\HalBuilder;
use UnrLab\SecurityBundle\Model\SecurityUser;
use JMS\Serializer\Annotation as JMS;

/**
 * BaseUser
 *
 * @ORM\MappedSuperclass
 */
class BaseUser extends SecurityUser
{
    use HalBuilder;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @JMS\Type("string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="public_key", type="string", length=255, unique=true)
     */
    protected $publicKey;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=255, nullable=true, unique=true)
     */
    protected $accessToken;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     * @JMS\Type("array")
     */
    private $roles;
    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @JMS\Type("string")
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @JMS\Type("string")
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", nullable=true)
     * @JMS\Type("string")
     */
    protected $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @JMS\Type("string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", nullable=true)
     * @JMS\Type("string")
     */
    protected $mobile;

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return BaseUser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return BaseUser
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return BaseUser
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return BaseUser
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return BaseUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set publicKey
     *
     * @param string $publicKey
     *
     * @return BaseUser
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return BaseUser
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return BaseUser
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}

