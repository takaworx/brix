<?php

namespace Takaworx\Brix\Traits;

use Auth;

trait AuditTrait
{
    /**
     * Setup event handlers when trait boots
     *
     * @return void
     */
    public static function bootAuditTrait()
    {
        static::creating(function ($record) {
            $record->setCreatedBy();
        });

        static::updating(function ($record) {
            $record->setUpdatedBy();
        });

        if (function_exists('restoring')) {
            static::deleting(function ($record) {
                $record->setDeletedBy();
            });

            static::restoring(function ($record) {
                $record->setUpdatedBy();
            });
        }
    }

    /**
     * Set created_by attribute to logged in user when not set
     *
     * @return void
     */
    public function setCreatedBy()
    {
        if (!isset($this->created_by) || is_null($this->created_by)) {
            $this->created_by = Auth::user() ? Auth::user()->id : 0;
        }
    }

    /**
     * Set updated_by attribute to logged in user when not set
     *
     * @return void
     */
    public function setUpdatedBy()
    {
        if (!isset($this->updated_by) || is_null($this->updated_by)) {
            $this->updated_by = Auth::check() ? Auth::user()->id : 0;
        }
    }

    /**
     * Set deleted_at attribute to logged in user when not set
     *
     * @return void
     */
    public function setDeletedBy()
    {
        if (!isset($this->deleted_by) || is_null($this->deleted_by)) {
            $this->deleted_by = Auth::check() ? Auth::user()->id : 0;
        }
    }

    /**
     * Get creator's user data
     *
     * @return App\Models\User;
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    /**
     * Get updater's user data
     *
     * @return App\Models\User;
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

    /**
     * Get deleter's user data
     *
     * @return App\Models\User;
     */
    public function deletedBy()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }
}
