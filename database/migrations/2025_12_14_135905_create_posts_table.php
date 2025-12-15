<?php


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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->text('description');

            $table->decimal('target_amount', 15, 2)->default(0);
            $table->decimal('collected_amount', 15, 2)->default(0);

            $table->json('images')->nullable()->after('description');

            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])
                ->default('active')
                ->index();

            $table->timestamp('deadline')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index(['category_id', 'status']);
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
