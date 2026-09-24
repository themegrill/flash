import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

/**
 * @area search
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ headings) 2026-09-21
 * @why flash_page_title() (inc/extras.php:366) titles a results page
 *      "Search Results for: <query>" in the page-header bar, with the
 *      breadcrumb trail beside it, and search.php lists the matches. The audit
 *      recorded exactly that h1 on `/?s=audit`.
 */
test("a search with matches shows the query in the page header and lists results @fresh @search", async ({
  page,
}) => {
  const response = await visit(page, "/?s=a");
  expect(response?.ok()).toBeTruthy();

  await expect(page.locator("h1.trail-title")).toHaveText("Search Results for: a");
  await expect(page.locator("nav#flash-breadcrumbs")).toBeVisible();
  await expect(page.getByRole("main").locator("article").first()).toBeVisible();
});

/**
 * @area search
 * @tier fresh
 * @source template-parts/content-none.php; live on test-radiate.local 2026-09-24
 * @why With no matches content-none.php renders "Nothing Found" and a fresh
 *      search form, so the visitor can retry.
 */
test("a search with no matches says Nothing Found and offers a new search @fresh @search", async ({
  page,
}) => {
  await visit(page, "/?s=zzqqxxnomatch");

  const main = page.getByRole("main");
  await expect(main.getByRole("heading", { name: "Nothing Found" })).toBeVisible();
  await expect(main.locator("article")).toHaveCount(0);
  await expect(main.getByRole("searchbox")).toBeVisible();
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area search
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html FLASH-003, 2026-09-21
 * @guards themegrill/flash-pro#84
 * @why With WooCommerce active, flash_is_woocommerce_page() (inc/extras.php:511)
 *      loosely compares get_the_ID() to the shop page ID, so a zero-result
 *      search takes WooCommerce's title ("Search results: “…”") instead of
 *      the theme's. Seen live on test-radiate.local 2026-09-24. Without
 *      WooCommerce this passes.
 */
test.fixme("a zero-result search keeps the theme's page-header title @fresh @search", async ({
  page,
}) => {
  await visit(page, "/?s=zzqqxxnomatch");
  await expect(page.locator("h1.trail-title")).toHaveText("Search Results for: zzqqxxnomatch");
});
