<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('provinces')) {
            Schema::create('provinces', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('name_en')->nullable();
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('province_id')->default(1);
                $table->string('code')->nullable();
                $table->string('name')->nullable();
                $table->string('name_en')->nullable();
                $table->integer('count_area')->default(0);
                $table->string('posx')->nullable();
                $table->string('posy')->nullable();
                $table->text('boundary')->nullable();
                $table->integer('district_selection_count')->default(0);
                $table->integer('expert_required_points')->default(0);
                $table->boolean('active')->default(1);
                $table->unsignedBigInteger('post_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('districts')) {
            Schema::create('districts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('city_id');
                $table->string('name')->nullable();
                $table->string('name_en')->nullable();
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('estates')) {
            Schema::create('estates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('province_id')->default(1);
                $table->unsignedBigInteger('city_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('expert_id')->nullable();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('phone')->default('09120000000');
                $table->decimal('price', 15, 2)->default(0);
                $table->decimal('rent', 15, 2)->default(0);
                $table->decimal('deposit', 15, 2)->default(0);
                $table->integer('area')->default(0);
                $table->integer('rooms')->default(0);
                $table->integer('floors')->default(0);
                $table->integer('floor')->default(0);
                $table->integer('type')->default(1);
                $table->string('estate_type')->nullable();
                $table->boolean('confirm')->default(1);
                $table->boolean('visibility')->default(1);
                $table->string('confirmation')->default('verified');
                $table->timestamp('showdate')->nullable();
                $table->text('description')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // Seed default province & cities if empty
        if (DB::table('provinces')->count() == 0) {
            DB::table('provinces')->insert([
                ['id' => 1, 'name' => 'دبی', 'name_en' => 'Dubai', 'active' => 1],
                ['id' => 2, 'name' => 'تهران', 'name_en' => 'tehran', 'active' => 1],
            ]);
        }

        if (DB::table('cities')->count() == 0) {
            DB::table('cities')->insert([
                ['id' => 1, 'province_id' => 1, 'name' => 'دبی', 'name_en' => 'Dubai', 'active' => 1],
                ['id' => 2, 'province_id' => 2, 'name' => 'تهران', 'name_en' => 'tehran', 'active' => 1],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
    }
};
