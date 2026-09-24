import { test, expect } from "../../fixtures";
import { visitPostsIndex, waitForPreloader } from "../../utils/page";

/**
 * @area single-post
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ headings, navs) and
 *         flash-qa-report.html "Tested — No Issue Found" 2026-09-18/21
 * @why A single post shows its title as the page's only h1 (the page-header
 *      bar, `h1.trail-title`), a breadcrumb trail starting at Home, the post
 *      content, and post navigation (single.php:27, on unless
 *      flash_remove_single_nav). Reached from the posts index so it works on any
 *      site's content.
 */
test("a single post shows its title as the only h1, a Home breadcrumb and post navigation @fresh @single-post", async ({
  page,
}) => {
  await visitPostsIndex(page);
  const firstLink = page.getByRole("main").locator("article .entry-title a").first();
  const title = (await firstLink.innerText()).trim();

  await firstLink.click();
  await waitForPreloader(page);

  const h1 = page.locator("h1");
  await expect(h1).toHaveCount(1);
  await expect(h1).toHaveClass(/trail-title/);
  await expect(h1).toHaveText(title);

  // The trail opens with a.trail-home → get_home_url() (inc/extras.php:179).
  const home = page.locator("nav#flash-breadcrumbs .trail-begin a.trail-home");
  await expect(home).toHaveText("Home");
  expect(new URL((await home.getAttribute("href"))!, page.url()).pathname).toBe(
    new URL("/", page.url()).pathname,
  );

  await expect(page.getByRole("main").locator("article .entry-content")).toBeVisible();
  await expect(page.locator(".navigation.post-navigation")).toBeVisible();
});
