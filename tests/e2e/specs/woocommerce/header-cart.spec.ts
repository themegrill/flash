import { test, expect } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";
import { visit } from "../../utils/page";

/**
 * WooCommerce's "coming soon" store mode hides the shop from visitors and
 * switches itself back on whenever WooCommerce is toggled (audit NOTES,
 * 2026-09-21), so these run as the saved admin, who always sees the store.
 */
test.use({ storageState: ADMIN_STATE });

test.beforeEach(async ({ page }) => {
  test.skip(!hasAdminCredentials(), "needs TGQA_ADMIN_USER / TGQA_ADMIN_PASS");
  await visit(page, "/shop/");
  test.skip(
    (await page.locator("#masthead .cart-wrap").count()) === 0,
    "WooCommerce is not active (header.php:158 renders no cart)",
  );
});

/**
 * @area woocommerce
 * @tier demo
 * @source flash-qa-report.html "Tested — No Issue Found (WooCommerce)" 2026-09-18
 * @why AJAX add-to-cart on /shop/ immediately updates the header cart count
 *      through flash_woocommerce_header_add_to_cart_fragment
 *      (inc/woocommerce.php:37-58). Asserts the count goes up by one rather
 *      than an absolute value, because the admin's cart persists, and removes
 *      the added line afterwards.
 */
test("adding a product from the shop bumps the header cart count @demo @woocommerce", async ({
  page,
}) => {
  const count = page.locator("#masthead .header-action-container .cart-value");
  const before = Number((await count.innerText()).trim());

  const product = page.locator("ul.products li.product").filter({
    has: page.locator(".ajax_add_to_cart"),
  }).first();
  const name = (await product.locator(".woocommerce-loop-product__title").innerText()).trim();
  await product.locator(".ajax_add_to_cart").click();

  await expect(count).toHaveText(String(before + 1));

  // Leave the persistent cart as it was.
  await visit(page, "/cart/");
  const line = page.locator("tr.cart_item, .wc-block-cart-items__row").filter({ hasText: name }).first();
  await line.locator("a.remove, .wc-block-cart-item__remove-link").first().click();
  await expect(line).toHaveCount(0);
  // The header count is server-rendered; reload before comparing.
  await visit(page, "/cart/");
  await expect(page.locator("#masthead .header-action-container .cart-value")).toHaveText(String(before));
});

/**
 * @area woocommerce
 * @tier demo
 * @source flash-qa-report.html "Tested — No Issue Found (WooCommerce)" 2026-09-18
 * @why A sale product shows WooCommerce's "Sale!" badge and a struck-through
 *      regular price next to the sale price in the Flash shop grid. Skips if the
 *      store has no product on sale.
 */
test("a sale product shows the Sale badge and a struck-through price @demo @woocommerce", async ({
  page,
}) => {
  const sale = page.locator("ul.products li.product.sale").first();
  test.skip((await sale.count()) === 0, "no product on sale in this store");

  await expect(sale.locator(".onsale")).toHaveText("Sale!");
  await expect(sale.locator(".price del")).toBeVisible();
  await expect(sale.locator(".price ins")).toBeVisible();
});
