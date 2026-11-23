# Changelog

All notable changes to this project are documented in this file. The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and this project follows [Semantic Versioning](https://semver.org/).

Neos 9 releases (2.x) live on `main`, Neos 8 releases (1.x) on the `1.x` branch.

## 2.0.7 - 2026-11-23

### Fixed

- FAQ items without a question (or without an answer) were emitted as a `Question` with `name: null` or an empty `acceptedAnswer`, which is invalid schema.org and makes Google reject the whole FAQPage. Such items are now skipped, and a page whose FAQ items are all incomplete gets no FAQPage block.
- The FAQPage of a page also listed the FAQ items of all its child pages (on the home page: every FAQ item of the site). Only FAQ items in the page's own content collections are used now, as Google only accepts FAQ markup for questions shown on the page itself.

## 2.0.6 - 2026-11-20

### Fixed

- Organization, LocalBusiness and Service JSON-LD now have their own content cache entry, tagged with the site node (Service also with its document). Before, a change to a site-level schema.org property only showed on pages whose own cache entry was flushed for another reason; all other pages kept the old values until the `Neos_Fusion_Content` cache was flushed.

## 2.0.5 - 2026-11-19

### Fixed

- Organization, LocalBusiness and Service `provider` URLs were always empty (or the `siteUrl` setting) on Neos 9, because `site.context` no longer exists. The first active Neos Domain of the site is used again, via a shared `UpAssist.Neos.SchemaOrg:Helper.SiteUrl` prototype; `UpAssist.Neos.SchemaOrg.siteUrl` stays the fallback, now also for the Service provider.
- LocalBusiness never rendered on Neos 9: the homepage check compared two Node instances. It now compares the aggregate ids.
- Organization `logo` pointed at a non-existing path (`/_Resources/Persistent/<sha1>/<file>`), a 404 with Flow's default subdivided resource paths. It is now rendered with `Neos.Fusion:ResourceUri` as an absolute URL.
- README: the license is MIT (as in `LICENSE`), not proprietary.
