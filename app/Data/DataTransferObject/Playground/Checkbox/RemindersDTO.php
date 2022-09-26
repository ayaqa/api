<?php

namespace AyaQA\Data\DataTransferObject\Playground\Checkbox;

use AyaQA\Enum\SectionId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RemindersDTO
{
    public const REMINDERS = 'reminders';
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_APP = 'app';

    public readonly bool $reminders;

    public readonly bool $email;
    public readonly bool $sms;
    public readonly bool $app;

    public static function fromRequest(Request $request): self
    {
        $obj = new self();
        $obj->reminders = $request->get(self::REMINDERS, false);

        if (false === $obj->reminders) {
            $obj->email = false;
            $obj->sms = false;
            $obj->app = false;

            return $obj;
        }

        $obj->email = $request->get(self::CHANNEL_EMAIL, false);
        $obj->sms = $request->get(self::CHANNEL_SMS, false);

        // @TODO add bug ability around not implemented yet feature
        if (false) {
            $obj->app = $request->get(self::CHANNEL_APP, false);
        } else {
            $obj->app = false;
        }

        return $obj;
    }

    public static function fromCollection(bool $isReminderEnabled, Collection $collection): self
    {
        $obj = new self();

        $obj->reminders = $isReminderEnabled;
        $obj->email = $collection->firstWhere('key', '=', self::CHANNEL_EMAIL)->value;
        $obj->sms = $collection->firstWhere('key', '=', self::CHANNEL_SMS)->value;
        $obj->app = $collection->firstWhere('key', '=', self::CHANNEL_APP)->value;

        return $obj;
    }

    public function isReminderEnabled(): bool
    {
        return $this->reminders;
    }

    public function getChannels(): array
    {
        return [
            self::CHANNEL_EMAIL => $this->email,
            self::CHANNEL_SMS => $this->sms,
            self::CHANNEL_APP => $this->app,
        ];
    }

    public function asResponse(): array
    {
        return [
            'id' => SectionId::CHECKBOX_03->getId(),
            'reminders' => $this->isReminderEnabled(),
            'channels' => $this->getChannels()
        ];
    }
}
