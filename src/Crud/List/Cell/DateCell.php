<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Dto wartości komórki tabeli
 */
class DateCell extends TextCell
{
    protected string $format = 'Y-m-d';

    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/crud/list/cell/date.html.twig';
    }

    /**
     * Konfiguracja formatu wyświetlania daty
     *
     * @param string $format
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