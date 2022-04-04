<?php

    namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="article", columns={"article"})})
 * @ORM\Entity
 * @Annotation\Name("comment")
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=50, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Email"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Attributes({"id":"user_email","class":"form-control","required":"required"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"id":"user_comment","class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Коментар"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":1,"max":300}})
     */
    private $comment;

    /**
     * @var \Blog\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article", referencedColumnName="id")
     * })
     * @Annotation\Options({"label":"Коментар"})
     */
    private $article;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")

     * @Annotation\Attributes({"value":"Надіслати","id":"btn_submit","class":"btn btn-primary",})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    public $submit;

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return Comment
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set comment
     *
     * @param string comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set article
     *
     * @param $article
     * @return Comment
     */

    public function setArticle($article){

        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Blog\Entity\Article
     */

    public function getArticle(){
        return $this->article;
    }


}

