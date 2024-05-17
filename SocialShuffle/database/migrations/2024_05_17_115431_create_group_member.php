<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_member', function (Blueprint $table) {
            // This is the pivot table that links the members and the groups together.

            // Foreign Keys
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('group_id');

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('group_id') ->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_member');
    }
};
