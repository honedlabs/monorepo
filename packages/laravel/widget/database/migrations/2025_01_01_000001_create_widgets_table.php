<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Honed\Widget\Migrations\WidgetMigration;

return new class extends WidgetMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scope');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['name', 'scope']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTable());
    }
};
