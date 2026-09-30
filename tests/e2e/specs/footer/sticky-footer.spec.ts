import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

/**
 * @area footer
 * @tier fresh
 * @source style.css:828-843
 * @guards themegrill/flash-pro#46
 * @why .site (the #page wrapper) had no height rules, so on any page
 *      shorter than the viewport the footer ended wherever content ended and
 *      the rest of the viewport showed plain background - confirmed live.
 *      .site is now a min-height:100vh flex column with .site-content set
 *      to grow, so the footer always lands flush with the bottom of the
 *      document on short pages.
 */
test("the footer has no empty gap below it on a page shorter than the viewport @fresh @footer", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 1200 });
  await visit(page, "/sample-page/");

  const footer = page.locator("#colophon");
  const footerBox = await footer.boundingBox();
  const documentHeight = await page.evaluate(() => document.documentElement.scrollHeight);

  test.skip(!footerBox, "no #colophon on this site");
  expect(documentHeight - footerBox!.y - footerBox!.height).toBeLessThanOrEqual(1);
});

/**
 * @area footer
 * @tier fresh
 * @source style.css:828-843
 * @guards themegrill/flash-pro#46
 * @why The min-height:100vh flex column must not clip or overlap content
 *      once real content exceeds the viewport - only the empty-space case
 *      should be fixed, not the normal scrolling case.
 */
test("the footer does not overlap content on a page taller than the viewport @fresh @footer", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 300 });
  await visit(page, "/sample-page/");

  const content = page.locator(".site-content");
  const footer = page.locator("#colophon");
  const contentBox = await content.boundingBox();
  const footerBox = await footer.boundingBox();

  test.skip(!contentBox || !footerBox, "no .site-content or #colophon on this site");
  expect(footerBox!.y).toBeGreaterThanOrEqual(contentBox!.y + contentBox!.height - 1);

  const documentHeight = await page.evaluate(() => document.documentElement.scrollHeight);
  expect(documentHeight).toBeGreaterThan(300);
});
