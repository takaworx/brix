<?php

namespace Takaworx\Brix\Traits;

trait UidTrait
{
    /**
     * Setup event handlers when trait boots
     *
     * @return void
     */
    public static function bootUidTrait()
    {
        $self = new static();

        static::creating(function ($record) use ($self) {
            $record->setUid($self);
        });
    }

    /**
     * Generate a unique id for the record
     *
     * @param Model $self
     * @return void
     */
    public function setUid($self)
    {
        if (!is_null($this->uid)) {
            return true;
        }

        $uid = $this->generateUid($self);

        while ($this->uidExists($uid)) {
            $uid = $this->generateUid($self);
        }

        $this->uid = $uid;
    }

    /**
     * Check if uid is available for use
     *
     * @param string $uid
     * @return bool
     */
    protected function uidExists($uid)
    {
        return self::where('uid', $uid)->count() ? true : false;
    }

    /**
     * Generate a random uid
     *
     * @param Model $self
     * @return string
     */
    public function generateUid($self)
    {
        return str_random($this->getUidLength($self));
    }

    /**
     * Get uid length if exists
     *
     * @param Model $self
     * @param int
     */
    protected function getUidLength($self)
    {
        if (property_exists($self, 'uidLength')) {
            return $self->uidLength;
        }

        return 8;
    }
}
