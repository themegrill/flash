import { expect, type Page } from "@playwright/test";

/**
 * Flash covers every page with #preloader-background and hides it 600 ms
 * after document.ready (js/flash.js:192-197). Anything clicked before then
 * lands on the overlay, so specs call this after every navigation. Resolves
 * immediately when the preloader is disabled (flash_disable_preloader) and the
 * element is not rendered at all (header.php:38).
 */
export async function waitForPreloader(page: Page): Promise<void> {
  await expect(page.locator("#preloader-background")).toBeHidden({ timeout: 10_000 });
}

/** Navigates and waits until the page is usable, returning the response. */
export async function visit(page: Page, url: string) {
  const response = await page.goto(url);
  await waitForPreloader(page);
  return response;
}

/**
 * Opens the posts index, wherever this site keeps it. A site with a static
 * front page lists posts on its posts page (/blog/ on the demo sites); a fresh
 * Playground boot creates a "Blog" page but leaves show_on_front = posts, so
 * the index is the front page and /blog/ is an ordinary empty page. WordPress
 * marks the index with body class `blog` (is_home), so try /blog/ first and
 * fall back to /. Returns whether the index is also the front page.
 */
export async function visitPostsIndex(page: Page): Promise<{ isFrontPage: boolean }> {
  await visit(page, "/blog/");
  if (await page.locator("body.blog").count()) return { isFrontPage: false };

  await visit(page, "/");
  await expect(page.locator("body.blog"), "no posts index at /blog/ or /").toHaveCount(1);
  return { isFrontPage: true };
}
