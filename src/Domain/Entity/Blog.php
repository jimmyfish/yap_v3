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
    private $content;

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
    private $isDeleted = 0;

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

    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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

    /**
     * @var int
     * @Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @return int
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param int $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}