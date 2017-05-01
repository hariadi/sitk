<?php

namespace App\Traits;

trait ButtonAttribute
{
    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        $user = auth()->user();

        $route = $this->getTable();

        if ($user->isAdmin() || $user->isApprover()) {
            return '<a href="'.route($route . '.destroy', $this).'"
                 data-method="delete"
                 data-trans-button-cancel="Batal"
                 data-trans-button-confirm="Hapus"
                 data-trans-title="Anda pasti?"
                 class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Hapus"></i> Hapus</a> ';
        }

        return '';
    }
}