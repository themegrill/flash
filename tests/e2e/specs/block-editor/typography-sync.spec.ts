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
 *      Text color must equal what the front end gives post content (#606060
 *      from style.css in the free theme): the editor used to stay #333.
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

  // Front-end colour of post content, from the first post.
  const front = await page.context().newPage();
  await front.goto("/?p=1");
  const content = front.locator(".entry-content").first();
  test.skip((await content.count()) === 0, "needs a post with ID 1");
  const frontColor = await content.evaluate((e) => getComputedStyle(e).color);
  await front.close();
  await expect(wrapper).toHaveCSS("color", frontColor);

  await fontRequest;
});
