<?php

namespace Takaworx\Brix\Traits;

use Carbon\Carbon;

trait Expirable
{
    /**
     * Setup event handlers when trait boots
     *
     * @return void
     */
    public static function bootExpirable()
    {
        $self = new static();

        static::creating(function ($record) use ($self) {
            $record->setExpiresAt($self);
        });
    }

    /**
     * Set the value for expires_at
     *
     * @param self $self
     * @return void
     */
    public function setExpiresAt($self)
    {
        if (!is_null($this->expires_at)) {
            return true;
        }

        $this->expires_at = Carbon::now()->addHours($this->getExpiration($self));
    }

    /**
     * Get expiration attribute if exists
     *
     * @param self $self
     * @param int
     */
    protected function getExpiration($self)
    {
        if (property_exists($self, 'expiration')) {
            return $self->expiration;
        }

        return 48;
    }
}
