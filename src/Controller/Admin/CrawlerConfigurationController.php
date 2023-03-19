<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class CrawlerConfigurationController extends AbstractController
{
    private readonly array $options;

    public function __construct(array $options)
    {
        $this->options = $this->resolveOptions($options);
    }

    #[Route('/crawler/configuration', name: 'crawler_configuration')]
    public function index(): Response
    {
        $content = file_get_contents($this->options['crawler_publishers_file']);

        return $this->render('crawler/configuration/index.html.twig', [
            'config' => $this->options,
            'content' => $content,
        ]);
    }

    private function resolveOptions(array $options): array
    {
        return (new OptionsResolver())
            ->setRequired('crawler_publishers_file')
            ->setAllowedTypes('crawler_publishers_file', 'string')
            ->setAllowedValues('crawler_publishers_file', static function ($value) {
                if (!file_exists($value)) {
                    $message = sprintf('Option crawler_publishers_file must be a valid file path. %s given.', $value);
                    throw new InvalidOptionsException($message);
                }

                return true;
            })
            ->resolve($options);
    }
}
