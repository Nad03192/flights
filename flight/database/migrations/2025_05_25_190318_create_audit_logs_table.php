<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type'); 
            $table->unsignedBigInteger('auditable_id'); 
            $table->string('event');        
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->json('old_values')->nullable(); 
            $table->json('new_values')->nullable();  
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}

