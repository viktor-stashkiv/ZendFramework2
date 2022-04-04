<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="category", columns={"category"})})
 * @ORM\Entity
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text", length=65535, nullable=false)
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="short_article", type="text", length=65535, nullable=true)
     */
    private $shortArticle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private $isPublic;

    /**
     * @var \Blog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     *
     * @param \Doctrine\Common\Collections\Collection $property
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade={"persist":"remove"})
     */
    private $comments;

    public function getComments(){
        return $this->comments;
    }

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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Article
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set shortArticle
     *
     * @param string $shortArticle
     * @return Article
     */
    public function setShortArticle($shortArticle)
    {
        $this->shortArticle = $shortArticle;

        return $this;
    }

    /**
     * Get shortArticle
     *
     * @return string
     */
    public function getShortArticle()
    {
        return $this->shortArticle;
    }

    /**
     * Set isPublic
     *
     * @param string $isPublic
     * @return Article
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return string
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set category
     *
     * @param $category
     * @return Article
     */

    public function setCategory($category){

        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Blog\Entity\Category
     */

    public function getCategory(){
        return $this->category;
    }

    public function getArticleForTable()
    {
        $article = strip_tags($this->getArticle());
        $article = mb_substr($article,0,15,'UTF-8') . '...';

        return $article;
    }

    public function getShortArticleForTable()
    {
        $article = strip_tags($this->getShortArticle());
        $article = mb_substr($article,0,20,'UTF-8') . '...';

        return $article;
    }

    public function getShortArticleForBlog()
    {
        $article = $this->getShortArticle();
        if(empty($article)){
            $article = $this->getArticle();
        }

        return $article;
    }

    public function getFullArticle()
    {
        $article = $this->getShortArticle() . $this->getArticle();

        return $article;
    }

    public function __toString()
    {
        return 'Article class';
    }

}

