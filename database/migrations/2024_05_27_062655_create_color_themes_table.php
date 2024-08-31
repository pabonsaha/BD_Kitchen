<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('color_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->tinyInteger('type')->default(0)->comment("0 = Frontend, 1 = Admin Panel");
            $table->string('primary_color', 30)->nullable();
            $table->string('secondary_color', 30)->nullable();
            $table->string('background_color', 30)->nullable();
            $table->string('button_bg_color', 30)->nullable();
            $table->string('button_text_color', 30)->nullable();
            $table->string('hover_color', 30)->nullable();
            $table->string('border_color', 30)->nullable();
            $table->string('text_color', 30)->nullable();
            $table->string('secondary_text_color', 30)->nullable();
            $table->string('shadow_color', 30)->nullable();
            $table->string('sidebar_bg', 30)->nullable();
            $table->string('sidebar_hover', 30)->nullable();
            $table->tinyInteger('active_status')->default(0);
            $table->tinyInteger('theme_status')->default(1)->comment("0 = Admin Define, 1 = Custom Define");
            $table->unsignedBigInteger('created_by')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('updated_by')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
        // insert record
        $colors = [
            [
                'name' => 'Default',
                'type' => 1, // '0 = Frontend, 1 = Admin Panel'
                'primary_color' => '#6f40ad',
                'secondary_color' => '#fffffff2',
                'button_bg_color' => '#6523bb',
                'background_color' => '#f8f7fa',
                'button_text_color' => '#ffffff',
                'hover_color' => '#ebebeb',
                'border_color' => '#6523bb',
                'text_color' => '#000000',
                'secondary_text_color' => '#ffffff',
                'shadow_color' => '#000000',
                'sidebar_bg' => '#ffffff',
                'sidebar_hover' => '#ebebeb',
            ],
            [
                'name' => 'Default',
                'type' => 0, // '0 = Frontend, 1 = Admin Panel'
                'primary_color' => '#343a40',
                'secondary_color' => '#6c757d',
                'background_color' => '#ffffff',
                'button_bg_color' => '#343a40',
                'button_text_color' => '#ffffff',
                'hover_color' => '#1d2124',
                'border_color' => '#343a40',
                'text_color' => '#000000',
                'secondary_text_color' => '#ffffff',
                'shadow_color' => '#000000',
                'sidebar_bg' => '#343a40',
                'sidebar_hover' => '#6c757d',
            ]
        ];

        foreach ($colors as $key => $color) {
            DB::table('color_themes')->insert([
                'name' => $color['name'],
                'type' => $color['type'],
                'primary_color' => $color['primary_color'],
                'secondary_color' => $color['secondary_color'],
                'background_color' => $color['background_color'],
                'button_bg_color' => $color['button_bg_color'],
                'button_text_color' => $color['button_text_color'],
                'hover_color' => $color['hover_color'],
                'border_color' => $color['border_color'],
                'text_color' => $color['text_color'],
                'secondary_text_color' => $color['secondary_text_color'],
                'shadow_color' => $color['shadow_color'],
                'sidebar_bg' => $color['sidebar_bg'],
                'sidebar_hover' => $color['sidebar_hover'],
                'active_status' => 1,
                'theme_status' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_themes');
    }
};
