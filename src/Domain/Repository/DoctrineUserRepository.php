<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 19:09
 */

namespace Jimmy\Yap\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Jimmy\Yap\Domain\Contracts\Repository\UserRepositoryInterface;
use Jimmy\Yap\Domain\Entity\User;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }
}