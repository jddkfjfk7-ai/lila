# Kero Chess finalization audit

## Scope

This audit records the repository-level identity and release changes applied to the Kero Chess product branch. It does not claim that every upstream source file was rewritten: the product deliberately retains the mature Lila chess/game/server implementation.

## Identity replacement

- Kero Chess is the product name used by the web application metadata and lobby.
- Kero logo and Kero background are original assets under `public/brand/`.
- Kero 2D vector chess pieces are original assets under `public/piece/kero/`.
- Kero is the default 2D piece set.
- Kero is the default board theme.
- Legacy favicon, Apple touch icon, and the identified Lichess logo asset were removed after the application favicon path was moved to Kero.
- The default external Lichess background URL was removed from preferences.

## Legal boundary

The upstream Lila source remains AGPL-3.0-or-later and retains its copyright/license notices. Kero ownership applies to original Kero-authored branding, artwork, product-layer changes, and other original contributions, not to third-party or upstream material. Third-party assets remain subject to their own licenses.

## Functional foundation present on this branch

- Online chess/game server core
- Realtime sockets
- Analysis and Fishnet integration
- Existing abuse/fair-play systems
- AI game setup with levels 1-8
- Training, studies, tournaments, Swiss, simuls and community routes already provided by the underlying platform
- Kero lobby/platform navigation
- PWA manifest and service-worker foundation
- Production configuration/runbook and CI packaging

## Verification boundary

The CI workflow now watches server, UI and public asset changes on push as well as pull requests. A source-level audit cannot substitute for a production build. Final release status requires the CI build/test/stage job to pass and staging verification for MongoDB, Redis, realtime sockets, Fishnet/Stockfish workers, HTTPS/WSS, email, backups, monitoring and load/soak testing.

## Explicit non-claims

This branch must not be described as having a 100% cheat-detection guarantee, as having a newly implemented proprietary AI Coach/Player DNA/Smart Training engine unless those components are separately implemented and tested, or as having passed production load/security testing without evidence.
