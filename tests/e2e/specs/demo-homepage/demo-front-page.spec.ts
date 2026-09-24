import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

/**
 * @area demo-homepage
 * @tier demo
 * @source flash-qa-report.html "Tested — No Issue Found (Flash Free)" 2026-09-18
 * @why After a Starter Templates import the front page is a SiteOrigin layout
 *      (page-templates/pagebuilder.php) of Flash Toolkit widgets, and the QA pass
 *      found it rendering sliders, portfolio, testimonials and the blog section
 *      with no console errors. Needs Flash Toolkit, SiteOrigin and an imported
 *      demo; skips on a site without them.
 */
test("the imported demo front page renders its Flash Toolkit sections @demo @demo-homepage", async ({
  page,
}) => {
  const errors: string[] = [];
  page.on("pageerror", (err) => errors.push(err.message));

  await visit(page, "/");
  const layout = page.locator(".panel-layout");
  test.skip((await layout.count()) === 0, "front page is not a SiteOrigin layout (no demo imported)");

  await expect(layout.locator(".panel-grid").first()).toBeVisible();
  expect(await layout.locator("[class*='widget_themegrill_flash_']").count()).toBeGreaterThan(0);
  expect(errors, `page errors: ${errors.join("; ")}`).toEqual([]);
});

/**
 * @area demo-homepage
 * @tier demo
 * @source flash-qa-report.html INVESTIGATION-01; header.php:69-80
 * @why The demo configures the header top bar (flash_top_header on, with
 *      left/right content); it renders above the primary header with that
 *      content visible.
 */
test("the header top bar shows the demo's contact content @demo @demo-homepage", async ({
  page,
}) => {
  await visit(page, "/");
  const top = page.locator("#masthead .header-top");
  test.skip((await top.count()) === 0, "top bar disabled on this site");

  await expect(top).toBeVisible();
  await expect(top).not.toHaveText(/^\s*$/);
});
