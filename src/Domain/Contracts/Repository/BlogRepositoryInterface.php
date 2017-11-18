<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 20:21
 */

namespace Jimmy\Yap\Domain\Contracts\Repository;


use Jimmy\Yap\Domain\Entity\Blog;

interface BlogRepositoryInterface
{
    /**
     * @param $id
     * @return Blog
     */
    public function findById($id);

    /**
     * @param $author
     * @return Blog
     */
    public function findByAuthor($author);

    /**
     * @param $isDeleted
     * @return Blog
     */
    public function findByState($isDeleted);
}