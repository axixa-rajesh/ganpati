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
        Schema::create('myorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billno_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('mobile');
            $table->longText('address');
            $table->string('product_name');
            $table->string('flavour');
            $table->string('qty');
            $table->float('weight');
            $table->enum('weight_type', ['gm', 'kg'])->default('gm');
            $table->enum('madewith', ['Vegetable Oil', 'Desi Ghee']);
            $table->integer('mrp');
            $table->integer('price');
            $table->float('discount');
            $table->integer('finalprice');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('myorders');
    }
};
