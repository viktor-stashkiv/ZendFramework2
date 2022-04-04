<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use Blog\Entity\Category;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT u FROM Blog\Entity\Category u ORDER BY  u.id DESC');
        $rows = $query->getResult();

    
        return array('category' => $rows);

    }

    public function addAction(){

        $form = new CategoryAddForm();
        $status = $message = '';
        $em = $this->getEntityManager();

        $request = $this->getRequest(); // покажить параметри

        if($request->isPost()){

            $form->setData($request->getPost());
            if($form->isValid()){

                $category = new Category();

                $category->exchangeArray($form->getData());

                $em->persist($category); // перезапис entity
                $em->flush(); // добавлення нової стрічки в БД

                $status = 'success';
                $message = 'Категорія добалена';

            } else {
                $status = 'error';
                $message = 'Помилка параметрів';
            }
        } else {
            return array('form' => $form);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function editAction(){
        $form = new CategoryAddForm();
        $status = $message = '';
        $em = $this->getEntityManager(); // для роботи з БД

        $id = (int) $this->params()->fromRoute('id',0); // айдішку бере з url(роута)

        $category = $em->find('Blog\Entity\Category',$id); // шукати в таблиці Category поле id та створити екзепляр класу Category

        if(empty($category)){
            $message = 'Категорія не знайдена';
            $status = 'error';
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);

            return $this->redirect()->toRoute('admin/category');
        }

        $form->bind($category);

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();
            $form->setData($data);

            if($form->isValid()){

                $em->persist($category); // перезапис entity
                $em->flush(); // добавлення нової стрічки в БД

                $status = 'success';
                $message = 'Категорія обновлена';

            } else {
                $status = 'error';
                $message = 'Помилка параметрів';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors){
                    foreach ($errors->getMessages() as $error){
                        $message.= ' ' . $error;
                    }
                }
            }
        } else {
            return array('form' => $form,'id' => $id);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');

    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id',0); // айдішку бере з url(роута)
        $em = $this->getEntityManager(); // для роботи з БД

        $status = 'success';
        $message = 'Категорія видалена!';

        try{
            $repository = $em->getRepository('Blog\Entity\Category');
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush(); // операція в БД
        }
        catch (\Exception $ex)
        {
            $status = 'error';
            $message = 'Помилка видалення записа' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);

        return $this->redirect()->toRoute('admin/category');
    }
}




