<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category", uniqueConstraints={@ORM\UniqueConstraint(name="category_key", columns={"category_key"})})
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="category_key", type="string", length=20, nullable=false)
     */
    private $categoryKey;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=100, nullable=false)
     */
    private $categoryName;



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
     * Set categoryKey
     *
     * @param string $categoryKey
     * @return Category
     */
    public function setCategoryKey($categoryKey)
    {
        $this->categoryKey = $categoryKey;
     
        return $this;
    }
 
    /**
     * Get categoryKey
     *
     * @return string 
     */
    public function getCategoryKey()
    {
        return $this->categoryKey;
    }

     /**
     * Set categoryName
     *
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
     
        return $this;
    }
 
    /**
     * Get categoryName
     *
     * @return string 
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function exchangeArray($data){

        foreach($data as $key => $val){
            if(property_exists($this,$key)){
                $this->$key = ($val !== null) ? $val : null;
            }
        }

    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }


}

