<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Dto wartości komórki tabeli
 */
class BoolCell extends TextCell
{
    protected bool $asBadge = false;
    protected bool $asIcon = false;
    protected string|\Closure $trueValue = 'TAK';
    protected string|\Closure $falseValue = 'NIE';

    protected function getDefaultTemplate(): string
    {
        if ($this->asBadge) {
            return '@DevsterCms/crud/list/cell/bool_badge.html.twig';
        }

        if ($this->asIcon) {
            return '@DevsterCms/crud/list/cell/bool_icon.html.twig';
        }

        return '@DevsterCms/crud/list/cell/bool.html.twig';
    }

    /**
     * Wyświetlanie jako badge
     *
     * @param bool $asBadge
     * @return $this
     */
    public function setAsBadge(bool $asBadge = true): static
    {
        $this->resetViewVariant();

        $this->asBadge = $asBadge;

        return $this;
    }

    /**
     * Wyświetlanie jako ikona
     *
     * @param bool $asIcon
     * @return $this
     */
    public function setAsIcon(bool $asIcon = true): static
    {
        $this->resetViewVariant();

        $this->asIcon = $asIcon;

        return $this;
    }

    /**
     * Tekst dla pozytywnej wartości
     *
     * @param string|\Closure(mixed $data):string $trueValue
     * @return $this
     */
    public function setTrueValue(string|\Closure $trueValue): BoolCell
    {
        $this->trueValue = $trueValue;

        return $this;
    }

    /**
     * Tekst dla negatywnej wartości
     *
     * @param string|\Closure(mixed $data):string $falseValue
     * @return $this
     */
    public function setFalseValue(string|\Closure $falseValue): BoolCell
    {
        $this->falseValue = $falseValue;

        return $this;
    }

    public function isAsBadge(): bool
    {
        return $this->asBadge;
    }

    public function isAsIcon(): bool
    {
        return $this->asIcon;
    }

    public function getTrueValue(): string|\Closure
    {
        return $this->trueValue;
    }

    public function getFalseValue(): string|\Closure
    {
        return $this->falseValue;
    }

    public function getViewVars(mixed $data): array
    {
        return [
            ...parent::getViewVars($data),
            'trueValue' => $this->trueValue instanceof \Closure ? ($this->trueValue)($data) : $this->trueValue,
            'falseValue' => $this->falseValue instanceof \Closure ? ($this->falseValue)($data) : $this->falseValue,
        ];
    }

    protected function resetViewVariant(): void
    {
        $this->asBadge = false;
        $this->asIcon = false;
    }
}