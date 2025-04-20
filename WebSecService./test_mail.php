<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

try {
    $link = 'https://example.com/test-verification';
    $name = 'Test User';
    
    Mail::to('test@example.com')->send(new VerificationEmail($link, $name));
    
    echo "Email sent successfully!\n";
} catch (\Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}
