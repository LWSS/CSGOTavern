<?php

/**
 * Part of the Stripe Billing Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe Billing Laravel
 * @version    3.0.1
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartalystStripeBillingCreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('billable_type')->index();
            $table->integer('billable_id')->index()->unsigned();
            $table->string('stripe_id')->index();
            $table->string('subscription_id')->nullable();
            $table->string('currency');
            $table->string('description')->nullable();
            $table->decimal('subtotal', 15, 4);
            $table->decimal('total', 15, 4);
            $table->decimal('application_fee', 15, 4)->nullable();
            $table->decimal('amount_due', 15, 4);
            $table->boolean('attempted')->default(0);
            $table->integer('attempt_count')->unsigned()->default(0);
            $table->boolean('closed')->default(0);
            $table->boolean('paid')->default(0);
            $table->text('metadata')->nullable();
            $table->timestamps();
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->timestamp('next_payment_attempt')->nullable();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_invoices');
    }
}
