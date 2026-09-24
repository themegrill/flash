import { test, expect } from "../../fixtures";
import { visit } from "../../utils/page";

for (const width of [768, 375]) {
  /**
   * @area mobile-menu
   * @tier fresh
   * @source flash-free-pro-senior-dev-audit.html (DOMJ, MOBJ) 2026-09-21
   * @why The audit measured `.menu-toggle` as display:none at 1366 px and
   *      visible at 768 and 375 px, with the menu collapsed until it is tapped;
   *      js/flash.js:92-96 slideToggles `.main-navigation .menu`. Guards open and
   *      close at the two widths the audit verified. Does not cover submenus.
   */
  test(`hamburger opens and closes the primary menu at ${width} px @fresh @mobile-menu`, async ({
    page,
  }) => {
    await page.setViewportSize({ width, height: 900 });
    await visit(page, "/");

    const nav = page.locator("#site-navigation");
    const toggle = nav.locator(".menu-toggle");
    const menu = nav.locator(".menu").first();

    await expect(toggle).toBeVisible();
    await expect(menu).toBeHidden();
    await expect(menu).toHaveCSS("display", "none");

    await toggle.click();
    await expect(menu).toBeVisible();
    await expect(menu.getByRole("link").first()).toBeVisible();

    await toggle.click();
    await expect(menu).toBeHidden();
  });
}

/**
 * @area mobile-menu
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html (DOMJ) 2026-09-21
 * @why At desktop width the hamburger is hidden and the menu is inline.
 */
test("desktop shows the primary menu inline with no hamburger @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 900 });
  await visit(page, "/");

  const nav = page.locator("#site-navigation");
  await expect(nav.locator(".menu-toggle")).toBeHidden();
  // The <ul> has zero height (floated items), so Playwright calls the list
  // itself hidden. Assert on its links instead.
  await expect(nav.locator(".menu").first().getByRole("link").first()).toBeVisible();
});

// Quarantined: open bug. Drop `.fixme` in the PR that fixes it.
/**
 * @area mobile-menu
 * @tier fresh
 * @source flash-free-pro-senior-dev-audit.html FLASH-014, 2026-09-21
 * @guards themegrill/flash-pro#90
 * @why `.menu-toggle` is a <div> with no role, name or tabindex
 *      (header.php:117-119), so keyboard users cannot open the menu.
 */
test.fixme("the hamburger is a named, keyboard-operable button @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize({ width: 768, height: 900 });
  await visit(page, "/");

  const toggle = page.locator("#site-navigation").getByRole("button", { name: /menu/i });
  await toggle.focus();
  await page.keyboard.press("Enter");
  await expect(toggle).toHaveAttribute("aria-expanded", "true");
});
