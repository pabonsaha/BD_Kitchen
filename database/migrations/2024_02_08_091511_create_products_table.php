<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vendor;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->foreignIdFor(User::class)->references('id')->on('users')->onDelete('cascade');
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(Brand::class)->nullable();
            $table->foreignIdFor(Vendor::class)->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->string('video_link')->nullable();
            $table->text('tags')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('purchase_price')->nullable();
            $table->text('attributes')->nullable();
            $table->json('choice_options')->nullable();
            $table->text('weight_dimensions')->nullable();
            $table->text('specifications')->nullable();
            $table->longText('shipping_policy')->nullable();
            $table->longText('return_policy')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->integer('discount_type')->nullable();
            $table->double('discount')->nullable();
            $table->integer('tax_type')->nullable();
            $table->double('tax')->nullable();
            $table->string('unit')->nullable();
            $table->integer('num_of_sale')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_img')->nullable();
            $table->tinyInteger('is_approved')->default(1);
            $table->tinyInteger('is_published')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
