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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // 'id' is the primary key
            $table->unsignedBigInteger('product_id'); // use unsignedBigInteger for foreign key
            $table->unsignedBigInteger('buyer_id'); // use unsignedBigInteger for foreign key
            $table->unsignedBigInteger('seller_id'); // use unsignedBigInteger for foreign key
            $table->timestamp('transaction_date')->useCurrent();
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
