<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Date cell type
 */
class DateCell extends TextCell
{
    protected string $format = 'Y-m-d';

    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/crud/list/cell/date.html.twig';
    }

    /**
     * Configure date format
     *
     * @param string $format - php date format
     * @return $this
     */
    public function setFormat(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getViewVars(mixed $data): array
    {
        return [
            ...parent::getViewVars($data),
            ...[
                'format' => $this->format
            ]
        ];
    }
}