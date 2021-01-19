<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actualites")
 */
class ArticleController extends AbstractController
{
    public const FEATURED_IMAGE_PATH = 'uploads/images/featured/'; // elle va contenir le chemain vers le repertoire où sont stoqués les images associées
   
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            "featured_image_path"=>self::FEATURED_IMAGE_PATH,
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET", "POST"})
     */
    public function show(Article $article, Request $request): Response
    {
        // gestion des commentaires
            $comment = new Comment();
            $comment_form = $this->createForm(CommentType::class, $comment);
            $comment_form->handleRequest($request);
            if($request->isMethod('POST')){
                if ($comment_form->isSubmitted() && $comment_form->isValid()) {
                    $comment->setArticle($article);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($comment);
                    $entityManager->flush();
                    return $this->redirectToRoute('article_show', ["id" => $article->getId()]); // on revient sur la meme page en methorde Get, comme ça les champs seront vidés,ce qui va empecher la ressoumission du meme commentaire
                }     
            }
        
        //composition et creation d'un attribut 'image' à partir
        // de l'attribut 'imageName' et la constante 'FEATURED_IMAGE_PATH'
        // cet attribu n'est créé qu'à ce moment et est détruit apres
        $article->image = self::FEATURED_IMAGE_PATH . $article->getFeaturedImage();
        //rendu
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comment_form' =>  $comment_form->createView()

        ]);
    }



}
