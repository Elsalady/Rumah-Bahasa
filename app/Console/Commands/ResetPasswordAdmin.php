<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordAdmin extends Command
{
    protected $signature = 'admin:reset-password {email?} {password?}';
    protected $description = 'Ganti password akun admin (default: admin@rumahbahasa.com)';

    public function handle(): int
    {
        $email = $this->argument('email') ?: 'admin@rumahbahasa.com';

        $admin = User::where('role', 'admin')->where('email', $email)->first();

        if (!$admin) {
            $this->error("Akun admin dengan email {$email} tidak ditemukan.");
            return self::FAILURE;
        }

        $password = $this->argument('password');

        if (!$password) {
            $password = Str::password(16);
            $this->line("Password baru (acak): {$password}");
            $this->warn('Simpan password ini! Tidak akan ditampilkan lagi.');
        }

        $admin->update([
            'password' => Hash::make($password),
            'status' => 'approved',
        ]);

        $this->info("✅ Password admin {$admin->name} ({$admin->email}) berhasil diganti.");

        return self::SUCCESS;
    }
}
