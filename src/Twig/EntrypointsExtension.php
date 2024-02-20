<?php

namespace Devster\CmsBundle\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

class EntrypointsExtension extends AbstractExtension
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('devstercms_script_tags', [$this, 'getScriptTags']),
            new TwigFunction('devstercms_link_tags', [$this, 'getLinkTags']),
        ];
    }

    public function getScriptTags(): Markup
    {
        $entrypointsPath = $this->parameterBag->get('kernel.project_dir') . '/public/bundles/devstercms/build/entrypoints.json';

        $entrypoints = json_decode(file_get_contents($entrypointsPath), true);

        $entrypointsHtml = '';
        foreach ($entrypoints['entrypoints']['app']['js'] as $entrypoint) {
            $entrypointsHtml .= sprintf(
                "<script src=\"/bundles/devstercms/build%s\"></script>\n",
                $entrypoint
            );
        }

        return new Markup($entrypointsHtml, 'UTF-8');
    }

    public function getLinkTags(): Markup
    {
        $entrypointsPath = $this->parameterBag->get('kernel.project_dir') . '/public/bundles/devstercms/build/entrypoints.json';

        $entrypoints = json_decode(file_get_contents($entrypointsPath), true);

        $entrypointsHtml = '';
        foreach ($entrypoints['entrypoints']['app']['css'] as $entrypoint) {
            $entrypointsHtml .= sprintf(
                "<link rel=\"stylesheet\" href=\"/bundles/devstercms/build%s\">\n",
                $entrypoint
            );
        }

        return new Markup($entrypointsHtml, 'UTF-8');
    }
}