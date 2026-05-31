<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email dari LevelUp - Reset Password berfungsi!', function ($msg) {
        $msg->to('angelicanazarina345@gmail.com')
            ->subject('✅ Test Reset Password LevelUp');
    });
    echo "✅ Email berhasil dikirim! Cek inbox Gmail Anda.\n";
} catch (\Exception $e) {
    echo "❌ Gagal: " . $e->getMessage() . "\n";
}
