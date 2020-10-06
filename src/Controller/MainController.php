<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/",name="index.")
 */
class MainController extends AbstractController
{
    /**
     * @Route("",name="index")
     */
    public function index()
    {   
        $all = $this->getDoctrine()->getRepository(Post::class)->findAll();
        //covert to arary
        $res = [];
        for ($i=0; $i < count($all); $i++) { 

            $res[$i]['id'] = $all[$i]->getId();
            $res[$i]['title'] = $all[$i]->getTitle();
            $res[$i]['content'] = $all[$i]->getContent();
        }
        return $this->render('index.html.twig',[
            'posts'=>$res
        ]);
    }
    /**
     * @Route("post/{id}",name="single")
     */
    public function single($id)
    {   
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        return $this->render('single.html.twig',[
            'title'=>$post->getTitle(),
            'content'=>$post->getContent()
        ]);
    }
}

?>