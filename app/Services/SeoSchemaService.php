<?php

namespace App\Services;

class SeoSchemaService
{
    /**
     * Otomatis Generate Identity Schema (LocalBusiness & ProfessionalService)
     * Menggabungkan data identitas dasar dengan detail bisnis lokal untuk SEO Google Maps
     */
    public static function generateLocalBusiness(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            '@id' => url('#localbusiness'),
            'name' => 'Bali Ease - Visa & KITAS Specialist',
            'alternateName' => 'Bali Ease',
            'url' => url('/'),
            'logo' => asset('favicon.png'),
            'image' => [
                asset('images/hero-bali.jpg'),
                asset('favicon.png')
            ],
            'description' => 'Mitra terpercaya pengurusan Visa, KITAS, dan PMA di Bali. Proses cepat, transparan, dan aman.',
            'telephone' => '+6281547410870',
            'priceRange' => '$$',
            'currenciesAccepted' => 'IDR, USD',
            'paymentAccepted' => 'Cash, Credit Card, Bank Transfer',
            
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jl. Raya Denpasar No. 123 (Sesuaikan alamat asli)',
                'addressLocality' => 'Denpasar',
                'addressRegion' => 'Bali',
                'postalCode' => '80113',
                'addressCountry' => 'ID'
            ],
            
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '-8.670458',
                'longitude' => '115.212629'
            ],
            
            'hasMap' => 'https://maps.google.com/?cid=DAN_SETERUSNYA_SAMPAI_LINK_MAPS_ANDA', // Ganti dengan link embed Google Maps asli Anda
            
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '17:00'
                ]
            ],
            
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '142',
                'bestRating' => '5',
                'worstRating' => '1'
            ],
            
            'sameAs' => [
                'https://x.com/balieasevisa',
                'https://instagram.com/balieasevisa'
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * Otomatis Generate BreadcrumbList berdasarkan segmen URL aktif saat ini
     */
    public static function generateBreadcrumbs(): string
    {
        $segments = request()->segments();
        $crumbs = [];
        $currentUrl = url('/');

        $crumbs[] = [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => $currentUrl
        ];

        foreach ($segments as $index => $segment) {
            $currentUrl .= '/' . $segment;
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $index + 2,
                'name' => ucwords(str_replace('-', ' ', $segment)),
                'item' => $currentUrl
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $crumbs
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * Otomatis Generate FAQPage dari data array/koleksi database
     */
    public static function generateFaq(array|object $faqItems): string
    {
        $elements = [];

        foreach ($faqItems as $item) {
            $question = is_object($item) ? ($item->question ?? $item->pertanyaan ?? null) : ($item['question'] ?? $item['pertanyaan'] ?? null);
            $answer = is_object($item) ? ($item->answer ?? $item->jawaban ?? null) : ($item['answer'] ?? $item['jawaban'] ?? null);

            if ($question && $answer) {
                $elements[] = [
                    '@type' => 'Question',
                    'name' => strip_tags($question),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($answer)
                    ]
                ];
            }
        }

        if (empty($elements)) return '';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $elements
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}