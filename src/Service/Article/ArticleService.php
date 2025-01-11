<?php

namespace App\Service\Article;

// use App\Entity\Articles;

use App\Entity\Articles;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Exception;


class ArticleService{
    private ManagerRegistry $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

        
    }
    /**
     * récupération de toutes les taches
     *
     * @return Articles[]
     */
    public function getAllArticles(): array{
        return $this->doctrine->getManager()->getRepository(Articles::class)->findBy([],['publication_date'=>'ASC']);
    }
    // public function getAllArticlesConvert(): array{

    //     // $html = new \Html2Text\Html2Text('<p>Hello, &quot;<b>world</b></p>');
    //     // dd($html->getText());
    //     $comments = $this->doctrine->getManager()->getRepository(Articles::class)->findAll();
    //     foreach ($comments as $comment) {
    //         dd($comment->comment);
    //         $html2text = new \Html2Text\Html2Text($comment);
    //         // $comment->plainText = $html2text->convert($comment->getContent());
    //     }

    //     return $html2text;


    // }




    public function getIdUser(string $mail){
        $id = $this->doctrine->getManager()->getRepository(User::class)->findOneBy(['email' => $mail]);
        return $id;
    }
    public function deleteOneArticles(int $id): bool
    {
        $Articles = $this->doctrine->getManager()->getRepository(Articles::class)->findOneBy(['id' => $id]);
        try {
            $this->doctrine->getManager()->remove($Articles);
            $this->doctrine->getManager()->flush();
        } catch(Exception $e) {
            return false;
        }

        return true;
    }

    public function getOneArticles(int $id){
        $Articles = $this->doctrine->getManager()->getRepository(Articles::class)->findOneBy(['id' => $id]);
        return $Articles;
    }
    public function editOneArticles(int $id): bool
    {
        $Articles = $this->doctrine->getManager()->getRepository(Articles::class)->findOneBy(['id' => $id]);
        try {
            $this->doctrine->getManager()->remove($Articles);
            $this->doctrine->getManager()->flush();
        } catch(Exception $e) {
            return false;
        }

        return true;
    }
}