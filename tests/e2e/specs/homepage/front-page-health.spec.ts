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
