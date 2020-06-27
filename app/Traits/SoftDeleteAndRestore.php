<?php

namespace App\Traits;

use App\Exceptions\CustomMessageException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait SoftDeleteAndRestore
{
    public function restoreHelp()
    {
        $this->restore();

        $this->restoreCascade();
    }

    public function restoreCascade()
    {
        if (property_exists($this, 'softDeleteCascades')) {
            foreach ($this->softDeleteCascades as $each) {
                try {
                    $datas = $this->$each()->onlyTrashed()->get();

                    if (!empty($datas)) {
                        $datas->each(fn ($query) => $query->restoreHelp());
                    }
                } catch (\Throwable $th) {
                }
            }
        }
    }

    public static function boot()
    {
        parent::boot();

        self::restoring(function ($model) {
            //before restore

            if (property_exists($model, 'checkBeforeRestore')) {
                if (!is_array($model->checkBeforeRestore)) {
                    throw new CustomMessageException("\$checkBeforeRestore must be an array");
                }

                foreach ($model->checkBeforeRestore as $each) {
                    if (!empty($model->$each->deleted_at)) {
                        throw new CustomMessageException("Users have to restore parent table first");
                    }
                }
            }
        });

        self::deleting(function ($model) {
            if (property_exists($model, 'softDeleteCascades')) {
                if (!is_array($model->softDeleteCascades)) {
                    throw new CustomMessageException("\$checkBeforeRestore must be an array");
                }

                if ($model->forceDeleting) {
                    foreach ($model->softDeleteCascades as $each) {
                        try {
                            $datas = $model->$each()->withTrashed()->get();

                            if (!empty($datas)) {
                                $datas->each(fn ($query) => $query->forceDelete());
                            }
                        } catch (\Throwable $th) {
                            $datas = $model->$each()->get();

                            if (!empty($datas)) {
                                $datas->each(fn ($query) => $query->delete());
                            }
                        }
                    }
                } else {
                    foreach ($model->softDeleteCascades as $each) {
                        try {
                            $datas = $model->$each()->withTrashed()->get();

                            if (!empty($datas)) {
                                $datas->each(fn ($query) => $query->delete());
                            }
                        } catch (\Throwable $th) {
                        }
                    }
                }
            }
        });
    }
}
