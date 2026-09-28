# Flash — QA Knowledge

Draft, not final (generated 2026-09-24 by `knowledge-init`, then updated the
same day with the 2026-09 QA reports from test-radiate, the docs audit and the
first suite runs). See "Needs a human" at the bottom before trusting the
critical-flow ordering or anything marked TODO.

## Product

- Flash (free) 1.4.12, text domain `flash`, entry `style.css`. Pro sibling:
  `flash-pro` 2.4.17 in the same install — a separate codebase. Verify
  shared-looking code on each tier independently.
- `style.css`: `Tested up to: 6.8`, `Requires PHP: 5.6`.
- Classic PHP theme built on Underscores. No REST routes, no CPTs, no
  shortcodes, no custom tables, no `woocommerce/` template overrides.
- Customizer is built on a **bundled Kirki** (`inc/kirki/`, required at
  `functions.php:327`). `inc/customizer.php:17` does a bare `exit;` if the
  `Kirki` class is missing, and all panels/sections/fields are registered
  inside an `init` closure (`inc/customizer.php:22`).
- Front-page content is not the theme's own: the demos build it from
  **Flash Toolkit** widgets in **SiteOrigin Page Builder** layouts
  (`page-templates/pagebuilder.php`, `inc/siteorigin-panels.php`). The theme
  owns the styling and JS (`js/flash.js`, Swiper, Isotope, Waypoints,
  CounterUp registered in `functions.php:289-305`).
- Assets on every front-end view (`flash_scripts`, `functions.php:238`):
  Font Awesome 6 `all` + `v4-shims` + solid/regular/brands (templates still
  use FA4 names such as `fa-clock-o`, resolved via the shims), `style.css`,
  `css/responsive.css`, `jquery.nav`, `flash.js`, `navigation.js`,
  skip-link fix. `jquery.sticky` only when the sticky header is on
  (`functions.php:293`). `.min` unless `SCRIPT_DEBUG`.

## Settings surfaces (source-derived)

All Kirki config `flash_config`, `option_type => theme_mod`,
`capability => edit_theme_options` (`inc/customizer.php:23-29`). Line
numbers are the `add_field` call in `inc/customizer.php`.

**Beware the inverted checkboxes:** most "Disable"/"Remove" checkboxes are
off by default, and the templates show the feature when the mod is `!= '1'`.
The setting ID and the label say "remove/disable"; a truthy value hides the thing.

| Panel › Section (id) | Setting | Control / label | Default | Consumed at |
|---|---|---|---|---|
| Global › Colors › Base Colors (`flash_base_colors`) | `color_scheme` | select: default/dark/gray/red/yellow | `default` | `:1419`, `:1507` |
| | `link_color` "Primary Color" | color | scheme[1] `#30AFB8` | `flash_link_color_css` `:1679` |
| | `secondary_text_color` "Text Color" | color | scheme[3] `#666666` | `:1833` |
| Global › Colors › Heading Colors (`flash_heading_colors`) | `main_text_color` "Headings" | color | scheme[2] `#313b48` | `:1784` |
| Global › Background (`flash_background`) | core `background_color`, `background_image` (moved here, `:1108-1111`) | — | scheme[0] | core |
| Global › Layout › Site Layout | `flash_site_layout` | radio-buttonset wide/boxed | `wide` | body class `boxed` (`inc/extras.php:29`) |
| Global › Layout › Sidebar Layout | `flash_page_layout`, `flash_post_layout`, `flash_archive_layout` | radio-image right-sidebar/left-sidebar/full-width/full-width-center | `right-sidebar` | body class (`inc/extras.php:45-67`) |
| Global › Typography › Base | `flash_body_font` | Kirki typography, output on `body` | Montserrat regular | Kirki |
| Header › Site Identity (`title_tagline`) | `flash_transparent_logo` | image | `''` | `header.php:91` |
| | `flash_retina_logo` / `flash_retina_logo_upload` | checkbox + image | 0 / `''` | `inc/extras.php:635` (srcset on logo) |
| Header › Header Media (`header_image`) | core header image/video | — | — | `template-parts/header-media.php` |
| Header › Header Top Bar | `flash_top_header` "Enable" | toggle | **`1`** | `header.php:69` |
| | `flash_top_header_left` / `_right` | select social-menu/header-text/disable | `disable` | `header.php:73,76` |
| | `flash_top_header_text` | editor, `postMessage` | `''` | `flash_top_header_content` |
| Header › Primary Header | `flash_logo_position` | radio-image left-logo-right-menu / right-logo-left-menu / center-logo-below-menu | `left-logo-right-menu` | body class |
| | `flash_header_search` "Disable" | checkbox (inverted) | `''` | `header.php:143,173` |
| | `flash_header_cart` "Disable" | checkbox (inverted), needs WooCommerce | `''` | `header.php:128,158` |
| | `flash_sticky_header` "Enable" | toggle | `''` | body class `header-sticky`, enqueues `jquery.sticky` |
| Content › Page Header | `flash_pageheader_background_image` | image, `postMessage` | `''` | `flash_frontend_css` `:1861` |
| | `flash_remove_breadcrumbs` "Disable" | checkbox (inverted) | `''` | `inc/extras.php:161` |
| Content › Blog/Archive | `flash_blog_style` | radio-image classic-layout / full-width-archive / grid-view | `classic-layout` | body class |
| | `flash_remove_meta_date/_author/_comment_count/_category/_tag` | 5 checkboxes (inverted) | `''` | `inc/template-tags.php:31-65` |
| Content › Single Post | `flash_related_post_option` "Enable" | switch | `0` | `single.php:31` |
| | `flash_related_post_option_display` | radio categories/tags | `categories` | `inc/extras.php:586-592` |
| | `flash_remove_single_bio` "Disable" | checkbox (inverted) | `''` | `template-parts/author-bio.php:9` |
| | `flash_remove_single_nav` "Disable" | checkbox (inverted) | `''` | `single.php:27` |
| Footer › Footer Widgets Area | `flash_footer_widgets` | radio-image 1–4 columns | `4` | `sidebar-footer.php:33` |
| Footer › Scroll to Top | `flash_disable_back_to_top` "Disable" | checkbox (inverted) | `''` | `footer.php:49` |
| Additional › Integration | `flash_custom_css` | code — **only when `wp_update_custom_css_post()` is missing (WP < 4.7)** (`:965`) | `''` | `flash_frontend_css` |
| Additional › Optimization | `flash_disable_preloader` "Disable" | checkbox (inverted) | `''` | `header.php:38` |
| (top) `flash_upsell_section` | "View Pro version" link section | — | — | `inc/admin/class-flash-upsell-section.php` |

Core tweaks in `flash_customize_register` (`inc/customizer.php:1094`):
`blogname`, `blogdescription` and `header_textcolor` become `postMessage`, the
`header_textcolor` control is removed (it shares the heading colour), and the
core `background_image` section is removed. The four colour settings are also
`postMessage`, previewed by the JS templates at `:1655`.

Colour CSS is emitted inline only when a value **differs from the active
scheme's default** (`inc/customizer.php:1685`, strict `===` compare, so case
matters: TODO confirm that `#30afb8` saved lower-case does not emit a
redundant block).

Other theme features (`functions.php`): `custom-logo`, `custom-background`,
custom header (+ video), nav menus `primary`, `social`, `footer`; sidebars
`flash_right_sidebar`, `flash_left_sidebar`, `flash_footer_sidebar1`–`4`;
image sizes `flash-square` 300×300, `flash-big` 800×400, `flash-grid`
370×270; WooCommerce + gallery zoom/lightbox/slider; Jetpack infinite scroll
(`inc/jetpack.php`); `align-wide`, `wp-block-styles`, `responsive-embeds`,
selective-refresh widgets; editor styles (`style-editor-block.css`).
Page templates: `full-width.php`, `pagebuilder.php`.

Per-post meta boxes (`inc/meta-boxes.php`):
- "Select Layout" on posts and pages → post meta `flash_page_layout`:
  `default-layout` / right-sidebar / left-sidebar / full-width /
  full-width-center. `default-layout` or empty falls back to the Customizer
  value (`inc/extras.php:55-67`).
- "Header Transparency" on pages only → post meta `flash_transparency`:
  `transparent` / `non-transparent`, added verbatim as a body class
  (`inc/extras.php:34`).

Admin surfaces:
- Appearance → "Flash Options" (`flash-options`,
  `inc/admin/class-flash-dashboard.php:35`, `edit_theme_options`).
- Welcome notice with a demo-import button → AJAX `wp_ajax_import_button`
  (`inc/admin/class-flash-welcome-notice.php:10,103`).
- Upgrade notice and theme-review notice, both dismissible via nonced GET.

## Persistence

- Theme mods: everything in the table above (option `theme_mods_flash`),
  plus core `custom_logo`, `header_image*`, `background_*`,
  `nav_menu_locations`.
- Options: `flash_theme_installed_time`, `flash_upgrade_notice_start_time`,
  `flash_admin_notice_welcome` (+ `flash_admin_notice_*` on dismiss),
  migration flags `flash_page_header_bg_customize_migrate` and
  `flash_typography_transfer_free`.
- Post meta: `flash_page_layout`, `flash_transparency` (saved in
  `flash_save_custom_meta`, `inc/meta-boxes.php:121`, `sanitize_text_field`;
  an empty value deletes the meta).
- Transient: category count cache flushed on `edit_category` / `save_post`
  (`inc/template-tags.php:119-127`).
- No custom tables.

## Capability boundaries

| Surface | Gate | Source |
|---|---|---|
| All Customizer settings | `edit_theme_options` (Kirki config) | `inc/customizer.php:26` |
| Flash Options page | `edit_theme_options` | `class-flash-dashboard.php:38` |
| Layout / transparency meta save | nonce `flash_meta_nonce` + `edit_page` / `edit_post` | `inc/meta-boxes.php:124-138` |
| Welcome notice, demo-import AJAX | `manage_options` + `check_ajax_referer('flash_demo_import_nonce')` | `class-flash-welcome-notice.php:36,104-106` |
| Plugin install/activate from notice | `activate_plugin` | `class-flash-welcome-notice.php:128,169` |
| Upgrade notice dismiss | nonce + `publish_posts` | `class-flash-notice.php:58-81`, `class-flash-upgrade-notice.php:8` |
| Theme-review notice dismiss | nonce only | `class-flash-theme-review-notice.php:152,170` |
| Admin menu entries | `manage_options` | `class-flash-admin.php:42` |
| "Ready to publish" prompt on empty blog | `publish_posts` | `template-parts/content-none.php:19` |

## Migrations / upgrade handling

Three routines, all on `after_setup_theme`, none versioned:
1. `flash_font_family_change` (`functions.php:363`, since 1.2.8): turns the
   old string `flash_body_font` (`Montserrat:400,700` / `Raleway:…` /
   `Ruda:…`) into Kirki's array shape. It runs once, guarded by option
   `flash_typography_transfer_free`, and only if `theme_mods_flash` exists.
   TODO: a value that isn't one of the three strings falls back to Montserrat.
   Confirm with a human whether that is intended.
2. `flash_page_header_bg_customize_migrate` (`inc/migration.php:20`, since
   1.3.8): moves `flash_pageheader_background` →
   `flash_pageheader_background_image`. It runs once, guarded by an option
   (changelog 1.3.8 "Page header background image issue").
3. `flash_custom_css_migrate` (`inc/extras.php:549`): appends
   `flash_custom_css` to core Additional CSS, then removes the mod. It has no
   done-flag and re-checks on every load until the mod is gone.

## Fragile areas (git history, 653 commits, last 2026-09-03)

- **Primary colour propagation**: the most repeated fix. Changelog 1.4.5
  ("not affecting mobile cart icon colour"), 1.4.6 ("not affecting
  Preloader"), commit 276c7a7 (mobile caret icon background), and branch
  `fix/primary-color` (1615537). New UI elements keep missing from the
  hand-maintained selector list in `flash_link_color_css`
  (`inc/customizer.php:1679-1775`). Any new element needs a colour check.
- **Customizer loading / Kirki**: 1d9c261 ("customizer global not
  displaying"), changelog 1.4.11 ("Customizer section issue"), e78afe8
  (priority of theme options), 913bf80 (radio label click).
  `inc/customizer.php` modified in 40 commits.
- **Sliders / Flash Toolkit sections (theme JS)**: c736dfe (TT-3667,
  double-escaped slider nav arrows), 4db95f7 (double arrow), fecb10a
  (responsive autoplay), 58ad717 (Firefox image overlap), 214b857
  (testimonial bullets), dd48489 / 1.4.0.1 (`flash.min.js` out of sync with
  `flash.js`). Files: `js/flash.js` (19), `js/flash.min.js` (10).
  **The min file is committed and has been out of sync with the source
  before.**
- **Header cart / WooCommerce**: e485518 (fatal: `get_cart_contents_count()`
  on null; now guarded by `isset( WC()->cart )` at `header.php:158`, but
  `header.php:128` checks only `class_exists`), 1.4.5 ("Option to enable
  header cart icon not appearing").
- **Sidebar layout**: df02685 / 1.3.9 ("Blog/Post sidebar issue in Full
  width").
- **Admin notices / dashboard**: `class-flash-dashboard.php` (15),
  `class-flash-theme-review-notice.php` (14), fef3d75 ("array offset on
  value of type bool"), fc22932 (child-theme name/version).
- Most-modified files, excluding README and build files: `style.css` (96),
  `style-rtl.css` (45), `inc/customizer.php` (40), `functions.php` (35),
  `assets/sass/_theme-style.scss` (35), `inc/extras.php` (24).
  `style.css` and `style-rtl.css` are compiled from `assets/sass/`, so RTL
  can drift from LTR.

## Audit history (what the live evidence below comes from)

- **QA pass, 2026-09-18, test-radiate.local** (`flash-qa-report.html`,
  `flash-Theme-Research-and-Improvement-Report.html`,
  `flash-research/hands-on-notes.md`): WP 7.1.1, Flash 1.4.12, Flash Pro
  2.4.17, Flash Toolkit 1.2.6, SiteOrigin, Everest Forms, Starter Templates
  2.1.3; WooCommerce 11.1.0 added in a follow-up. Demo: Flash Food, plus a
  Flash Construction homepage. Chromium at 1440, 768 and 375 px. The site is
  not clean: it has Radiate leftovers (17 pages, 6 posts from 2014), and the
  admin password was reset.
- **Senior-dev audit, 2026-09-21, sandbox 127.0.0.1:8811**
  (`flash-free-pro-senior-dev-audit.html`, finding IDs FLASH-0xx, evidence in
  `flash-audit-evidence/`): fresh WP 7.1.1, PHP 8.2/8.3/8.5, WP_DEBUG on,
  WooCommerce 11.1.0. No demo; content seeded instead (14 posts, 8 products + 1
  variable, a Home/About/Blog menu). 8 third-party plugins were exercised one
  at a time.
- **Docs audit** (`themegrill-documentation-audit.html`, FLA-F1…F12):
  summarised in `.themegrill-qa/docs/flash.md`.
- **This suite, 2026-09-24**: all green on test-radiate.local (Flash active,
  construction demo, WooCommerce in coming-soon mode) and on a fresh
  WordPress Playground boot.

All report files live in the local `test-radiate` site directory (the Local site root, beside `app/`).
Issue numbers below are in **themegrill/flash-pro** (private), where the
audits filed Free and Pro bugs alike.

## Critical flows — TODO: confirm ordering with a human

Ordered by the senior-dev audit's release-risk ranking ("finalSummary"), with
areas named after the suite's `@area` tags. `suite-index.mjs` derives
`areas_uncovered` from this list, so a wrong list misdirects every later
effort. Specs exist for the areas marked (spec).

1. **homepage** — front page serves, flash.js bootstrap runs, preloader clears, one h1 (spec)
2. **woocommerce** — header cart and fragments, shop/product/cart, the page-type helper behind the "Shop" title (spec, @demo only)
3. **free-to-pro-migration** — theme_mods_flash copied into Pro on activation; `flash_pro_active` gate (#33)
4. **mobile-menu** — hamburger at ≤768 px, submenu toggles, keyboard access (#90) (spec)
5. **header** — search toggle, cart icon, 3 logo positions, sticky header, top bar, transparent header per page (spec)
6. **breadcrumbs** — the trail builder in inc/extras.php: date, category and author crumbs (#93)
7. **search** — results and zero-result pages (spec)
8. **not-found** — 404 status, heading, search form (spec)
9. **single-post** — title h1, breadcrumbs, post navigation, author bio, comments (spec)
10. **blog** — posts index, archive styles, post-meta toggles (spec)
11. **related-posts** — on/off, categories vs tags, cards without thumbnails (#32)
12. **customizer-colors** — scheme and primary/text/heading colours reaching every element (the most-repeated fix in git history)
13. **layouts** — wide/boxed; page/post/archive sidebar layouts; per-post "Select Layout" meta
14. **footer** — widget columns, copyright, scroll-to-top (spec)
15. **demo-homepage** — imported SiteOrigin + Flash Toolkit front page (spec, @demo only)
16. **demo-import** — welcome notice → Starter Templates (SiteOrigin tab, Free filter) → import
17. **admin-notices** — welcome/upgrade/review notices by role, dismiss persists

## Expected behaviour

### Live-verified (reports and this suite)

Each item was observed working, and those marked (spec) are now asserted.
- **Front page** serves 200 with no console or page errors. `#preloader-background`
  goes `display:none` about 0.6 s after ready. Exactly one h1, `.site-title`,
  on `/` (DOMJ; spec).
- **Skip link.** "Skip to content" is the first Tab stop and targets
  `#content` (MOBJ Tab order; spec).
- **Desktop header search.** `.search-icon` toggles `.search-box.active`, the
  field gets focus, Enter searches, and Escape closes it. The box is
  `visibility:hidden` while closed, so there's no invisible focus trap
  (FLASH-014 notes; spec).
- **Mobile menu.** `.menu-toggle` is `display:none` at 1366 px and visible at
  768 and 375 px. The menu starts `display:none` and slideToggles open and
  closed on tap. `aria-expanded="true"` appears only after the first tap.
  Submenus expand and collapse on the demo (DOMJ, MOBJ, QA; spec covers open
  and close).
- **Search.** `h1.trail-title` "Search Results for: <q>", breadcrumbs, results
  listed. Zero results show "Nothing Found" plus a new search form (DOMJ; spec).
- **404** serves HTTP 404 with "Oops! That page can’t be found." and a search
  form. Without WooCommerce the header h1 reads "Page NOT Found" (FLASH-003
  expected; spec).
- **Single post.** The title is the only h1 (`h1.trail-title`), the breadcrumb
  opens with `a.trail-home` → home URL, and content and post navigation
  render. On the demo, meta, categories and comments render too (DOMJ, QA; spec).
- **Posts index** lists linked post titles. As a separate posts page, it's
  titled after that page ("Blog") (DOMJ; spec).
- **Scroll-to-top.** `a#scroll-up` is hidden at the top, fades in past 1000 px
  of scroll, and animates back to 0 on click (QA; spec).
- **WooCommerce.** AJAX add-to-cart on /shop/ bumps the header `.cart-value`
  immediately. Sale products show "Sale!" and del/ins prices. Cart and
  checkout render. A long product title wraps without overflow, and a missing
  product image falls back to the placeholder. The cart icon works at desktop
  and 375 px (QA; spec covers the count and the sale badge).
- **Demo front page.** A SiteOrigin layout of Flash Toolkit widgets
  (about, blog, counter, CTA, heading, portfolio) renders with no page errors.
  The top bar shows the demo's contact text (QA; spec).
- **Header styles.** All 3 Free logo positions render with no leftovers when
  switching (QA). There's no spec yet; it needs a theme-mod fixture.
- **Related posts** are off by default. When on, "You May Also Like" shows 3
  `.tg-column-3` cards drawn at random from posts sharing a category
  (`orderby rand`). A card without an image omits `.post-thumbnails` (QA).
- **Customizer** loads with 0 errors in about 1.5 s. It has 163 settings
  (91 postMessage). `flash_site_layout` and `flash_body_font` refresh the
  preview (FLASH-041).
- **Robustness.** No `img` without `alt`. 0 px horizontal overflow at 1366
  and 768 px, and at 375 px without WooCommerce. No theme PHP messages on
  8.2/8.3/8.5 except FLASH-023. 2–9 theme queries per page with no N+1.
  No cron events. No third-party front-end requests (Kirki self-hosts the
  fonts). A child theme can override `flash_footer_copyright()` and
  `content-none.php` cleanly (DOMJ, perf, FLASH-035).
- **Plugin compatibility (sandbox).** CF7 and Everest Forms submit and
  validate. With Elementor, the default template is 786 px beside the sidebar
  and Canvas is full-bleed. Yoast, Rank Math, LiteSpeed and Polylang (`/fr/` →
  `lang="fr-FR"`) produce 0 PHP messages.

### From source
- On a fresh install the header top bar renders (`flash_top_header`
  defaults to `1`), but both halves default to `disable`, so it is present
  and empty. The sandbox headings fit this; the demo fills it. TODO (human):
  is that intended, or should it default off?
- Search icon, cart icon, breadcrumbs, author bio, post navigation,
  scroll-to-top, preloader and all five post-meta items show by default.
  Each one is hidden by its "Disable" checkbox.
- The header cart icon appears only with WooCommerce active
  (`header.php:128,158`).
- Hiding the header text (`display_header_text` off) visually hides the site
  title and tagline with clip CSS. They stay in the DOM (`inc/customizer.php:1891`).
- Excerpt length is 20 words (`inc/extras.php:393`).
- `woocommerce_breadcrumb` is removed and WooCommerce page titles are hidden
  (`inc/woocommerce.php:21,24`). The theme's page header shows the shop title
  instead (`flash_page_title`, `inc/extras.php:377`). This is by design.
- TODO (human): with `tags` selected for related posts and an untagged post,
  confirm the result is empty rather than unfiltered.

## Known issues

Quarantined scenarios (`test.fixme`, each carrying an `@guards` tag) exist
for the ones marked (fixme). Each was confirmed to fail on test-radiate.local
on 2026-09-24. Drop the `.fixme` in the PR that fixes it.

**Free, or shared by Free and Pro**
- **#82 (Major, FLASH-001) — preloader never hides without jQuery Migrate.**
  `jQuery( window ).load(fn)` at `js/flash.js:121` throws
  `e.indexOf is not a function` on jQuery 3. The overlay stays up, and sticky
  header, counter, scroll-to-top and slider fixes never run. Any
  performance plugin that drops Migrate triggers it. Free only.
- **#30 (High, QA BUG-01) — header search unreachable below ~576 px.**
  `.header-action-container` is 0×0, and the hamburger panel has no search
  form. This affects all 3 Free header styles; Pro is fine (fixme,
  `header-search.spec.ts`).
- **#90 (Medium, FLASH-014) — hamburger and search toggles are `<div>`s**
  with no role, name or tabindex (`header.php:117-119, 145-147`), so they
  aren't keyboard-operable (fixme, `mobile-menu-toggle.spec.ts`).
- **#84 (Medium, FLASH-003/017/035) — page-header title reads "Shop" and
  headings duplicate.** With WooCommerce active, `flash_is_woocommerce_page()`
  (`inc/extras.php:511`) loosely compares `get_the_ID()` to the shop page ID.
  The 404, an empty search, `/?author=999`, Cart, Checkout and My Account
  all get WooCommerce's title. Seen live on 2026-09-24: the 404 shows "Shop",
  and a zero-result search shows "Search results: “…”". `/blog/` has two
  h1s (the bar plus index.php's screen-reader h1). The helper can't be
  overridden in a child theme (fatal) (fixme ×3: not-found, search, blog).
- **#83 (Medium, FLASH-002) — header cart fatal when `WC()->cart` is null**
  (REST/headless renders). Master guards only the default layout
  (`header.php:158`); `center-logo-below-menu` (`header.php:128-136`) still
  fatals, and so does Pro's `cart-icon.php:9`. The released 1.4.12 zip
  fatals on both.
- **#92 (Low, FLASH-019/020) — sideways scroll on phones.** With
  WooCommerce, the hidden mini-cart adds 2–4 px at 320–412 px. The 404's
  300 px `fa-exclamation-circle` pushes scrollWidth to 493 at 375 px (fixme,
  `not-found.spec.ts`).
- **#91 (Medium, FLASH-015/018) — contrast and landmarks.** Post meta is
  `#8e8e8e` on white (3.27:1). The Home crumb is `#a1a1a1` on `#fafafa`
  (2.47:1). axe finds 37 contrast failures on /blog/ and 19 on a single post.
  The nav landmarks are unlabelled, and the breadcrumb has a redundant role.
- **#93 (Low, FLASH-021/022/023) — breadcrumbs.** The day-archive month link
  is `/2026/00/`. A category name with a comma splits into two crumbs and
  leaves a tag open (`inc/extras.php:222-223`). `/author/nobody/` logs
  `Attempt to read property "display_name" on bool` (8.2) or `on false`
  (8.3+) (`inc/extras.php:329`).
- **#32 (Medium, QA BUG-03) — related-posts grid misaligns** when a related
  post has no featured image. It's intermittent because selection is random.
- **#88 (Medium, FLASH-011/034) — Kirki downloads Google Fonts inside the
  visitor request.** Cold TTFB is 2.39 s vs 0.40 s warm. With an unwritable
  `wp-content/fonts`, every request takes 6.2–6.4 s and logs 27 `copy()`
  warnings. The editor loads fonts from Google's CDN.
- **#21 comment (FLASH-012) — 5 Font Awesome handles, 406 KB** (46 % of the
  Free home page). `fa-opencart` pulls in the brands font.
- **#101 (Low, FLASH-042) — font-swap CLS 0.186** on desktop home.
- **#96 (Low, FLASH-025) — shop, category and product pages show the blog
  sidebar.** There's no `sidebar-shop.php` (open since themegrill/flash#26).
  QA saw a full-width shop because of the demo's layout setting.
- **#86 (Medium, FLASH-005) — the welcome installer bypasses
  `DISALLOW_FILE_MODS`.** `wp_ajax_import_button` checks only
  `manage_options`. FLASH-006 (Flash Toolkit): anonymous updater triggers
  write `flash_toolkit_admin_notices`.
- **#87 (Low, FLASH-008/009) — related-posts `title="<?php the_title() ?>"`**
  is exploitable only with wptexturize off. The meta-box save reads
  `$_POST['flash_page_layout']` without `isset` (`inc/meta-boxes.php:144`)
  and stores any string as a body class.
- **#95 (FLASH-024/030/031).** `$content_width` is computed too early (780
  on full width). There's dead code: `Flash_Site_Library` is never loaded and
  `inc/customizer/class-flash-upsell-custom-control.php` is 0 bytes. The
  `flash_categories` transient never expires.
- **#94 (FLASH-026) — footer credit markup.** `href="…"target=` has no space,
  and the sentence is built from concatenated translatable strings.
- **#97 (FLASH-033).** The released 1.4.12 zip lacks master's fixes.
  `Tested up to: 6.8` and `Requires PHP: 5.6` are stale. #24 (FLASH-029):
  `flash.pot` dates from 2022.
- **#99 (FLASH-039).** There's no `wpml-config.xml`, so
  `flash_top_header_text` can't be translated.
- **#40 (FLASH-040) — Elementor Full Width is clamped to 1200 px** by
  `.tg-container`.
- **#33 (High, QA BUG-04 / FLASH-036) — Free→Pro settings aren't carried
  over** after the first Pro activation. `flash_pro_active` is set before the
  copy and is never cleared.
- **#31 (High, Flash Toolkit 1.2.6) — repeater widgets** (Slider,
  Testimonial, Pricing Table) return 500 in the block Widgets screen
  (`get_current_screen()` undefined).
- **Starter Templates / demo (TDI).** Demo media is hotlinked from
  themegrilldemos.com (#15). The Elementor tab's Free filter is empty (#16).
  The import dialog has a11y errors (#19). Notices appear on every admin
  screen (#23). The Flash Food gallery section is blank (not filed).

**Source-only, not in any report**
- `flash_scroll_to_top_fixed_header` (a heading-only `custom` control) is
  registered twice (`inc/customizer.php:897` and `:920`). The first one sits
  in the Footer Widgets block. TODO: check for a duplicate "Fixed" heading in
  Footer › Scroll to Top.

**Pro only (for context):** #34 (split menu renders 3 navs), #85 (author
social XSS), #89 (Freemius on every request), #14 (empty shop sidebar column),
#18, #20, #22.

## Doc drift

Docs could not be fetched live (see `.themegrill-qa/docs/flash.md`). These
drift items come from the 2026-09 docs audit and QA pass:
- `DOC DRIFT: https://docs.themegrill.com/flash/docs/upgrading-flash-to-flash-pro/`
  says "All your content theme settings will remain as it is even after
  switching to the Pro theme". The product copies settings only on Pro's
  first-ever activation (#33). The same claim appears at
  …/docs/will-i-lose-my-work-if-i-update-from-the-free-version-to-the-pro-version/
  (FLA-F1, P0).
- `DOC DRIFT: …/flash/docs/customize-primary-header/` documents the header
  Search option with no caveat. The product's Free header search is
  unreachable below ~576 px (#30), and …/customize-primary-menu/ covers only
  mobile colours (FLA-F10).
- `DOC DRIFT: …/flash/docs/customize-primary-header/` says Sticky "keeps the
  header in the same place". The product pins the top bar too, about 190 px
  at desktop. The docs don't say whether that's intended (FLA-F9;
  QA INVESTIGATION-01).
- `DOC DRIFT: https://themegrill.com/flash-free-vs-pro/` lists sticky
  header, header layouts and the preloader as Pro-gated. Free actually ships
  a Sticky toggle, 3 logo positions and the preloader.
- Undocumented behaviour: Kirki's slow first load (FLA-F3), the "Shop" h1 and
  the shop blog sidebar (FLA-F7), repeater widgets in the block Widgets screen
  (FLA-F6), and Elementor/SiteOrigin usage (FLA-F5). There's no Flash-specific
  demo-import page (FLA-F2).

## Test harness notes

- **Sites.** The local suite runs against test-radiate.local (Flash active,
  construction demo, WooCommerce, admin creds in `.env.local`). CI and
  `run-suite.mjs --boot playground` run the `@fresh` tier on a bare Playground
  install with no WooCommerce, no Flash Toolkit and no demo. Every `@fresh`
  spec must hold on both.
- **Posts index location differs.** Playground creates a "Blog" page but
  leaves `show_on_front = posts`, so its posts index is `/`. On the demo site
  it's `/blog/`. Use `visitPostsIndex()` (`tests/e2e/utils/page.ts`), which
  finds `body.blog`.
- **Preloader.** It covers the page for about 600 ms. Call `visit()` /
  `waitForPreloader()` after every navigation.
- **Misleading selectors.**
  - The desktop `#primary-menu` `<ul>` has zero height (floated items), so
    assert on its links.
  - `.menu-toggle` and `.search-icon` are divs, so `getByRole('button')`
    finds nothing.
  - `.search-icon` reads `display:block` at 375 px inside a 0×0 container,
    so use the bounding box.
  - The breadcrumb Home link is `a.trail-home` with no `rel`.
  - The hidden mini-cart's `<h2>Cart</h2>` pollutes heading counts.
- **WooCommerce coming-soon mode** is on for anonymous visitors on
  test-radiate.local, and WooCommerce switches it back on whenever it's
  toggled. Shop specs run as the saved admin. The admin's cart persists
  across runs, so assert relative counts and clean up (see
  `header-cart.spec.ts`).
- **Header cart after removal.** The header `.cart-value` wasn't refreshed
  within 5 s after removing a line on the classic cart page. Reload before
  asserting. Whether it should update live is unverified: TODO confirm
  whether the cart page is meant to fire `wc_fragment_refresh`.
- **Font swap** shifts the desktop nav by about 21 px at 0.5–0.6 s. Wait for
  `document.fonts.ready` before asserting geometry. The first request after
  activation or a font change is slow (Kirki downloads the fonts).
- **Related posts are random.** Seed candidates that all have, or all lack,
  images.
- **Toolkit repeater widgets** can only be seeded through SiteOrigin (#31).
- Never log in per spec; `auth.setup.ts` saves one session. wp-login's
  post-load scripts can race `fill()`, so the setup verifies both fields
  without printing them.
- Theme mods are per stylesheet (`theme_mods_flash` vs `theme_mods_flash-pro`).
  `flash_pro_active` persists, so reset it between migration tests. Check the
  active theme before probing.

## Known non-issues — TODO: confirm with a human

- No WooCommerce breadcrumb and no WooCommerce page title in the content
  area: deliberate (`inc/woocommerce.php`).
- The Custom CSS field is absent from Additional › Integration on WP ≥ 4.7.
  This is deliberate; old values are migrated to Additional CSS.
- Classic Editor opening for new pages comes from SiteOrigin, not the theme.
- WPForms failing to submit is identical on Twenty Twenty-Five, so it's not
  Flash.
- Everest Forms desktop failure was harness timing. The "image 404" and
  "959 KB image" findings were a dev-router artefact (`%20` not decoded).
- The Freemius fatal on Pro came from a git clone without submodules, not
  from the product.
- `flash_font_family_change()` does not overwrite a later body-font choice.
  Revisions store no `flash_page_layout` meta. The footer blogname is escaped.
  The preloader does not slow LCP.
- Needs a product ruling rather than a bug report: sticky header including
  the top bar (about 190 px), and the `/portfolio/` archive being a 1-column
  list.

## What must survive an upgrade — TODO: unknown, no human input yet

From source, the candidates are the ~35 theme mods above, the two post-meta
keys, the three migrations (`flash_body_font` shape, page-header background
key, custom CSS → Additional CSS), menu assignments to `primary` / `social` /
`footer`, and the contents of the six widget areas. Live evidence: sidebar
widgets survive the Free → Pro switch, and theme mods do only on Pro's
first-ever activation (#33). A maintainer needs to say which ones are
promised.

## Sources

- Source: this checkout at 1.4.12 (b517fee, 2026-09-03), branch
  `add/claudegrill-qa-setup`.
- Reports: `test-radiate/flash-qa-report.html`,
  `flash-free-pro-senior-dev-audit.html` (+ `flash-audit-evidence/`),
  `flash-Theme-Research-and-Improvement-Report.html`, `flash-research/*.md`,
  `themegrill-documentation-audit.html`.
- Docs: not ingested. docs.themegrill.com blocks this machine's IP (BlogVault
  firewall, 403, reference 5752720196ab511afc1a50). The secondary summary is
  in `.themegrill-qa/docs/flash.md`.
- Git: `git log` over 653 commits, `README.md` changelog 1.3.2–1.4.12.
- Suite runs: 2026-09-24. `@fresh` 15 passed + 6 fixme on test-radiate.local
  and on Playground. `@demo` 4 passed. Repeat ×3 with no flakes.

## Needs a human

- Critical-flow list and ordering: now ordered by the audit's risk ranking,
  still unconfirmed.
- Rulings: the empty top bar on a fresh install; sticky pinning the top bar;
  the related-posts tags fallback; whether the classic cart page should
  refresh the header count live.
- Known non-issues: seeded from the audits, unconfirmed.
- What must survive an upgrade: unknown.
- Docs: re-run `ingest-docs.mjs` from an unblocked network, and ask whoever
  runs docs.themegrill.com to clear the BlogVault block (ref above).
- `area_paths` in suite.json: drafted from source, needs review.
