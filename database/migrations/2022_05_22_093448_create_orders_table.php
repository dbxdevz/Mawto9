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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_status_id')->constrained();
            $table->foreignId('package_status_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('delivery_service_id')->nullable()->constrained()->onDelete('set null');
            $table->longText('note')->nullable();
            $table->longText('delivery_note')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('shipping_cost')->default(0);
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
