import { test, expect, expectLoggedOut } from "../../fixtures";
import { waitForPreloader } from "../../utils/page";

/**
 * @area homepage
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ, PHP runtime matrix) 2026-09-21
 * @why The baseline every other spec assumes: the front page serves 200, logs
 *      no console or page errors, and the preloader overlay that header.php:38
 *      renders by default is hidden by js/flash.js:192-197 (~600 ms after
 *      ready). If flash.js throws before that line the overlay stays over the
 *      whole site, which is how FLASH-001 presents. Does not assert layout.
 */
test("front page serves with no console errors and the preloader clears @fresh @homepage", async ({
  page,
}) => {
  const errors: string[] = [];
  page.on("console", (msg) => {
    if (msg.type() === "error") errors.push(msg.text());
  });
  page.on("pageerror", (err) => errors.push(`pageerror: ${err.message}`));

  const response = await page.goto("/");
  expect(response?.ok()).toBeTruthy();
  await waitForPreloader(page);

  expect(errors, `unexpected console errors: ${errors.join("; ")}`).toEqual([]);
});

/**
 * @area homepage
 * @tier fresh
 * @source themegrill/flash-pro#21
 * @guards themegrill/flash-pro#21
 * @why functions.php:flash_scripts() used to enqueue css/solid.min.css,
 *      css/regular.min.css and css/brands.min.css alongside css/all.min.css,
 *      even though all.min.css already ships its own byte-identical copy of
 *      every rule (and @font-face) those three files contain - verified by
 *      diffing every rule block between the files. Guards the actual enqueue
 *      change (the three redundant requests must be gone, the two real ones
 *      must remain) and that the header search icon (searchform.php /
 *      header.php) still resolves a glyph.
 */
test("redundant Font Awesome stylesheets are no longer requested and the header search icon still renders @fresh @homepage", async ({
  page,
}) => {
  const faRequests: string[] = [];
  page.on("request", (req) => {
    const match = req.url().match(/\/css\/(all|solid|regular|brands|v4-shims)(?:\.min)?\.css/);
    if (match) faRequests.push(match[1]);
  });

  await page.goto("/");
  await waitForPreloader(page);

  expect(faRequests, "all.min.css should still be requested").toContain("all");
  expect(faRequests, "v4-shims.min.css should still be requested").toContain("v4-shims");
  expect(faRequests, "solid.min.css is redundant with all.min.css").not.toContain("solid");
  expect(faRequests, "regular.min.css is redundant with all.min.css").not.toContain("regular");
  expect(faRequests, "brands.min.css is redundant with all.min.css").not.toContain("brands");

  const icon = page.locator(".search-wrap .search-icon .fa-search");
  await expect(icon).toBeVisible();
  const glyph = await icon.evaluate(
    (el) => getComputedStyle(el, "::before").content,
  );
  expect(glyph, "search icon glyph should still resolve").not.toBe("none");
  expect(glyph.replace(/['"]/g, "").trim().length).toBeGreaterThan(0);
});

/**
 * @area homepage
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ headings) 2026-09-21
 * @why header.php:100-102 renders the site title as the page's h1 only on the
 *      front page (a <p> elsewhere). The audit counted exactly one h1 on `/`.
 *      Guards against a second h1 creeping in from the page header bar.
 */
test("front page has the site title as its only h1 @fresh @homepage", async ({ page }) => {
  await page.goto("/");

  const h1 = page.locator("h1");
  await expect(h1).toHaveCount(1);
  await expect(h1).toHaveClass(/site-title/);
  await expect(h1.getByRole("link")).toHaveAttribute("rel", "home");
});

/**
 * @area homepage
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (mobile Tab order, MOBJ) 2026-09-21
 * @why header.php:59 renders "Skip to content" as the first focusable element,
 *      targeting <div id="content"> (header.php:211). The audit recorded it as
 *      the first Tab stop. Does not assert its styling.
 */
test("skip link is the first Tab stop and targets the content region @fresh @homepage", async ({
  page,
}) => {
  await page.goto("/");
  await expectLoggedOut(page);
  await waitForPreloader(page);
  await page.keyboard.press("Tab");

  const skip = page.getByRole("link", { name: "Skip to content" });
  await expect(skip).toBeFocused();
  await expect(skip).toHaveAttribute("href", "#content");
  await expect(page.locator("#content")).toHaveCount(1);
});
