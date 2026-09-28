# PHP migration status

The original Scala/Play implementation is preserved.

Completed in the PHP branch:
- PHP 8.3 Composer project
- PSR-4 application structure
- HTTP request/response/router kernel
- environment configuration
- JSON request handling
- initial Main and Auth controllers
- MongoDB and Redis infrastructure adapters
- initial chess domain types

Remaining migration areas include the complete controller/module graph, authentication/security parity, MongoDB repositories, Redis/pubsub, WebSocket server, chess rules/parsing, tournaments, studies, forums, teams, search, analysis, Stockfish/Fishnet integration, translations, templates, and complete API route parity.

No original source file is deleted as part of this migration.
