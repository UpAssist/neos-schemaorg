# UpAssist.Neos.SchemaOrg

Reusable Neos CMS package that adds Schema.org structured data (JSON-LD) to your website. All content is editable via the Neos inspector — no YAML configuration needed for content.

## Features

| Schema Type       | Scope              | Description                                                      |
| ----------------- | ------------------ | ---------------------------------------------------------------- |
| **Organization**  | All pages          | Company name, logo, phone, email, social media                   |
| **LocalBusiness** | Homepage           | Extends Organization with address, geo coordinates, service area |
| **WebPage**       | All pages          | Page name, description, dateModified                             |
| **Service**       | Per page (opt-in)  | Service type, description, area served                           |
| **FAQPage**       | Per page (opt-in)  | Aggregates all `FaqItem`-mixed nodes on a page into one JSON-LD  |

## Installation

Pick the constraint that matches your Neos version:

| Neos version | Composer constraint      | Branch   |
| ------------ | ------------------------ | -------- |
| Neos 8.x     | `^1.0` or `dev-neos-8`   | `neos-8` |
| Neos 9.x     | `^2.0` or `dev-main`     | `main`   |

This branch targets **Neos 9**.

```bash
composer require upassist/neos-schemaorg:^2.0
```

Or add to your `composer.json`:

```json
{
    "require": {
        "upassist/neos-schemaorg": "^2.0"
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

### FAQPage (for Q&A content)

Add the `FaqItem` mixin to any NodeType that represents a single question/answer pair. The item must expose `question` and `answer` properties.

```yaml
'Your.Site:Content.Faq.Item':
  superTypes:
    'UpAssist.Neos.SchemaOrg:Mixin.FaqItem': true
  properties:
    question:
      type: string
    answer:
      type: string
```

The package aggregates every `FaqItem`-mixed node on a document into a single `FAQPage` JSON-LD block. No wrapper NodeType is required — drop one or more items into a page and the schema is emitted automatically.

## Inspector UI

After adding the mixins, editors see a **Schema.org** tab in the Neos inspector with the following groups:

- **Organisatie** — Name, description, logo, phone, email, social media URLs
- **Lokaal bedrijf** — Street address, postal code, city, region, country, coordinates, area served
- **Dienst** — Service type, description, service area override

## How it works

The package augments `Neos.Neos:Page` automatically via `Page.fusion` — no manual Fusion includes needed. Each component has `@if` conditions:

- **Organization** — renders on all pages if the site node has the mixin
- **LocalBusiness** — renders only on the homepage
- **WebPage** — renders on all pages (uses Neos.Seo meta description and title)
- **Service** — renders only when `schemaOrgServiceType` is filled in
- **FAQPage** — renders when at least one `FaqItem`-mixed node exists on the document

All JSON-LD is only rendered in the live rendering mode (not in the Neos backend).

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

| Property                      | Type   | Description                                            |
| ----------------------------- | ------ | ------------------------------------------------------ |
| `schemaOrgServiceType`        | string | Type of service                                        |
| `schemaOrgServiceDescription` | string | Service description (falls back to meta description)   |
| `schemaOrgServiceAreaServed`  | string | Service area (falls back to site-level area served)    |

### `UpAssist.Neos.SchemaOrg:Mixin.FaqItem`

Marker mixin — adds no properties itself. The host NodeType must expose `question` and `answer` properties for the aggregator to pick up.

## Requirements

- Neos CMS 9.x
- PHP 8.2+

For Neos 8 support, use the [`neos-8` branch](https://github.com/UpAssist/neos-schemaorg/tree/neos-8) or install `^1.0`.

## License

Proprietary — UpAssist
