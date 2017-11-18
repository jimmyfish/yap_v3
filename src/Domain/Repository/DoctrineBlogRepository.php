<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 20:23
 */

namespace Jimmy\Yap\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Jimmy\Yap\Domain\Contracts\Repository\BlogRepositoryInterface;
use Jimmy\Yap\Domain\Entity\Blog;

class DoctrineBlogRepository extends EntityRepository implements BlogRepositoryInterface
{

    public function findById($id)
    {
        return $this->find($id);
    }

    public function findByAuthor($author)
    {
        return $this->findBy(['author' => $author]);
    }

    public function findByState($isDeleted)
    {
        return $this->findBy([
            'isDeleted' => $isDeleted
        ]);
    }
}