# Kero Chess

Kero Chess is an independent chess platform built from the open-source Lila chess server.

## Product identity

- Brand: **Kero Chess**
- Original Kero logo and visual identity live under `public/brand/`.
- Original Kero 2D chess pieces live under `public/piece/kero/`.
- Kero is the default 2D piece set and Kero is the default board theme.

## Upstream and licensing

Kero Chess contains modified Lila code. The upstream Lila code is licensed under the GNU Affero General Public License v3 or later. Upstream copyright and license notices remain part of the project where applicable.

Kero-authored original product assets and modifications are identified in [KERO-COPYRIGHT.md](KERO-COPYRIGHT.md). Third-party assets retain their own licenses; see [COPYING.md](COPYING.md) before redistribution or commercial packaging.

This project must not present Lichess trademarks, logos, restricted artwork, or upstream branding as Kero Chess-owned material.

## Platform

Kero keeps the mature realtime chess/game infrastructure while adding an independent product layer for:

- Online rated, casual and custom games
- Chess variants, tournaments, Swiss events and simuls
- Puzzles, training, studies and opening exploration
- Analysis and game insights
- AI games with built-in engine levels
- Community, teams, players and social features
- Responsive web app / PWA foundations
- RTL/LTR and multilingual UI foundations
- Production security, fair-play and operational hardening

## Development

The server uses Scala 3, Play/Pekko, MongoDB, Redis, TypeScript and Sass. See [KERO_DEPLOYMENT.md](docs/KERO_DEPLOYMENT.md) for production topology and deployment requirements.

Run the project with the normal Lila development workflow:

```bash
./lila.sh
```

## Production

Do not treat a source checkout as a production build. Production deployment requires a successful build/test/stage pipeline plus staging verification of database, realtime sockets, Fishnet/Stockfish workers, HTTPS/WSS, backups, email and monitoring.

See:

- [Kero production deployment](docs/KERO_DEPLOYMENT.md)
- [Kero production runbook](docs/KERO_PRODUCTION_RUNBOOK.md)
- [Kero release status](docs/KERO_RELEASE_STATUS.md)
- [Global benchmark](docs/KERO_GLOBAL_BENCHMARK.md)
