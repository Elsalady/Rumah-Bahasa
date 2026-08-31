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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_member', 30)->nullable()->after('id');
        });

        // Backfill nomor member untuk data lama berdasarkan tanggal gabung (created_at)
        $members = DB::table('users')->where('role', 'member')->orderBy('created_at')->get();
        foreach ($members as $i => $member) {
            DB::table('users')->where('id', $member->id)->update([
                'no_member' => 'RB-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_member');
        });
    }
};
