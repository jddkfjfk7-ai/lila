<?php
declare(strict_types=1);
namespace Lila\\Domain;

use Lila\\Domain\\Chess\\GameStatus;

final class Game
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $whitePlayerId,
        public readonly ?string $blackPlayerId,
        public GameStatus $status = GameStatus::CREATED,
        public int $whiteTimeMs = 0,
        public int $blackTimeMs = 0,
    ) {}
}
