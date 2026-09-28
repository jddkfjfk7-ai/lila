# Kero Chess production runbook

Kero Chess keeps Lila's realtime chess architecture underneath the product layer. The repository already contains server-side protections for rate limiting, IP trust/proxy detection, Playban, Fishnet analysis limits, Irwin analysis, and Kaladin integration.

## Anti-cheat posture

Use multiple independent signals: server-authoritative moves; move timing and clock history; Fishnet/Stockfish analysis; Irwin engine-like move/timing patterns; Kaladin behavioral/statistical detection when deployed; Playban abuse controls; IP/proxy trust; and human moderation/reporting.

No anti-cheat system can guarantee perfect detection. Do not ban from a single high-accuracy game or one heuristic. Combine evidence across games and retain an appeal path.

## Required production services

- MongoDB replica set with backups
- Redis
- Lila web/API
- lila-ws realtime service
- Fishnet analysis workers
- HTTPS/WSS reverse proxy or load balancer
- Monitoring, metrics and alerting
- Transactional email
- Push provider when mobile push is enabled
- IP/proxy intelligence when enabled
- Kaladin service and queue integration when behavioral ML detection is enabled

## Required security settings

- Keep `net.ratelimit = true`.
- Keep `fishnet.offline_mode = false`.
- Use unique production secrets for password reset, email confirmation, login tokens, Turnstile and security integrations.
- Use HTTPS everywhere; WebSockets must use WSS.
- Never cache authenticated HTML, API responses, game state or WebSocket data in the service worker.
- Keep MongoDB and Redis on private networks.
- Restrict administrative/moderation endpoints behind authentication and network controls.
- Enable backups and regularly test restoration.

## Anti-cheat staging tests

- Normal human games across time controls.
- Very high-accuracy legitimate games.
- Engine-assisted staging accounts.
- Live-game analysis attempts.
- Analysis request flooding.
- Multiple accounts behind one IP.
- VPN/Tor/proxy traffic.
- WebSocket reconnect/flood behavior.
- Account/session invalidation.
- Fishnet worker failure and recovery.

## Release gate

Public launch requires all of the following to be verified in staging: server compilation and tests, asset compilation, formatting/linting, realtime connectivity, authentication/session flows, rate limiting, backups and restore, monitoring/alerts, email delivery, push delivery where enabled, moderation flows, anti-cheat staging scenarios, HTTPS/WSS, and rollback procedures.

The PWA layer is an installable web app; it is not a substitute for separately packaged native Android/iOS applications.

Only open public registration after the server build, asset build, tests, security checks, realtime stack and external services pass staging.
