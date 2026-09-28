import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

/**
 * @area not-found
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ, runtime matrix) and
 *         flash-qa-report.html "Tested — No Issue Found" 2026-09-18/21
 * @why An unknown URL serves HTTP 404 with 404.php's "Oops! That page can’t be
 *      found." heading and a search form, inside the normal header and
 *      footer. Does not assert the page-header bar title (see the quarantined
 *      scenario below).
 */
test("an unknown URL serves a 404 with the not-found heading and a search form @fresh @not-found", async ({
  page,
}) => {
  const response = await visit(page, "/no-such-page-claudegrill/");
  expect(response?.status()).toBe(404);

  const main = page.getByRole("main");
  await expect(main.getByRole("heading", { name: "Oops! That page can’t be found." })).toBeVisible();
  await expect(main.getByRole("searchbox")).toBeVisible();
  await expect(page.locator("#masthead")).toBeVisible();
  await expect(page.locator("#colophon")).toBeVisible();
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area not-found
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html FLASH-003, 2026-09-21
 * @guards themegrill/flash-pro#84
 * @why With WooCommerce active the 404's page-header h1 reads "Shop"
 *      (flash_is_woocommerce_page() loose ID compare, inc/extras.php:511).
 *      Seen live on test-radiate.local 2026-09-24. Without WooCommerce it
 *      correctly reads "Page NOT Found" (inc/extras.php:364).
 */
test.fixme("the 404 page header reads Page NOT Found @fresh @not-found", async ({ page }) => {
  await visit(page, "/no-such-page-claudegrill/");
  await expect(page.locator("h1.trail-title")).toHaveText("Page NOT Found");
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area not-found
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html FLASH-020, 2026-09-21
 * @guards themegrill/flash-pro#92
 * @why The 404's decorative `i.fa.fa-exclamation-circle` is 300 px wide and
 *      pushes the page to scrollWidth 493 at 375 px (118 px of sideways scroll).
 */
test.fixme("the 404 page has no horizontal scroll at 375 px @fresh @not-found", async ({ page }) => {
  await page.setViewportSize({ width: 375, height: 812 });
  await visit(page, "/no-such-page-claudegrill/");
  const overflow = await page.evaluate(
    () => document.documentElement.scrollWidth - document.documentElement.clientWidth,
  );
  expect(overflow).toBeLessThanOrEqual(0);
});
