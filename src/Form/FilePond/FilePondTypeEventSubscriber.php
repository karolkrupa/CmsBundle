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
    // Obiekty modelu do usunięcia
    private array $filesToDelete = [];

    // Identyfikatory nowych plików
    private array $newFileIds = [];

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }

    public function __construct(
        private readonly array $options
    )
    {
    }

    public function onPreSubmit(FormEvent $event): void
    {
        // Nowe dane, lista identyfikatorów lub pojedynczy identyfikator
        $newData = $event->getData();

        // Stare dane modelu
        $oldModelData = $event->getForm()->getData();

        // Stare dane znormalizowane do DTO
        $oldData = $event->getForm()->getNormData();

        if ($this->options['multiple']) {
            // Stare dane modelu indeksowane po id pliku
            $oldModelDataIndexed = [];
            foreach ($oldData as $idx => $fileDto) {
                $oldModelDataIndexed[$fileDto->id] = $oldModelData[$idx];
            }

            $newFileIds = $newData;

            // Identyfikatory usuniętych plików
            foreach (array_diff(array_keys($oldModelDataIndexed), $newFileIds) as $id) {
                $this->filesToDelete[] = $oldModelDataIndexed[$id];
            }

            // Identyfikatory nowych plików
            $this->newFileIds = array_diff($newFileIds, array_keys($oldModelDataIndexed));
        } else {
            // Plik został usunięty
            if (!$newData && $oldData) {
                $this->filesToDelete[] = $oldModelData;
            }

            // Plik został zmieniony, stary usuwamy
            if ($oldData && $newData != $oldData->id) {
                $this->filesToDelete[] = $oldModelData;
            }
        }

        if (!empty($this->filesToDelete) && !$this->options['allow_delete']) {
            $event->getForm()->addError(new FormError('Usuwanie nie jest dozwolone'));
            if ($oldNormData = $event->getForm()->getNormData()) {
                $event->setData($oldNormData);
            }
        }
    }

    public function onPostSubmit(FormEvent $event): void
    {
        $formData = $event->getForm()->getData();

        $newModelsIndexed = [];
        foreach ($event->getData() as $idx => $fileDto) {
            $newModelsIndexed[$fileDto->id] = $event->getForm()->getData()[$idx];
        }

        $newFileModels = [];
        foreach ($this->newFileIds as $id) {
            $newFileModels[] = $newModelsIndexed[$id];
        }

        if ($event->getForm()->isValid()) {
            if (is_callable($this->options['new_file_callback'])) {
                foreach ($newFileModels as $media) {
                    $this->options['new_file_callback']($media);
                }
            }
        }

        if ($event->getForm()->isValid()) {
            if (is_callable($this->options['delete_file_callback'])) {
                foreach ($this->filesToDelete as $media) {
                    $this->options['delete_file_callback']($media);
                }
            }
        }
    }
}