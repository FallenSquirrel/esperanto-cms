<?php

namespace esperanto\ProjectBundle\Entity;

use esperanto\PageBundle\Entity\Page;
use esperanto\SearchBundle\Search\SearchIndexInterface;
use esperanto\ContentBundle\Entity\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 */
class Content extends Page
{


    /**
     * @var string
     */
    private $citation;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $text;

    private $heading;

    private $file;

    private $name1;

    private $street1;

    private $place1;

    private $phone1;

    private $fax1;

    private $mail1;

    private $name2;

    private $street2;

    private $place2;

    private $phone2;

    private $fax2;

    private $mail2;
    /**
     * Set citation
     *
     * @param string $citation
     * @return Content
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;

        return $this;
    }

    /**
     * Get citation
     *
     * @return string
     */
    public function getCitation()
    {
        return $this->citation;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Content
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * Set text
     *
     * @param string $text
     * @return Content
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set heading
     *
     * @param string $heading
     * @return Content
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get heading
     *
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set date
     *
     * @param \file $file
     * @return Content
     */
    public function setPicture($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Add file
     *
     * @param \esperanto\MediaBundle\Entity\File file
     * @return Content
     */
    public function addPicture(\esperanto\MediaBundle\Entity\File $file)
    {
        if($this->file === null) {
            $this->file = new ArrayCollection();
        }

        $this->file[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \esperanto\MediaBundle\Entity\File $file
     */
    public function removePicture(\esperanto\MediaBundle\Entity\File $file)
    {
        $this->file->removeElement($file);
    }

    /**
     * Get file
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPicture()
    {
        return $this->file;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Content
     */
    public function setName1($name1)
    {
        $this->name1 = $name1;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName1()
    {
        return $this->name1;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Content
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Content
     */
    public function setPlace1($place1)
    {
        $this->place1 = $place1;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace1()
    {
        return $this->place1;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Content
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Content
     */
    public function setFax1($fax1)
    {
        $this->fax1 = $fax1;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax1()
    {
        return $this->fax1;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Content
     */
    public function setMail1($mail1)
    {
        $this->mail1 = $mail1;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail1()
    {
        return $this->mail1;
    }

    /**
     * @param mixed $name2
     */
    public function setName2($name2)
    {
        $this->name2 = $name2;
    }

    /**
     * @return mixed
     */
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @param mixed $street2
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
    }

    /**
     * @return mixed
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @param mixed $place2
     */
    public function setPlace2($place2)
    {
        $this->place2 = $place2;
    }

    /**
     * @return mixed
     */
    public function getPlace2()
    {
        return $this->place2;
    }

    /**
     * @param mixed $phone2
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    /**
     * @return mixed
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * @param mixed $fax2
     */
    public function setFax2($fax2)
    {
        $this->fax2 = $fax2;
    }

    /**
     * @return mixed
     */
    public function getFax2()
    {
        return $this->fax2;
    }

    /**
     * @param mixed $mail2
     */
    public function setMail2($mail2)
    {
        $this->mail2 = $mail2;
    }

    /**
     * @return mixed
     */
    public function getMail2()
    {
        return $this->mail2;
    }
}
