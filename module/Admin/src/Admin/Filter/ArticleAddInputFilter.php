<?php
 namespace Admin\Filter;

 use Zend\InputFilter\InputFilter;

 class ArticleAddInputFilter extends InputFilter
 {
     public function __construct()
     {
         $this->add(array(
             'name' => 'title',
             'required' => true,
             'validators' => array(
                 array(
                     'name' => 'StringLength',
                     'options' => array(
                         'min' => 3,
                         'max' => 100,
                     )
                 ),
             ),
             'filters' => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
         ));

         $this->add(array(
             'name' => 'shortArticle',
             'required' => false,
             'validators' => array(
                 array(
                     'name' => 'StringLength',
                     'options' => array(
                         'max' => 600,
                     )
                 ),
             ),
             'filters' => array(
                 array('name' => 'StringTrim'),
             ),
         ));

         $this->add(array(
             'name' => 'isPublic',
             'required' => false,
         ));

         $this->add(array(
             'name' => 'category',
             'required' => true,
         ));
     }
 }