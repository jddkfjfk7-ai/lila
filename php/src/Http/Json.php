<?php
declare(strict_types=1);
namespace Lila\\Http;

final class Json
{
    public static function body(Request $request): array
    {
        $contentType = strtolower($request->headers['Content-Type'] ?? $request->headers['content-type'] ?? '');
        if (str_contains($contentType, 'application/json')) {
            $raw = file_get_contents('php://input') ?: '';
            if ($raw === '') return [];
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        }
        return $request->body;
    }
}
