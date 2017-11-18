<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 18/11/17
 * Time: 20:35
 */

namespace Jimmy\Yap\Domain\Entity;

/**
 * Class Promo
 * @package Jimmy\Yap\Domain\Entity
 * @Entity(repositoryClass="Jimmy\Yap\Domain\Repository\DoctrinePromoRepository")
 * @Table(name="promo")
 * @HasLifecycleCallbacks
 */
class Promo
{
    /**
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var int
     * @ManyToOne(targetEntity="Jimmy\Yap\Domain\Entity\User")
     * @JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     * @Column(name="kode_promo", length=255, nullable=false, type="string")
     */
    private $kodePromo;

    /**
     * @var string
     * @Column(name="title", length=255, nullable=false, type="string")
     */
    private $title;

    /**
     * @var string
     * @Column(type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var int
     * @Column(type="integer", length=2, nullable=false, name="is_deleted")
     */
    private $isDeleted = 0;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false, name="tanggal_berlaku_awal")
     */
    private $tanggalBerlakuAwal;

    /**
     * @return \DateTime
     */
    public function getTanggalBerlakuAwal()
    {
        return $this->tanggalBerlakuAwal;
    }

    /**
     * @param \DateTime $tanggalBerlakuAwal
     */
    public function setTanggalBerlakuAwal($tanggalBerlakuAwal)
    {
        $this->tanggalBerlakuAwal = \DateTime::createFromFormat('d/m/Y', $tanggalBerlakuAwal);
    }

    /**
     * @return \DateTime
     */
    public function getTanggalBerlakuAkhir()
    {
        return $this->tanggalBerlakuAkhir;
    }

    /**
     * @param \DateTime $tanggalBerlakuAkhir
     */
    public function setTanggalBerlakuAkhir($tanggalBerlakuAkhir)
    {
        $this->tanggalBerlakuAkhir = \DateTime::createFromFormat('d/m/Y', $tanggalBerlakuAkhir);
    }

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false, name="tanggal_berlaku_akhir")
     */
    private $tanggalBerlakuAkhir;

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
     * @return string
     */
    public function getKodePromo()
    {
        return $this->kodePromo;
    }

    /**
     * @param string $kodePromo
     */
    public function setKodePromo($kodePromo)
    {
        $this->kodePromo = $kodePromo;
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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}