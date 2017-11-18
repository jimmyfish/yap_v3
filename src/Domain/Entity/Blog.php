<?php

/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 18:27
 */

namespace Jimmy\Yap\Domain\Entity;

/**
 * Class Blog
 * @package Jimmy\Yap\Domain\Entity
 * @Entity(repositoryClass="Jimmy\Yap\Domain\Repository\DoctrineBlogRepository")
 * @HasLifecycleCallbacks
 * @Table(name="blog")
 */
class Blog
{
    /**
     * @Id
     * @var int
     * @GeneratedValue
     * @Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", nullable=false, length=255)
     */
    private $title;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Column(type="text", nullable=false, length=65535)
     */
    private $contents;

    /**
     * @var int
     * @ManyToOne(targetEntity="Jimmy\Yap\Domain\Entity\User")
     * @JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var int
     * @Column(type="integer", nullable=false, name="is_deleted")
     */
    private $isDeleted;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return int
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getisDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param int $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }
}