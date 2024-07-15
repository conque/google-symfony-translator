<?php

namespace App\Controller;

use App\Service\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TranslationController extends AbstractController
{
    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }


    #[Route('/translate', name: 'app_translation', methods: ['POST','GET'])]
    public function translate(Request $request): Response
    {
        $translatedText = null;

        if ($request->isMethod('POST')) {
            $text = $request->request->get('text');
            $targetLanguage = $request->request->get('targetLanguage');
            $sourceLanguage = $request->request->get('sourceLanguage', 'en');

            $translatedText = $this->translationService->translate($text, $targetLanguage, $sourceLanguage);
        }

        return $this->render('translation/translate.html.twig', [
            'translatedText' => $translatedText,
        ]);
    }
}
