# UpAssist.Neos.SchemaOrg

Reusable Neos CMS package that adds Schema.org structured data (JSON-LD) to your website. All content is editable via the Neos inspector — no YAML configuration needed for content.

## Features

| Schema Type | Scope | Description |
|---|---|---|
| **Organization** | All pages | Company name, logo, phone, email, social media |
| **LocalBusiness** | Homepage | Extends Organization with address, geo coordinates, service area |
| **WebPage** | All pages | Page name, description, dateModified |
| **Service** | Per page (opt-in) | Service type, description, area served |

## Installation

Pick the constraint that matches your Neos version:

| Neos version | Composer constraint      | Branch   |
| ------------ | ------------------------ | -------- |
| Neos 8.x     | `^1.0` or `dev-neos-8`   | `neos-8` |
| Neos 9.x     | `^2.0` or `dev-main`     | `main`   |

This branch targets **Neos 8**.

```bash
composer require upassist/neos-schemaorg:^1.0
```

Or add to your `composer.json`:

```json
{
    "require": {
        "upassist/neos-schemaorg": "^1.0"
    },
    "repositories": {
        "upassist/neos-schemaorg": {
            "type": "git",
            "url": "git@github.com:UpAssist/neos-schemaorg.git"
        }
    }
}
```

## Usage

### Organization + LocalBusiness (for your site root node)

Add the `LocalBusiness` mixin to your homepage/site node type. This includes Organization automatically.

```yaml
'Your.Site:Document.Home':
  superTypes:
    'UpAssist.Neos.SchemaOrg:Mixin.LocalBusiness': true
```

If you only need Organization (no address/geo data), use it directly:

```yaml
'Your.Site:Document.Home':
  superTypes:
    'UpAssist.Neos.SchemaOrg:Mixin.Organization': true
```

### Service (for service/product pages)

Add the `Service` mixin to page types where editors should be able to define a service:

```yaml
'Your.Site:Document.Page':
  superTypes:
    'UpAssist.Neos.SchemaOrg:Mixin.Service': true
```

Service schema only renders when the editor fills in a **Service type** — leaving it empty means no Service JSON-LD is output.

### WebPage

WebPage schema is automatically rendered on all pages — no configuration needed. It uses the page title, meta description, and last modification date.

## Inspector UI

After adding the mixins, editors see a **Schema.org** tab in the Neos inspector with the following groups:

- **Organization** — Name, description, logo, phone, email, social media URLs
- **Local Business** — Street address, postal code, city, region, country, coordinates, area served
- **Service** — Service type, description, service area override

## How it works

The package augments `Neos.Neos:Page` automatically via `Page.fusion` — no manual Fusion includes needed. Each component has `@if` conditions:

- **Organization** — renders on all pages if the site node has the mixin
- **LocalBusiness** — renders only on the homepage
- **WebPage** — renders on all pages (uses Neos.Seo meta description and title)
- **Service** — renders only when `schemaOrgServiceType` is filled in

All JSON-LD is only rendered in the `live` workspace (not in the Neos backend).

## Available Mixins

### `UpAssist.Neos.SchemaOrg:Mixin.Organization`

| Property | Type | Description |
|---|---|---|
| `schemaOrgName` | string | Organization name (falls back to site title) |
| `schemaOrgDescription` | string | Organization description |
| `schemaOrgLogo` | Image | Organization logo |
| `schemaOrgPhone` | string | Phone number |
| `schemaOrgEmail` | string | Email address |
| `schemaOrgSameAs` | string | Social media URLs (one per line) |

### `UpAssist.Neos.SchemaOrg:Mixin.LocalBusiness`

Extends Organization with:

| Property | Type | Description |
|---|---|---|
| `schemaOrgStreetAddress` | string | Street address |
| `schemaOrgPostalCode` | string | Postal code |
| `schemaOrgCity` | string | City |
| `schemaOrgRegion` | string | Region/province |
| `schemaOrgCountry` | string | Country code (default: NL) |
| `schemaOrgLatitude` | string | GPS latitude |
| `schemaOrgLongitude` | string | GPS longitude |
| `schemaOrgAreaServed` | string | Comma-separated list of locations |

### `UpAssist.Neos.SchemaOrg:Mixin.Service`

| Property | Type | Description |
|---|---|---|
| `schemaOrgServiceType` | string | Type of service |
| `schemaOrgServiceDescription` | string | Service description (falls back to meta description) |
| `schemaOrgServiceAreaServed` | string | Service area (falls back to site-level area served) |

## Requirements

- Neos CMS 8.x
- PHP 8.1+

## License

Proprietary — UpAssist
