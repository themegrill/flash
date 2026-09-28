import { test, expect } from "../../fixtures";
import { visitPostsIndex } from "../../utils/page";

/**
 * @area blog
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ) 2026-09-21
 * @why The posts index lists linked post titles. When it is a separate posts
 *      page (not the front page), the page-header bar is titled with that
 *      page's name (flash_page_title, is_home branch, inc/extras.php:369-371).
 */
test("the posts index lists linked posts, titled after the posts page @fresh @blog", async ({
  page,
}) => {
  const { isFrontPage } = await visitPostsIndex(page);

  if (!isFrontPage) {
    await expect(page.locator("h1.trail-title")).toHaveText("Blog");
  }

  const articles = page.getByRole("main").locator("article");
  expect(await articles.count()).toBeGreaterThan(1);
  await expect(articles.first().locator(".entry-title a")).toHaveAttribute("href", /\S/);
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area blog
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html FLASH-017, 2026-09-21
 * @guards themegrill/flash-pro#84
 * @why index.php adds a screen-reader h1 "Blog" on top of the page-header
 *      bar's h1, so /blog/ has two h1s. Confirmed live on test-radiate.local
 *      2026-09-24 (`h1.trail-title` + `h1.page-title.screen-reader-text`).
 */
test.fixme("the posts page has exactly one h1 @fresh @blog", async ({ page }) => {
  const { isFrontPage } = await visitPostsIndex(page);
  test.skip(isFrontPage, "only a separate posts page gets the extra h1");
  await expect(page.locator("h1")).toHaveCount(1);
});
