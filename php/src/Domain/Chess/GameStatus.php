<?php
declare(strict_types=1);
namespace Lila\\Domain\\Chess;

enum GameStatus: string {
    case CREATED='created';
    case STARTED='started';
    case MATE='mate';
    case RESIGN='resign';
    case DRAW='draw';
    case ABORTED='aborted';
}
