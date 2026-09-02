<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\MemberCode;
use Illuminate\Console\Command;

class GenerateMemberCode extends Command
{
    protected $signature = 'member:generate-code {--reset : Kosongkan semua member_code lalu generate ulang dari 001}';
    protected $description = 'Isi member_code (RB-DDMMYY-NNN) untuk member berstatus approved yang belum memilikinya';

    public function handle(): int
    {
        if ($this->option('reset')) {
            $this->warn('Menghapus semua member_code yang sudah ada...');
            User::query()->update(['member_code' => null]);
        }

        $members = User::where('role', 'member')
            ->where('status', 'approved')
            ->whereNull('member_code')
            ->orderBy('created_at')
            ->get();

        if ($members->isEmpty()) {
            $this->info('Semua member sudah memiliki kode member.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($members->count());
        $bar->start();

        foreach ($members as $member) {
            $member->update(['member_code' => MemberCode::generate($member->created_at)]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Berhasil mengisi kode untuk {$members->count()} member.");

        return self::SUCCESS;
    }
}
