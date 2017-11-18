<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 19:16
 */

namespace Jimmy\Yap\Domain\Contracts\Repository;

use Jimmy\Yap\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username);
}