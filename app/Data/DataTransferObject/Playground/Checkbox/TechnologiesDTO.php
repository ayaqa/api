<?php

namespace AyaQA\Data\DataTransferObject\Playground\Checkbox;

use AyaQA\Enum\SectionId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TechnologiesDTO
{
    public const RADIO_2G = '2g';
    public const RADIO_3G = '3g';
    public const RADIO_4G = '4g';
    public const RADIO_5G = '5g';

    public readonly bool $r2g;
    public readonly bool $r3g;
    public readonly bool $r4g;
    public readonly bool $r5g;

    public static function fromRequest(Request $request): self
    {
        $self = new self();
        $self->r2g = $request->get(self::RADIO_2G, false);
        $self->r3g = $request->get(self::RADIO_3G, false);
        $self->r4g = $request->get(self::RADIO_4G, false);
        $self->r5g = $request->get(self::RADIO_5G, false);

        return $self;
    }

    public static function fromCollection(Collection $collection): self
    {
        $self = new self();
        $self->r2g = $collection->firstWhere('key', '=', self::RADIO_2G)->value;
        $self->r3g = $collection->firstWhere('key', '=', self::RADIO_3G)->value;
        $self->r4g = $collection->firstWhere('key', '=', self::RADIO_4G)->value;
        $self->r5g = $collection->firstWhere('key', '=', self::RADIO_5G)->value;

        return $self;
    }

    public function asArray(): array
    {
        return [
            self::RADIO_2G => $this->r2g,
            self::RADIO_3G => $this->r3g,
            self::RADIO_4G => $this->r4g,
            self::RADIO_5G => $this->r5g,
        ];
    }

    public function asResponse(): array
    {
        return [
            'id' => SectionId::CHECKBOX_02->getId(),
            'radio' => $this->asArray()
        ];
    }
}
