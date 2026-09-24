import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

/**
 * @area header
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ, FLASH-014) 2026-09-21
 * @why header.php:173 renders the search icon unless flash_header_search is
 *      set (default ''). js/flash.js:39-49 toggles .search-box.active on click
 *      and focuses the field; the box is visibility:hidden until then, so it is
 *      not an invisible focus trap. Guards the default-on desktop search end to
 *      end. Does not cover the Disable setting (needs a theme-mod fixture).
 */
test("the header search icon opens a focused search form that returns results @fresh @header", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 900 });
  await visit(page, "/");

  const wrap = page.locator("#masthead .header-action-container .search-wrap");
  const box = wrap.locator(".search-box");
  const field = box.getByRole("searchbox", { name: "Search for:" });
  await expect(field).toBeHidden();

  await wrap.locator(".search-icon").click();
  await expect(box).toHaveClass(/\bactive\b/);
  await expect(field).toBeVisible();
  await expect(field).toBeFocused();

  await field.fill("a");
  await field.press("Enter");
  await expect(page).toHaveURL(/[?&]s=a\b/);
  await expect(page.getByRole("main").locator("article").first()).toBeVisible();
});

/**
 * @area header
 * @tier fresh
 * @source js/flash.js:52-64
 * @why Escape closes an open header search box (keyup 27 → hideSearchForm).
 */
test("Escape closes the open header search box @fresh @header", async ({ page }) => {
  await page.setViewportSize({ width: 1440, height: 900 });
  await visit(page, "/");

  const wrap = page.locator("#masthead .header-action-container .search-wrap");
  await wrap.locator(".search-icon").click();
  await expect(wrap.locator(".search-box")).toHaveClass(/\bactive\b/);

  await page.keyboard.press("Escape");
  await expect(wrap.locator(".search-box")).not.toHaveClass(/\bactive\b/);
  await expect(wrap.getByRole("searchbox")).toBeHidden();
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area header
 * @tier fresh
 * @source flash-qa-report.html BUG-01, 2026-09-18
 * @guards themegrill/flash-pro#30
 * @why Below ~576 px `.header-action-container` collapses to a 0×0 box, so
 *      the header search cannot be reached at all on phones, on all three Free
 *      header styles, and the hamburger panel holds no search form either.
 *      `.search-icon` still computes display:block, so assert on the box size.
 */
test.fixme("header search is reachable at 375 px @fresh @header", async ({ page }) => {
  await page.setViewportSize({ width: 375, height: 812 });
  await visit(page, "/");

  const box = await page.locator("#masthead .header-action-container .search-icon").boundingBox();
  expect(box?.width ?? 0).toBeGreaterThan(0);
  expect(box?.height ?? 0).toBeGreaterThan(0);
});
