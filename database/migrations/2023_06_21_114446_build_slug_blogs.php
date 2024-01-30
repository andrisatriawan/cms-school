<?php

use App\Models\Blogs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        $blogs = (new Blogs)->orderBy('id', 'desc')->get();
        foreach ($blogs as $blog) {
            $blog->slug = Str::slug($blog->title);
            $blog->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $blogs = (new Blogs)->orderBy('id', 'desc')->get();
        foreach ($blogs as $blog) {
            $blog->slug = '';
            $blog->save();
        }
    }
};
