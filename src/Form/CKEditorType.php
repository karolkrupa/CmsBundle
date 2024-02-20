<?php

namespace Devster\CmsBundle\Form;

use Devster\CmsBundle\CKEditor\Event\MediaProcessingEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CKEditorType extends AbstractType
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly string                   $fileUploadRoute
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $sourceContent = $event->getData() ?? '';

            if (!$sourceContent) {
                return;
            }

            $crawler = new Crawler($sourceContent);

            foreach ($crawler->filter('img[data-file-id]') as $img) {
                $mediaId = $img->getAttribute('data-file-id');
                $img->removeAttribute('data-file-id');

                $src = $img->getAttribute('src');

                $event = new MediaProcessingEvent(
                    $mediaId,
                    $src
                );
                $this->eventDispatcher->dispatch($event, MediaProcessingEvent::class);

                if ($event->getSrc()) {
                    $img->setAttribute('src', $event->getSrc());
                } else {
                    $img->removeAttribute('src');
                }
            }

            $event->setData($crawler->html());
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['route'] = $options['route'];
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => false,
            'route' => $this->fileUploadRoute
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'ckeditor';
    }

    public function getParent(): ?string
    {
        return TextareaType::class;
    }

}