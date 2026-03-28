<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('crm:about', function () {
    $this->comment('Repair CRM starter overlay is installed.');
})->purpose('Display starter overlay information');
