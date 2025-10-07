<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Config::string('settings.database.table'), function (Blueprint $table) {
            $table->id();
            $table->string('key')
                ->unique()
                ->index();
            $table->json('value')
                ->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::string('settings.database.table'));
    }
};
