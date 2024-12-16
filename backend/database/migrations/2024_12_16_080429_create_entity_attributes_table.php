<?php

use App\Enums\AttributeTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entity_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type')->comment('Attribute Types: ' . implode(', ', AttributeTypeEnum::values()));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_attributes');
    }
};
