<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 18:35
 */

namespace Jimmy\Yap\Domain\Entity;

/**
 * Class User
 * @package Jimmy\Yap\Domain\Entity
 * @Entity(repositoryClass="Jimmy\Yap\Domain\Repository\DoctrineUserRepository")
 * @HasLifecycleCallbacks
 * @Table(name="user")
 */
class User
{
    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var int
     * @Column(name="is_active", type="integer", length=2, nullable=false)
     */
    private $isActive;

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @var string
     * @Column(name="role", type="string", length=10, nullable=false)
     */
    private $role;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = sha1(md5($password));
    }

    /**
     * @return int
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param int $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false, name="first_name")
     */
    private $firstName;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true, name="last_name")
     */
    private $lastName;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}