<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->start_from(10000);
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('transaction_id')->nullable();
            $table->dateTime('date');
            $table->string('promocode')->nullable();
            $table->enum('discount_type', ['flat', 'percentage'])->nullable();
            $table->float('discount_percentage', 8, 2)->nullable();
            $table->float('discounted_amount', 8, 2)->nullable();
            $table->float('subtotal', 8, 2)->default(0);
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
        Schema::dropIfExists('orders');
    }
}
