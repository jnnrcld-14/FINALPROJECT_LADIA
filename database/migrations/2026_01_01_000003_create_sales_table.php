<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{Schema::create('sales',function(Blueprint $t){$t->id();$t->foreignId('product_id')->constrained()->restrictOnDelete();$t->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();$t->foreignId('sold_by')->constrained('users')->restrictOnDelete();$t->unsignedInteger('quantity');$t->decimal('total_price',10,2);$t->timestamps();});}public function down():void{Schema::dropIfExists('sales');}};
