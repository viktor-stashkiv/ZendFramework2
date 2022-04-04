<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Comment;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;


class CommentController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('a')
            ->from('Blog\Entity\Comment','a')
            ->orderBy('a.id','DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

        return array('comments' => $paginator);
    }

    protected function getCommentForm(Comment $comment){

        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(),'\Comment'));
        $form->bind($comment);

        return $form;
    }

    public function editAction(){

        $message = $status = '';
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id',0);
        $comment = $em->find('Blog\Entity\Comment',$id);

        if(empty($comment)){
            $message = 'Коментар не знайдений';
            $status = 'error';
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);

            return $this->redirect()->toRoute('admin/comment');
        }

        $form = $this->getCommentForm($comment);

        $request = $this->getRequest();
        if($request->isPost()){

            $data = $request->getPost();
            $form->setData($data);

            if($form->isValid()){

                $em->persist($comment); // перезапис entity та підготовка до запису в БД
                $em->flush(); // добавлення нової стрічки в БД

                $status = 'success';
                $message = 'Коментар обновлений';

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
            return array('form' => $form,'id' => $id,'comment' => $comment);
        }

        if($message) {
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/comment');
    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id',0); // айдішку бере з url(роута)
        $em = $this->getEntityManager(); // для роботи з БД

        $status = 'success';
        $message = 'Коментар видалений!';

        try{
            $repository = $em->getRepository('Blog\Entity\Comment');
            $comment = $repository->find($id);
            $em->remove($comment);
            $em->flush(); // операція в БД
        }
        catch (\Exception $ex)
        {
            $status = 'error';
            $message = 'Помилка видалення записа' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);

        return $this->redirect()->toRoute('admin/comment');
    }

}




