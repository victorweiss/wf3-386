<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('blogItem', [$this, 'renderBlogItem'], ['is_safe' => ['html']]),
        ];
    }

    public function renderBlogItem($id)
    {
        // Requête SQL
        $article['titre'] = 'Titre '.$id;
        sleep(2);

        // Afficher le HTML
        $html = "<div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>". $article['titre'] ."</h5>
                    </div>
                </div>";

        return $html;
    }
}
