<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;
class CreateTableSample extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sample', function(Blueprint $table)
		{
			$table->string('id',64)->index();
			$table->string("CustomerName",255);
			$table->date("DatePurchase");
			$table->double("AmountDue",8,2)->default(0);
			$table->double("Discount",8,2)->default(0);
			$table->double("GST",8,2)->default(0);
			$table->double("TotalPriceBeforeDisc",8,2)->default(0);
			$table->timestamp("created_at")->default(DB::RAW("now()"));
			$table->timestamp("updated_at");
			$table->primary('id');
			$table->unique('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sample');
	}

}
