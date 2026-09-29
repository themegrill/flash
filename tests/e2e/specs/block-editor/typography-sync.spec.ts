import { test, expect } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";

test.use({ storageState: ADMIN_STATE });

/**
 * @area block-editor
 * @tier fresh
 * @source functions.php (flash_block_editor_dynamic_css, flash_block_editor_fonts)
 * @guards themegrill/flash-pro#39
 * @why The block editor's canvas used to show a hardcoded Montserrat/#333
 *      regardless of Customize > Global > Typography > Base, and even that
 *      hardcoded font never actually loaded inside the iframe (it was
 *      enqueued on a hook whose payload doesn't reach it). On a fresh/default
 *      install this guards that the canvas renders the theme's own
 *      documented default font, size and color, and that the actual Google
 *      Font file is requested inside the iframe - not just declared in CSS.
 */
test("the block editor canvas reflects the default body typography and loads the font @fresh @block-editor", async ({
  page,
}) => {
  test.skip(!hasAdminCredentials(), "needs TGQA_ADMIN_USER / TGQA_ADMIN_PASS");

  const fontRequest = page.waitForResponse(
    (response) =>
      response.url().includes("fonts.googleapis.com/css") &&
      response.url().includes("family=Montserrat"),
    { timeout: 15000 },
  );

  await page.goto("/wp-admin/post-new.php");

  const frame = page.frameLocator('iframe[name="editor-canvas"]');
  const wrapper = frame.locator(".editor-styles-wrapper").first();
  await expect(wrapper).toBeVisible();

  await expect(wrapper).toHaveCSS("font-family", /Montserrat/);
  await expect(wrapper).toHaveCSS("font-size", "14px");
  await expect(wrapper).toHaveCSS("color", "rgb(51, 51, 51)");

  await fontRequest;
});
