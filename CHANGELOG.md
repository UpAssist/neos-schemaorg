# Changelog

All notable changes to this project are documented in this file. The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and this project follows [Semantic Versioning](https://semver.org/).

Neos 8 releases (1.x) live on the `1.x` branch, Neos 9 releases (2.x) on `main`.

## 1.1.1 - 2026-11-19

### Fixed

- Organization `logo` pointed at a non-existing path (`/_Resources/Persistent/<sha1>/<file>`), a 404 with Flow's default subdivided resource paths. It is now rendered with `Neos.Fusion:ResourceUri` as an absolute URL.
- The Service `provider.url` now uses the `UpAssist.Neos.SchemaOrg.siteUrl` fallback like Organization and LocalBusiness, via a shared `UpAssist.Neos.SchemaOrg:Helper.SiteUrl` prototype.

### Changed

- Require `neos/neos: ^8.3` (was `^8.0`): tested on Neos 8.3 and 8.4.
