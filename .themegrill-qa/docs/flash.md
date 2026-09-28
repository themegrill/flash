# Flash — documentation (secondary source)

**Not an ingest.** `ingest-docs.mjs` could not read docs.themegrill.com on
2026-09-24. Every route (REST `doc_category`, `/sitemap.xml`,
`/wp-sitemap.xml`, `/sitemap_index.xml`, the page itself) returned HTTP 403 from
the site's BlogVault firewall ("Blocked because of Malicious Activities",
reference 5752720196ab511afc1a50) to curl, headless and headed Chromium, and an
external fetcher alike. What follows is what the 2026-09 documentation audit
(`test-radiate/themegrill-documentation-audit.html`, section "Flash & Flash
Pro", findings FLA-F1…F12) and the Flash QA report recorded about each page.
Quotes are the auditors' quotes of the docs, not a fresh read.

Re-run `ingest-docs.mjs --rest https://docs.themegrill.com/flash` from an
unblocked network (or after the firewall entry is cleared) to replace this file
with a real ingest and a `docs-index.json`.

## Pages the audit read

| Doc page | What it says / covers | Audit verdict |
|---|---|---|
| https://docs.themegrill.com/flash/ | Index of categorised articles (Global, Header, Content, Footer, Widgets, WooCommerce, Pricing & License) | Customizer articles "genuinely good, Flash-specific, and accurate" |
| …/flash/docs-category/header/ | Header Customizer articles | accurate |
| …/flash/docs-category/content/ | Content Customizer articles | accurate |
| …/flash/docs/customize-primary-header/ | Sticky Header "keeps the header in the same place"; QA quotes it as making "the header section sticky when the user scrolls down the page content". Also documents Header › Primary Header › Search | Silent on whether the top bar is part of the sticky block (FLA-F9) |
| …/flash/docs/customize-primary-menu/ | Mobile Menu section: colours only | Does not mention that the Free header search is unreachable on phones (FLA-F10) |
| …/flash/docs/optimization/ | Preloader, Scrollbar, Animation | No troubleshooting for the slow Kirki first load (FLA-F3) |
| …/flash/docs/customize-woocommerce-shop-page/ | Products Per Page, Products Per Row | Nothing on the "Shop" h1 or Free's blog sidebar on shop pages (FLA-F7) |
| …/flash/docs-category/widgets/ | 30 Flash Toolkit widget pages, fields only | No warning about repeater widgets in the block Widgets screen (FLA-F6) |
| …/flash/docs/upgrading-flash-to-flash-pro/ | Install Pro, then Appearance › Themes › Activate. "All your content theme settings will remain as it is even after switching to the Pro theme." | **Contradicted by the product** (FLA-F1, P0) |
| …/flash/docs/add-portfolio-to-wordpress-site/ | Portfolio setup | Archive layout not described; body not fully read (FLA-F11) |

Generic pages the audit tied to Flash: …/docs/will-i-lose-my-work-if-i-update-from-the-free-version-to-the-pro-version/
(same retention claim), …/docs/importing-demo-content/ (one sentence),
…/docs/how-to-import-demo-content-in-themegrill-themes/ (no builder
prerequisites or media handling), …/docs/how-to-check-plugin-conflict/,
…/docs/translate-wordpress-themes-and-plugins-using-polylang/ (generic), and
…/docs/wordpress-site-too-slow-causes-and-solutions/.

## Stated outcomes usable as assertions

- Upgrade: settings "will remain as it is" after switching to Pro (false after
  a second Pro activation; see knowledge.md Doc drift).
- Primary Header › Sticky Header: header stays pinned while scrolling.
- Primary Header › Search: the header search icon can be enabled/disabled.
- WooCommerce shop page: Products Per Page and Products Per Row control the grid.

## Gaps the audit found (no page exists)

Flash-specific demo import (FLA-F2); Elementor / SiteOrigin usage and the
1200 px Full Width clamp (FLA-F5); a widget overview index; troubleshooting
(the sitewide category holds one unrelated article; two Flash knowledgebase
category URLs return 404).
