<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->enum('role',[
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'warga'
            ])->change();

        });
    }

    public function down()
    {

    }
};

