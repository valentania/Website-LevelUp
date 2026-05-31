<?php

namespace App\Services;

use App\Enums\ComplexityLevelEnum;

class ComplexityCheckerService
{
    /**
     * Keywords indicating missions that are too complex for the platform.
     */
    private const BLOCKED_KEYWORDS = [
        'marketplace', 'e-commerce', 'toko online besar', 'enterprise', 'ERP', 'CRM',
        'aplikasi mobile', 'android app', 'ios app', 'react native', 'flutter',
        'machine learning', 'artificial intelligence', 'blockchain', 'cryptocurrency',
        'sistem informasi lengkap', 'full-stack application', 'full stack app', 'saas platform',
        'payment gateway custom', 'streaming platform', 'aplikasi kompleks',
    ];

    private const MAX_COMPLEXITY_SCORE = 50;

    /**
     * Auto-detect complexity level based on mission data.
     */
    public function detect(array $data): ComplexityLevelEnum
    {
        $score = $this->calculateScore($data);

        return match (true) {
            $score <= 15 => ComplexityLevelEnum::EASY,
            $score <= 35 => ComplexityLevelEnum::MEDIUM,
            default      => ComplexityLevelEnum::HARD,
        };
    }

    /**
     * Check if a mission is too complex for the platform.
     */
    public function isTooComplex(array $data): bool
    {
        $score = $this->calculateScore($data);
        $hasBlockedKeyword = $this->containsBlockedKeywords($data['description'] ?? '');

        return $score > self::MAX_COMPLEXITY_SCORE || $hasBlockedKeyword;
    }

    /**
     * Get the rejection reason if applicable.
     */
    public function getRejectionReason(array $data): ?string
    {
        if ($this->containsBlockedKeywords($data['description'] ?? '')) {
            return 'Mission mengandung permintaan yang terlalu kompleks untuk platform ini (contoh: marketplace, aplikasi mobile, enterprise system). LevelUp dirancang untuk bantuan digital sederhana.';
        }

        if ($this->calculateScore($data) > self::MAX_COMPLEXITY_SCORE) {
            return 'Mission memiliki tingkat kompleksitas yang melebihi batas platform. Silakan sederhanakan permintaan Anda agar sesuai dengan kemampuan mahasiswa.';
        }

        return null;
    }

    /**
     * Calculate complexity score based on various factors.
     */
    private function calculateScore(array $data): int
    {
        $score = 0;
        $description = $data['description'] ?? '';
        $requirements = $data['requirements'] ?? '';
        $wordCount = str_word_count($description);

        // Description length scoring
        $score += match (true) {
            $wordCount > 300 => 20,
            $wordCount > 100 => 10,
            default          => 5,
        };

        // Requirements complexity
        if ($requirements) {
            $requirementLines = count(array_filter(explode("\n", $requirements)));
            if ($requirementLines > 5) $score += 15;
            elseif ($requirementLines > 3) $score += 8;
        }

        // Deadline pressure
        if (isset($data['deadline'])) {
            $daysUntilDeadline = now()->diffInDays($data['deadline'], false);
            if ($daysUntilDeadline < 3) $score += 10;
            elseif ($daysUntilDeadline < 7) $score += 5;
        }

        // Category-based scoring
        $categoryScores = [
            'landing-page' => 10,
            'desain-poster' => 5,
            'social-media' => 5,
            'canva' => 3,
            'excel' => 5,
            'edukasi-digital' => 3,
            'lainnya' => 8,
        ];
        $score += $categoryScores[$data['category'] ?? 'lainnya'] ?? 5;

        // Keyword-based scoring
        $descriptionLower = strtolower($description);
        if (str_contains($descriptionLower, 'custom')) $score += 10;
        if (str_contains($descriptionLower, 'integrasi')) $score += 15;
        if (str_contains($descriptionLower, 'database')) $score += 10;
        if (str_contains($descriptionLower, 'api')) $score += 10;

        return $score;
    }

    /**
     * Check if description contains any blocked keywords.
     */
    private function containsBlockedKeywords(string $text): bool
    {
        $textLower = strtolower($text);

        foreach (self::BLOCKED_KEYWORDS as $keyword) {
            if (str_contains($textLower, strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }
}
