<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Article;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Admin\Form\ArticleAddForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class ArticleController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('a')
            ->from('Blog\Entity\Article','a')
            ->orderBy('a.id','DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

        return array('articles' => $paginator);

    }

    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);

        $request = $this->getRequest(); // покажить параметри

        if($request->isPost()){

            $message = $status = '';

            $data = $request->getPost(); // масив даних із форми

            $article = new Article();
            $form->setHydrator(new DoctrineHydrator($em,'\Article')); // докринівська зв'язка (bind)
            $form->bind($article);
            $form->setData($data);

            if($form->isValid()){

                $em->persist($article); // перезапис entity та підготовка до запису в БД
                $em->flush(); // добавлення нової стрічки в БД

                $status = 'success';
                $message = 'Стаття добалена';

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
            return array('form' => $form);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');

    }

    public function editAction(){

        $message = $status = '';
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);


        $id = (int) $this->params()->fromRoute('id',0);
        $article = $em->find('Blog\Entity\Article',$id);

        if(empty($article)){
            $message = 'Стаття не знайдена';
            $status = 'error';
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);

            return $this->redirect()->toRoute('admin/article');
        }

        $form->setHydrator(new DoctrineHydrator($em,'\Article')); // докринівська зв'язка (bind)
        $form->bind($article);

        $request = $this->getRequest();
        if($request->isPost()){

            $data = $request->getPost();
            $form->setData($data);

            if($form->isValid()){

                $em->persist($article); // перезапис entity та підготовка до запису в БД
                $em->flush(); // добавлення нової стрічки в БД

                $status = 'success';
                $message = 'Стаття обновлена';

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

        return $this->redirect()->toRoute('admin/article');

    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id',0); // айдішку бере з url(роута)
        $em = $this->getEntityManager(); // для роботи з БД

        $status = 'success';
        $message = 'Стаття видалена!';

        try{
            $repository = $em->getRepository('Blog\Entity\Article');
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush(); // операція в БД
        }
        catch (\Exception $ex)
        {
            $status = 'error';
            $message = 'Помилка видалення записа' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);

        return $this->redirect()->toRoute('admin/article');
    }
}




