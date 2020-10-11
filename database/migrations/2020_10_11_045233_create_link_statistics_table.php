<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'link_statistics', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'link_id' )->constrained()->cascadeOnDelete();
            $table->string( 'referer' )->nullable();
            $table->string( 'slug' )->nullable();
            $table->string( 'to' );
            $table->text( 'user_agent' )->nullable();
            $table->string( 'ip_address', 45 )->nullable();
            $table->boolean( 'success' )->default( true );
            $table->timestamp( 'opened_at' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'link_statistics' );
    }
}
