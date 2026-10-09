<?php

namespace App\Helpers;

// Import class dari paket statickidz
use Statickidz\GoogleTranslate;

class TranslationHelper
{
    public static function translateText($text)
    {
        if (empty($text)) {
            return $text;
        }

        // Ambil session bahasa aktif saat ini di Bali Ease
        $currentLang = session('locale', 'id');

        // Jika bahasa yang aktif Indonesia ('id'), langsung tampilkan teks asli
        if ($currentLang === 'id') {
            return $text;
        }

        // Jika bahasa Inggris ('en'), jalankan translasi otomatis lewat paket statickidz
        try {
            $trans = new GoogleTranslate();

            // Parameter: translate($source, $target, $text)
            return $trans->translate('id', 'en', $text);
        } catch (\Exception $e) {
            // Jika internet server putus atau limit, kembali ke bahasa Indonesia agar web tidak crash
            return $text;
        }
    }
}
