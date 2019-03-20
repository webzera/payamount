<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('pay_token');
            $table->string('payment_id');
            $table->string('invoice_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('currencyCode')->default('USD');
            $table->decimal('payable_amt', 8, 2);
            $table->unsignedInteger('payment_type');
            $table->enum('payment_status', ['0', '1']);         
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
        Schema::dropIfExists('payments');
    }
}
