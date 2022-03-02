<?php
namespace Admin\Form;

use Zend\Form\Form;
//use Zend\InputFilter\Factory as InputFactory;
//use Zend\InputFilter\InputFilter;

class CategoryAddForm extends Form{

    public function __construct($name = null){
        parent::__construct('categoryAddForm');
        $this->setAttribute('method','post'); // php метод post
        $this->setAttribute('class','bs-example form-horizontal'); // назви класів css

        $this->add(array(
            'name' => 'categoryKey',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Ключ'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'categoryName',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Назва'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Зберігти',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary'
            ),
        ));
    }
}