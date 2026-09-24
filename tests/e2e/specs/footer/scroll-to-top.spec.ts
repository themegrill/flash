import { test, expect } from "../../fixtures";
import { visitPostsIndex } from "../../utils/page";

/**
 * @area footer
 * @tier fresh
 * @source flash-qa-report.html "Tested — No Issue Found (Flash Free)" 2026-09-18;
 *         js/flash.js:160-185
 * @why footer.php:49 renders `a#scroll-up` unless flash_disable_back_to_top.
 *      flash.js hides it on ready, fades it in past 1000 px of scroll, and
 *      animates back to the top on click. The QA pass verified all three.
 */
test("scroll-to-top appears after scrolling and returns to the top @fresh @footer", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 900 });
  await visitPostsIndex(page);

  const button = page.locator("a#scroll-up");
  await expect(button).toBeHidden();

  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  const scrolled = await page.evaluate(() => window.scrollY);
  test.skip(scrolled <= 1000, `page is only ${scrolled}px scrollable; needs > 1000 px of content`);

  await expect(button).toBeVisible();
  await button.click();
  await expect.poll(() => page.evaluate(() => window.scrollY)).toBe(0);
});
