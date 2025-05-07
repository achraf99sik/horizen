<?php

declare(strict_types=1);

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
        Schema::create('nationalities', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('nationalities')->insert([
            ['name' => 'Afghan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Albanian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Algerian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'American', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Andorran', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Angolan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Argentine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Armenian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Australian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Austrian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Azerbaijani', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bahraini', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bangladeshi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Belgian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beninese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brazilian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'British', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bulgarian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Canadian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chilean', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chinese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Colombian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Croatian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Czech', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Danish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dutch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Egyptian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emirati', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'English', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ethiopian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finnish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'French', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'German', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ghanaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Greek', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hungarian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Indian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Indonesian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Iranian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Iraqi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Irish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Israeli', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Italian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Japanese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jordanian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kenyan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kuwaiti', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lebanese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Libyan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Malaysian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mexican', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Moroccan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nigerian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Norwegian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakistani', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Palestinian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Polish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Portuguese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qatari', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Romanian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Russian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Saudi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senegalese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'South African', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spanish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sudanese', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Swedish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Swiss', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Syrian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tunisian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Turkish', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ukrainian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Yemeni', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nationalities');
    }
};
