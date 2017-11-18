<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 20:46
 */

namespace Jimmy\Yap\Domain\Contracts\Repository;


interface PromoRepositoryInterface
{
    public function findById($id);

    public function findByAuthor($author);

    public function findByState($isDeleted);
}