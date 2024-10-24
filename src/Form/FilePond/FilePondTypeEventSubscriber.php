<?php

namespace Devster\CmsBundle\Form\FilePond;

use Symfony\Component\DependencyInjection\Attribute\Exclude;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

#[Exclude]
class FilePondTypeEventSubscriber implements EventSubscriberInterface
{
    private array $fileToDelete = [];

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onSubmit',
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }

    public function __construct(
        private readonly array $options
    )
    {
    }

    public function onSubmit(FormEvent $event): void
    {
        $newData = $event->getData();
        $oldData = $event->getForm()->getData();

        if ($this->options['multiple']) {
            foreach ($oldData as $media) {
                if (!in_array($media, $newData)) {
                    $this->fileToDelete[] = $media;
                }
            }
        } elseif ($oldData && !$newData) {
            $this->fileToDelete[] = $oldData;
        }

        if (!empty($this->fileToDelete) && !$this->options['allow_delete']) {
            $event->getForm()->addError(new FormError('Usuwanie nie jest dozwolone'));
            if ($oldNormData = $event->getForm()->getNormData()) {
                $event->setData($oldNormData);
            }
        }
    }

    public function onPostSubmit(FormEvent $event): void
    {
        $formData = $event->getForm()->getData();

        if ($formData && $event->getForm()->isValid()) {
            if (!is_array($formData)) {
                $formData = [$formData];
            }

            if (is_callable($this->options['new_file_callback'])) {
                foreach ($formData as $media) {
                    $this->options['new_file_callback']($media);
                }
            }
        }

        if ($event->getForm()->isValid()) {
            if (is_callable($this->options['delete_file_callback'])) {
                foreach ($this->fileToDelete as $media) {
                    $this->options['delete_file_callback']($media);
                }
            }
        }
    }
}