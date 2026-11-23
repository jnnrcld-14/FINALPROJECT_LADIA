<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{Schema::create('customers',function(Blueprint $t){$t->id();$t->string('full_name');$t->string('email')->unique();$t->string('phone',30)->nullable();$t->timestamps();});}public function down():void{Schema::dropIfExists('customers');}};
