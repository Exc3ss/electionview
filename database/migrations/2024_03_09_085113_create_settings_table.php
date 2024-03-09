<?php
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('label');
            $table->text('value')->nullable();
            $table->json('attributes')->nullable();
            $table->string('type');
            $table->timestamps();
        });

        Setting::create([
            'key' => 'elettori',
            'label' => 'Elettori',
            'value' => 1,
            'type' => 'number',
        ]);

        Setting::create([
            'key' => 'votanti',
            'label' => 'Votanti',
            'value' => 1,
            'type' => 'number',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
