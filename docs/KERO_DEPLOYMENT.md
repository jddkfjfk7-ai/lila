# Kero Chess — Deployment

## What you can download

The repository itself is the source release. GitHub can download the selected branch as a ZIP from the branch page. The CI workflow also packages the compiled server as `kero-chess-3.0.tar.zst` and publishes it as the `kero-chess-server` workflow artifact when CI succeeds.

## Minimum production topology

Kero is not a single static PHP-style upload. Lila's architecture uses an asynchronous Scala server, MongoDB, Redis, a separate realtime WebSocket service, and Fishnet/Stockfish workers. The upstream architecture documents the same core components. See the official Lila repository for the architecture and installation baseline.

Recommended topology:

Internet
  |
HTTPS/WSS load balancer or nginx
  |
  +-- Kero web/API nodes (2+)
  +-- Kero realtime / lila-ws nodes
  +-- MongoDB replica set (private)
  +-- Redis (private)
  +-- Fishnet/engine workers
  +-- SMTP provider
  +-- monitoring/alerting

## Server requirements

Use Linux x86_64 for the first production deployment unless your hosting provider has been validated for the required JVM/engine workloads.

Install:
- Java 21
- sbt
- Node/pnpm as required by the repository build
- MongoDB replica set
- Redis
- nginx or another HTTPS/WSS reverse proxy
- Fishnet/Stockfish workers

The GitHub workflow is the authoritative build check: it runs `./lila.sh -Depoll=true "test;stage"` and formatting checks.

## Configuration

Copy `docs/KERO_PRODUCTION_ENV.example` into your secret manager and replace every placeholder.

Start with:

`-Dconfig.file=conf/kero-production.conf`

Do not commit production secrets.

## Reverse proxy

Terminate TLS at the load balancer/nginx and proxy both HTTP and WebSocket traffic. Preserve the WebSocket Upgrade/Connection headers and use WSS externally.

Do not expose MongoDB or Redis directly to the Internet.

## First deployment sequence

1. Provision DNS and TLS.
2. Provision private MongoDB and Redis.
3. Provision the Kero server nodes.
4. Provision lila-ws/realtime.
5. Provision Fishnet workers.
6. Configure SMTP.
7. Fill the production environment variables.
8. Build the release and run unit/integration tests.
9. Run staging with registration restricted.
10. Verify login, game creation, reconnects, analysis, bots, tournaments, moderation and rate limits.
11. Verify backups and perform a restore drill.
12. Run load/soak tests.
13. Switch public traffic to the release.
14. Keep the previous release available for rollback.

## Important

The PWA is an installable web application; it is not a native Android/iOS binary.

Do not call the deployment production-ready until CI and staging pass. Source code alone cannot prove database, realtime, engine-worker, email, TLS, backup or load-test behavior.
