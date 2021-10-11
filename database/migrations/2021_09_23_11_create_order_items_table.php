<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->float('rent_per_day', 8, 2)->default(0);
            $table->integer('total_days')->default(1);
            $table->float('security_amount', 8, 2)->default(0);
            $table->dateTime('date');
            $table->float('discounted_amount', 8, 2)->nullable();
            $table->float('tax', 8, 2)->nullable();
            $table->float('taxrate', 8, 2)->nullable();
            $table->float('total', 8, 2)->default(0);
            $table->enum('status', ['Pending', 'Processing', 'Picked','Completed', 'Cancelled', 'Refunded', 'Failed'])->default('Pending');
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
        Schema::dropIfExists('order_items');
    }
}
