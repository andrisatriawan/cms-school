<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('contacts')->insert([
            'id' => 1,
            'maps' => '',
            'alamat' => '',
            'no_telp' => '',
            'email' => '',
            'twitter' => '',
            'facebook' => '',
            'instagram' => '',
            'linkedin' => '',
            'youtube' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Menghapus data dengan id = 1 dari tabel contacts
        DB::table('contacts')->where('id', 1)->delete();
    }
};
