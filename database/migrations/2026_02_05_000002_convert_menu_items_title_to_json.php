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
        // Convert menu_items.title to JSON
        Schema::table('menu_items', function (Blueprint $table) {
            $table->json('title_new')->nullable()->after('parent_id');
        });

        // Migrate existing data
        $items = DB::table('menu_items')->get();
        foreach ($items as $item) {
            DB::table('menu_items')
                ->where('id', $item->id)
                ->update(['title_new' => json_encode(['tr' => $item->title, 'en' => $item->title, 'de' => $item->title])]);
        }

        // Drop old column and rename new
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->renameColumn('title_new', 'title');
        });

        // Convert menus.name to JSON
        Schema::table('menus', function (Blueprint $table) {
            $table->json('name_new')->nullable()->after('id');
        });

        // Migrate existing data
        $menus = DB::table('menus')->get();
        foreach ($menus as $menu) {
            DB::table('menus')
                ->where('id', $menu->id)
                ->update(['name_new' => json_encode(['tr' => $menu->name, 'en' => $menu->name, 'de' => $menu->name])]);
        }

        // Drop old column and rename new
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('name_new', 'name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert menu_items.title to string
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('title_old')->nullable()->after('parent_id');
        });

        $items = DB::table('menu_items')->get();
        foreach ($items as $item) {
            $title = json_decode($item->title, true);
            DB::table('menu_items')
                ->where('id', $item->id)
                ->update(['title_old' => $title['tr'] ?? '']);
        }

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->renameColumn('title_old', 'title');
        });

        // Revert menus.name to string
        Schema::table('menus', function (Blueprint $table) {
            $table->string('name_old')->nullable()->after('id');
        });

        $menus = DB::table('menus')->get();
        foreach ($menus as $menu) {
            $name = json_decode($menu->name, true);
            DB::table('menus')
                ->where('id', $menu->id)
                ->update(['name_old' => $name['tr'] ?? '']);
        }

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('name_old', 'name');
        });
    }
};
