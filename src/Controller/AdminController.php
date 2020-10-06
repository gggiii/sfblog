<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin", name="admin.")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {   $all = $this->getDoctrine()->getManager()->getRepository(post::class)->findAll();
        $res = [];
        for ($i=0; $i < count($all); $i++) { 
            $res[$i]['id'] = $all[$i]->getId();
            $res[$i]['title'] = $all[$i]->getTitle();
        }
        return $this->render('admin/dasboard.html.twig',[
            'posts'=>$res
        ]);
    }
    /**
     * @Route("/post/delete/{id}", name="deletePost")
     */
    public function delete($id){
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository(Post::class)->find($id);
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('admin.dashboard');
    }
    /**
     * @Route("/post/create", name="createPost")
     */
    public function create(Request $request){
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        
        //handle submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin.dashboard');
        }


        return $this->render('admin/post/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
