<?php

declare(strict_types=1);

use Honed\Billing\Migrations\BillingMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends BillingMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('group')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->string('price_id');
            $table->timestamps();
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
