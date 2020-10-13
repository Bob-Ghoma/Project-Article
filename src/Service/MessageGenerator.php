<?php


namespace App\Service;


use App\Repository\ArticleRepository;
use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $aRepository;
    private $logger;
    private $logEnabled;

    /**
     * MessageGenerator constructor.
     */

    public function __construct(ArticleRepository $articleRepository, LoggerInterface $logger, $logEnabled)
    {
        $this->logEnabled = $logEnabled;
        $this->logger = $logger;
        // Je met articleRepository dans aRepository
        $this->aRepository = $articleRepository;
    }

    public function getMessage(){
        // Les messages à afficher
    $message = [
        "Salut à tous",
        "Bonjour",
        "Bonne journée"
    ];
    $message = $message[rand(0,2)];
    if ($this->logEnabled){
        $this->logger->notice("un message à été généré: '$message'");
    }
    return $message;
    }

    public function getPublishedArticlesTitle(){
        // Je creer une variable $title qui est un tableau
        $titles = [];
        // Je met aRepository dans $articles en lui donnant la dunction getPublishedArticles
        $articles = $this->aRepository->getPublishedArticles();
        foreach ($articles as $article){
            // insérer les titres de mes article dans le tableau $titles
            $titles[] =$article->getTitle();
        }
        return $titles;
    }
}