<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Dto wartości komórki tabeli
 */
class DateCell extends TextCell
{
    protected string $format = 'Y-m-d';

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getViewVars(): array
    {
        return [
            ...parent::getViewVars(),
            ...[
                'format' => $this->format
            ]
        ];
    }
}